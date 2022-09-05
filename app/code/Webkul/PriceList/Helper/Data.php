<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public $printPreQuery = false;

    public $printPostQuery = false;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    protected $httpContext;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\CartFactory $cart
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\CartFactory $cart,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Webkul\PriceList\Model\ItemsFactory $items,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\GroupedProduct\Model\Product\Type\Grouped $grouped = null,
        \Webkul\PriceList\Logger\Logger $logger = null,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null,
        \Magento\Framework\Pricing\Helper\Data $priceData = null,
        \Magento\Bundle\Model\ResourceModel\Option\CollectionFactory $collectionFactory
    ) {
        $this->_request = $context->getRequest();
        $this->_resource = $resource;
        $this->_customerSession = $customerSession;
        $this->_cart = $cart;
        $this->_timezone = $timezone;
        $this->_items = $items;
        $this->httpContext = $httpContext;
        $this->productFactory = $productFactory;
        $this->grouped = $grouped  ?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\GroupedProduct\Model\Product\Type\Grouped::class);
        $this->logger = $logger  ?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Webkul\PriceList\Logger\Logger::class);
        $this->scopeConfig = $scopeConfig ?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        $this->priceData = $priceData ?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Framework\Pricing\Helper\Data::class);
        $this->collectionFactory = $collectionFactory?: \Magento\Framework\App\ObjectManager::getInstance()
        ->get(\Magento\Bundle\Model\ResourceModel\Option\CollectionFactory::class);
        parent::__construct($context);
    }

    public function getPrice($product, $price)
    {
        $ruleDetails = $this->getPreAppliedRuleDetails($product);
        return $this->getFinalPrice($ruleDetails, $product, $price);
    }

    /**
     * to check whether module is enable
     *
     * @return boolean
     */
    public function isModuleEnable()
    {
        return $this->scopeConfig->getValue(
            'pricelist/settings/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Original Price of Product
     * created to get original prie in cart
     */
    public function getOriginalPrice($product, $price, $ruleDetails)
    {
        if ($ruleDetails['rule_id'] > 0) {
            $amount = $ruleDetails['amount'];
            if ($ruleDetails['fixed']) {
                if ($ruleDetails['discount']) {
                    $price = $price + $amount;
                } else {
                    $price = $price - $amount;
                }
            } else {
                if ($ruleDetails['discount']) {
                    $price = ($price * 100) / (100 - $amount);
                } else {
                    $price = ($price * 100) / (100 + $amount);
                }
            }
        }
        return $price;
    }

    public function getPostAppliedRuleDetails($product, $qty, $total, $exclude = false)
    {
        $details = ['amount' => 0, 'rule_id' => 0, "discount" => true, 'fixed' => true];
        $customerId = 0;
        $customerGroupId = 0;
        if ($this->checkLogin()) {
            $customerId = $this->getCustomerId();
            $customerGroupId = $this->getCustomerGroupId();
        }
        $categoyIds = $product->getCategoryIds();
        if ($product->getParentProductId() != null) {
            $parentProduct = $this->productFactory->create()->load($product->getParentProductId());
            $categoyIds = array_merge($categoyIds, $parentProduct->getCategoryIds());
        } elseif ($product->getData('_linked_to_product_id') != null) {
            $parentProduct = $this->productFactory->create()->load($product->getData('_linked_to_product_id'));
            $categoyIds = array_merge($categoyIds, $parentProduct->getCategoryIds());
        }
        $collection = $this->_items->create()->getCollection();
        $collection = $this->joinRules($collection);
        $collection = $this->joinAssignedRules($collection);
        $collection = $this->joinUser($collection);
        $collection = $this->joinPriceList($collection);
        $today = $this->_timezone->date()->format('Y-m-d');
        $sql = '(';
        if ($exclude) {
            $sql .= '(main_table.entity_type= 3 and main_table.entity_value <= ' . $qty . ')';
            $sql .= ' or (main_table.entity_type= 4 and main_table.entity_value <= ' . $total . ')';
            $sql .= ')';
            $sql .= ' and (';
            $sql .= '(pricelist.start_date <="' . $today . '" and pricelist.end_date >="' . $today . '") and';
            $sql .= ' rule.status = 1 and pricelist.status = 1';
            $sql .= ' and rule.is_combination=0';
            $sql .= ' and ((user.type = 1 and user.user_id = ' . $customerId . ') 
            or (user.type = 2 and user.user_id = ' . $customerGroupId . '))';
            $sql .= ')';
        } else {
            $sql .= '(main_table.entity_type= 1 and main_table.entity_value = ' . $product->getId() . ')';
            foreach ($categoyIds as $categoyId) {
                $sql .= ' or (main_table.entity_type= 2 and main_table.entity_value = ' . $categoyId . ')';
            }
            $sql .= ' or (main_table.entity_type= 3 and main_table.entity_value <= ' . $qty . ')';
            $sql .= ' or (main_table.entity_type= 4 and main_table.entity_value <= ' . $total . ')';
            $sql .= ')';
            $sql .= ' and (';
            $sql .= '(pricelist.start_date <="' . $today . '" and pricelist.end_date >="' . $today . '") and';
            $sql .= ' rule.status = 1 and pricelist.status = 1';
            $sql .= ' and rule.is_combination=0';
            $sql .= ' and ((user.type = 1 and user.user_id = ' . $customerId . ') 
            or (user.type = 2 and user.user_id = ' . $customerGroupId . '))';
            $sql .= ')';
        }
        $collection->getSelect()->where($sql);
        $collection->getSelect()->order('pricelist.priority', 'ASC');
        $collection->getSelect()->order('rule.priority', 'ASC');
        $collection->getSelect()->order('rule.id', 'ASC');
        $collection->getSelect()->order('main_table.id', 'ASC');

        $collection->getSelect()->limit(1);
        if ($collection->getSize()) {
            foreach ($collection as $item) {
                $item->getPricelistPriority();
                $calculationType = $item->getCalculationType();
                $priceType = $item->getPriceType();
                $amount = $item->getAmount();
                if ($priceType == 2) { // percent amount
                    $details['fixed'] = false;
                }
                if ($calculationType == 1) { // increase price
                    $details['discount'] = false;
                }
                $details['rule_id'] = $item->getRuleId();
                $details['amount'] = $amount;
                $details['rule_priority'] = $item->getRulePriority();
                $details['pricelist_priority'] = $item->getPricelistPriority();
            }
        }
        return $details;
    }

    public function joinRules($collection)
    {
        $joinTable = $this->_resource->getTableName('wk_pricelist_rule');
        $sql = 'main_table.parent_id = rule.id';
        $fields = ['calculation_type', 'price_type', 'amount', 'status', 'priority as rule_priority'];
        $collection->getSelect()->join($joinTable . ' as rule', $sql, $fields);
        $collection->addFilterToMap('id', 'main_table.id');
        return $collection;
    }

    public function joinAssignedRules($collection)
    {
        $joinTable = $this->_resource->getTableName('wk_pricelist_assigned_rule');
        $sql = 'main_table.parent_id = assigned_rule.rule_id';
        $fields = ['pricelist_id', 'rule_id'];
        $collection->getSelect()->join($joinTable . ' as assigned_rule', $sql, $fields);
        return $collection;
    }

    public function joinUser($collection)
    {
        $joinTable = $this->_resource->getTableName('wk_pricelist_user_details');
        $sql = 'assigned_rule.pricelist_id = user.pricelist_id';
        $fields = ['pricelist_id', 'user_id', 'type'];
        $collection->getSelect()->join($joinTable . ' as user', $sql, $fields);
        return $collection;
    }

    public function joinPriceList($collection)
    {
        $joinTable = $this->_resource->getTableName('wk_pricelist_list');
        $sql = 'pricelist.id = user.pricelist_id';
        $fields = ['priority as pricelist_priority', 'status'];
        $collection->getSelect()->join($joinTable . ' as pricelist', $sql, $fields);
        return $collection;
    }

    public function getProductFilterQuery($product)
    {
        $sql = '(main_table.entity_type= 1 and main_table.entity_value = ' . $product->getId() . ')';
        return $sql;
    }

    public function getCategoryFilterQuery($product)
    {
        $categoyIds = $product->getCategoryIds();
        $sql = [];
        foreach ($categoyIds as $categoyId) {
             $sql[] = '(main_table.entity_type= 2 and main_table.entity_value = ' . $categoyId . ")";
        }
        $sql = implode(" or ", $sql);
        return $sql;
    }

    public function getStatusFilterQuery()
    {
        $sql = ' rule.status = 1 and pricelist.status = 1';
        return $sql;
    }

    public function getPreAppliedRuleDetails($product, $excludeCartRule = false)
    {
        $details = ['amount' => 0, 'rule_id' => 0, "discount" => true, 'fixed' => true];
        if ($product->getId()) {
            $total = (float) $product->getData("price");
            $customerId = 0;
            $customerGroupId = 0;
            if ($this->checkLogin() || $this->_customerSession->getCustomer()->getId()) {
                $customerId = $this->getCustomerId();
                $customerGroupId = $this->getCustomerGroupId();
                $customerId = $customerId ? $customerId : $this->_customerSession->getCustomer()->getId();
                $customerGroupId = $customerGroupId ? $customerGroupId :
                $this->_customerSession->getCustomer()->getGroupId();
            }
            $categoyIds = $product->getCategoryIds();
            if ($product->getOptionId()!=null || $product->getParentProductId() != null) {
                $parentProductId = $this->getParentProductIdByOptionId($product->getOptionId());
                $parentProductId = $parentProductId != null ? $parentProductId : $product->getParentProductId();
                $parentProduct = $this->productFactory->create()->load($parentProductId);
                $categoyIds = array_merge($categoyIds, $parentProduct->getCategoryIds());
            } elseif ($product->getData('_linked_to_product_id') != null) {
                $parentProduct = $this->productFactory->create()->load($product->getData('_linked_to_product_id'));
                $categoyIds = array_merge($categoyIds, $parentProduct->getCategoryIds());
            }
            $collection = $this->_items->create()->getCollection();
            $collection = $this->joinRules($collection);
            $collection = $this->joinAssignedRules($collection);
            $collection = $this->joinUser($collection);
            $collection = $this->joinPriceList($collection);

            $today = $this->_timezone->date()->format('Y-m-d');
            $sql = "(";
            $sql .= '(main_table.entity_type= 1 and main_table.entity_value = ' . $product->getId() . ")";
            foreach ($categoyIds as $categoyId) {
                $sql .= ' or (main_table.entity_type= 2 and main_table.entity_value = ' . $categoyId . ")";
            }
            if ($excludeCartRule) {
                $sql .= ' or (main_table.entity_type= 3 and main_table.entity_value = 1)';
                $sql .= ' or (main_table.entity_type= 4 and main_table.entity_value <= ' . $total . ')';
            }
            $sql .= ")";
            $sql .= ' and (';
            $sql .= '(pricelist.start_date <="' . $today . '" and pricelist.end_date >="' . $today . '") and';
            $sql .= ' rule.status = 1 and pricelist.status = 1';
            $sql .= ' and rule.is_combination=0';
            $sql .= ' and ((user.type = 1 and user.user_id = ' . $customerId . ') 
            or (user.type = 2 and user.user_id = ' . $customerGroupId . '))';
            $sql .= ')';
            $collection->getSelect()->where($sql);

            $collection->getSelect()->order('pricelist.priority', 'ASC');
            $collection->getSelect()->order('rule.priority', 'ASC');
            $collection->getSelect()->order('rule.id', 'ASC');
            $collection->getSelect()->order('main_table.id', 'ASC');
            $collection->getSelect()->group('main_table.parent_id');
            $collection->getSelect()->limit(1);
            if ($collection->getSize()) {
                foreach ($collection as $item) {
                    $item->getPricelistPriority();
                    $calculationType = $item->getCalculationType();
                    $priceType = $item->getPriceType();
                    $amount = $item->getAmount();
                    if ($priceType == 2) {
                        $details['fixed'] = false;
                    }
                    if ($calculationType == 1) {
                        $details['discount'] = false;
                    }
                    $details['rule_id'] = $item->getRuleId();
                    $details['amount'] = $amount;
                    $details['rule_priority'] = $item->getRulePriority();
                    $details['pricelist_priority'] = $item->getPricelistPriority();
                }
            }
        }
        return $details;
    }

    /**
     * get parent product id by option id
     *
     * @param [type] $optionId
     * @return int
     */
    public function getParentProductIdByOptionId($optionId)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('option_id', ['eq'=>$optionId])->getFirstItem();
        $parentId = null;
        foreach ($collection as $record) {
            $parentId = (int)$record->getParentId();
        }
        return $parentId;
    }

    public function getCalculationTypeOptions()
    {
        $options = [];
        $options[1] = __('Increase Price');
        $options[2] = __('Decrease Price');
        return $options;
    }

    public function getPriceTypeOptions()
    {
        $options = [];
        $options[1] = __('Fixed Price');
        $options[2] = __('Percent Price');
        return $options;
    }

    public function getStatusOptions()
    {
        $options = [];
        $options[1] = __('Active');
        $options[2] = __('Deactivate');
        return $options;
    }
    
    public function getCustomOptionPrice($item, $price)
    {
        $customOptionPrice = 0;
        $product = $item->getProduct();
        $customOptions = $item->getProduct()
            ->getTypeInstance(true)
            ->getOrderOptions($item->getProduct());
        $infoBuyRequest = $customOptions['info_buyRequest'];
        try {
            if (array_key_exists("options", $infoBuyRequest)) {
                $selectedOptions = $infoBuyRequest['options'];
                $customOptionPrice = $this->getSelectedOptionPrice($product, $selectedOptions);
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
        return $customOptionPrice;
    }

    /**
     * get selected option price
     *
     * @param [type] $product
     * @param [type] $selectedOptions
     * @return string
     */
    public function getSelectedOptionPrice($product, $selectedOptions)
    {
        $customOptionPrice = 0;
        foreach ($product->getOptions() as $option) {
            $optionId = $option->getOptionId();
            if (array_key_exists($optionId, $selectedOptions)) {
                if (trim($selectedOptions[$optionId]) == "") {
                    continue;
                }
                $optionType = $option->getType();
                $singleValueOptions = ['drop_down', 'radio'];
                $multiValueOptions = ['checkbox', 'multiple'];
                if (in_array($optionType, $singleValueOptions)) {
                    $values = $option->getValues();
                    foreach ($values as $value) {
                        if ($value->getOptionTypeId() == $selectedOptions[$optionId]) {
                            $priceType = $value->getPriceType();
                            $optionPrice = $value->getPrice();
                            $optionPrice = $this->getOptionPrice($priceType, $price, $optionPrice);
                            $customOptionPrice += $optionPrice;
                        }
                    }
                } elseif (in_array($optionType, $multiValueOptions)) {
                    $values = $option->getValues();
                    foreach ($values as $value) {
                        if (in_array($value->getOptionTypeId(), $selectedOptions[$optionId])) {
                            $priceType = $value->getPriceType();
                            $optionPrice = $value->getPrice();
                            $optionPrice = $this->getOptionPrice($priceType, $price, $optionPrice);
                            $customOptionPrice += $optionPrice;
                        }
                    }
                } else {
                    $priceType = $option->getPriceType();
                    $optionPrice = $option->getPrice();
                    if ($priceType != "fixed") {
                        $optionPrice = ($price * $optionPrice) / 100;
                    }
                    $customOptionPrice += $optionPrice;
                }
            }
        }
        return $customOptionPrice;
    }

    /**
     * get option price
     *
     * @param [type] $priceType
     * @param [type] $price
     * @param [type] $optionPrice
     * @return string
     */
    public function getOptionPrice($priceType, $price, $optionPrice)
    {
        if ($priceType != "fixed") {
            $optionPrice = ($price * $optionPrice) / 100;
        }
        return $optionPrice;
    }
    public function processItemPrice($item, $parentItem = false, $useParent = false, $excludeCartRule = false)
    {
        $result = ['updated' => false];
        try {
            $preRuleApplied = false;
            $postRuleApplied = false;
            $cartItemPrice = $this->getOriginalPriceByItem($item);
            $originalCartItemPrice = $cartItemPrice;
            $product = $item->getProduct();
            $productData = $this->productFactory->create()->load($product->getEntityId());
            $qty = $item->getQty();
            $quoteStatus = 0;
            if ($productData->getQuoteStatus() != null) {
                $quoteStatus =$productData->getQuoteStatus();
            }
            if ($useParent) {
                $qty = $parentItem->getQty();
            }
            $parent_product_id = $this->getProductOptions($item);
            if (!empty($parentItem)) {
                $product['parent_product_id'] = $parentItem->getProductId();
            } elseif ($parent_product_id != null) {
                $product['parent_product_id'] = $parent_product_id;
            }
            $price = $product->getData("price");
            $originalCustomOptionPrice = $this->getCustomOptionPrice($item, $price);
            $preAppliedDetails = $this->getPreAppliedRuleDetails($product, $excludeCartRule);
            if ($preAppliedDetails['rule_id'] > 0) {
                $priceAfterRule = $this->getFinalPrice($preAppliedDetails, $product, $price);
                $customOptionPrice = $this->getCustomOptionPrice($item, $priceAfterRule);
                if ($preAppliedDetails['discount']) {
                    $differnce = $originalCustomOptionPrice - $customOptionPrice;
                    $differnce += $price - $priceAfterRule;
                    $originalCartItemPrice = $cartItemPrice + $differnce;
                } else {
                    $differnce = $customOptionPrice - $originalCustomOptionPrice;
                    $differnce += $priceAfterRule - $price;
                    $originalCartItemPrice = $cartItemPrice - $differnce;
                }
                $preRuleApplied = true;
            }
            $total = $originalCartItemPrice * $qty;
            $postAppliedDetails = $this->getPostAppliedRuleDetails($product, $qty, $total);
            if ($postAppliedDetails['rule_id'] > 0) {
                if ($preRuleApplied) {
                    
                    if ($postAppliedDetails['rule_id'] != $preAppliedDetails['rule_id']) {
                        if ($postAppliedDetails['pricelist_priority'] <= $preAppliedDetails['pricelist_priority']) {
                            $postRuleApplied = $this->checkPostRuleApplied($postAppliedDetails, $preAppliedDetails);
                        }
                    }
                } else {
                    $postRuleApplied = true;
                }
            }
            
            if (!$preAppliedDetails['rule_id']> 0 && !$postRuleApplied && $quoteStatus !=1) {
                $item->setOriginalCustomPrice($originalCartItemPrice);
                $item->setCustomPrice($originalCartItemPrice);
                $item->getProduct()->setIsSuperMode(true);
                $item->setRowTotal($item->getQty() * $originalCartItemPrice);
                $item->save();
            } elseif ($preAppliedDetails['rule_id']> 0 && !$postRuleApplied && $quoteStatus !=1) {
                $item->setOriginalCustomPrice($priceAfterRule);
                $item->setCustomPrice($priceAfterRule);
                $item->getProduct()->setIsSuperMode(true);
                $item->setRowTotal($item->getQty() * $priceAfterRule);
                $item->save();
            }
            if ($postRuleApplied && $quoteStatus !=1) {
                if ($preRuleApplied) { // need recalculation
                    if ($postAppliedDetails['discount']) {
                        $differnce = $originalCustomOptionPrice - $customOptionPrice;
                        $differnce += $price - $priceAfterRule;
                        $originalCartItemPrice = $cartItemPrice + $differnce;
                    } else {
                        $differnce = $customOptionPrice - $originalCustomOptionPrice;
                        $differnce += $priceAfterRule - $price;
                        $originalCartItemPrice = $cartItemPrice - $differnce;
                    }
                    $extraPrice = $originalCartItemPrice - $originalCustomOptionPrice - $price;
                } else {
                    $extraPrice = $originalCartItemPrice - $originalCustomOptionPrice - $price;
                }
                $finalPrice = $this->getFinalPrice($postAppliedDetails, $product, $price);
                $finalCustomOptionPrice = $this->getCustomOptionPrice($item, $finalPrice);
                $totalPrice = $extraPrice + $finalPrice + $finalCustomOptionPrice;
                $item->setOriginalCustomPrice($totalPrice);
                $item->setCustomPrice($totalPrice);
                $item->setRowTotal($item->getQty() * $totalPrice);
                $item->getProduct()->setIsSuperMode(true);
                $item->save();
                $result['updated'] = true;
                $result['price'] = $totalPrice;
                return $result;
            }
            $result['price'] = $cartItemPrice;
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
        return $result;
    }

    /**
     * check if post rule applied
     *
     * @param [type] $postAppliedDetails
     * @param [type] $preAppliedDetails
     * @return void
     */
    public function checkPostRuleApplied($postAppliedDetails, $preAppliedDetails)
    {
        $postRuleApplied = false;
        if ($postAppliedDetails['rule_priority'] < $preAppliedDetails['rule_priority']) {
            $postRuleApplied = true;
        }
        return $postRuleApplied;
    }

    /**
     * get selected grouped product option
     *
     * @param [type] $item
     * @return product id
     */
    public function getProductOptions($item)
    {
        $productOptions = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        $parent_product_id = '';
        if (array_key_exists('info_buyRequest', $productOptions)) {
            if (array_key_exists('super_product_config', $productOptions['info_buyRequest'])) {
                $selectedOptions = $productOptions['info_buyRequest']['super_product_config'];
                if ($selectedOptions['product_type'] == \Magento\GroupedProduct\Model\Product\Type\Grouped::TYPE_CODE) {
                    $parent_product_id = $selectedOptions['product_id'];
                }
            }
        }
        return $parent_product_id;
    }

    /**
     * Collect Totals
     *
     * @param object $quote
     */
    public function collectTotals($quote)
    {
        $itemDetails = [];
        $configItemIds = [];
        $bundleItemIds = [];
        $hasBundleProduct = false;
        $hasConfigProduct = false;
        foreach ($quote->getAllItems() as $item) {
            $this->refreshProductPrice($item);
            if ($item->getParentItem()) {
                $itemDetails[$item->getParentItem()->getId()][] = $item;
                continue;
            }
            if ($item->getProduct()->getTypeId() == "configurable") {
                $configItemIds[] = $item->getId();
                $hasConfigProduct = true;
                continue;
            }
            if ($item->getProduct()->getTypeId() == "bundle") {
                continue;
            }
            $this->processItemPrice($item, $item->getParentItem());
        }
       
        if ($hasConfigProduct) {
            $this->updateConfigItemPrice($configItemIds, $itemDetails);
        }
    }

    public function updateConfigItemPrice($configItemIds, $itemDetails)
    {
        try {
            foreach ($configItemIds as $itemId) {
                foreach ($itemDetails[$itemId] as $item) {
                    $parentItem = $item->getParentItem();
                    $result = $this->processItemPrice($item, $parentItem, true);
                    if ($result['updated']) {
                        $price = $result['price'];
                        $parentItem->setOriginalCustomPrice($price);
                        $parentItem->setRowTotal($parentItem->getQty() * $price);
                        $parentItem->getProduct()->setIsSuperMode(true);
                        $parentItem->save();
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }

    public function getOriginalPriceByItem($item)
    {
        $price = 0;
        $product = $item->getProduct();
        if ($item->getParentItem()) {
            $price = $item->getParentItem()
                ->getProduct()
                ->getPriceModel()
                ->getChildFinalPrice(
                    $item->getParentItem()->getProduct(),
                    $item->getParentItem()->getQty(),
                    $product,
                    $item->getQty()
                );
        } elseif (!$item->getParentItem()) {
            $price = $product->getFinalPrice($item->getQty());
            $price = $this->priceData->currency($price, false, false);
        }
        return $price;
    }

    /**
     * Refresh Product Price In Cart
     *
     * @param object $item
     */
    public function refreshProductPrice($item)
    {
        try {
            if (!$item->getCustomPrice()) {
                $item->setCustomPrice(null);
                $item->setOriginalCustomPrice(null);
                $item->getProduct()->setIsSuperMode(true);
                $item->save();
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }

    /**
     * Save Quote Item Updates
     *
     * @return string
     */
    public function checkStatus()
    {
        $this->_cart->create()->save();
    }

    public function getFinalPrice($ruleDetails, $product, $price)
    {
        if ($ruleDetails['rule_id'] > 0) {
            $amount = $ruleDetails['amount'];
            if (!$ruleDetails['fixed']) {
                $amount = ($price * $amount) / 100;
            }
            if ($product->getTypeId() == \Magento\Catalog\Model\Product\Type::TYPE_BUNDLE) {
                return $price;
            } else {
                if ($ruleDetails['discount']) {
                    $price -= $amount;
                } else {
                    $price += $amount;
                }
            }
                
        }

        return $price;
    }

    public function getDefaultPrice($ruleDetails, $price)
    {
        if ($ruleDetails['rule_id'] > 0) {
            $amount = $ruleDetails['amount'];
            if ($ruleDetails['fixed']) {
                if ($ruleDetails['discount']) {
                    $price = $price + $amount;
                } else {
                    $price = $price - $amount;
                }
            } else {
                if ($ruleDetails['discount']) {
                    $price = ($price * 100) / (100 - $amount);
                } else {
                    $price = ($price * 100) / (100 + $amount);
                }
            }
        }
        return $price;
    }

    public function printPostQuery()
    {
        return $this->printPostQuery;
    }

    public function printPreQuery()
    {
        return $this->printPreQuery;
    }

    /**
     * function to check the login status of customer
     *
     * @return boolean
     */
    public function checkLogin()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return $isLoggedIn;
    }

    /**
     * function to get customer id from context
     *
     * @return int customerId
     */
    public function getCustomerId()
    {
        $customerId = 0;
        if ($this->checkLogin()) {
            $customerId = $this->httpContext->getValue('customer_id');
        }
        return $customerId;
    }

    /**
     * get customer id from context
     *
     * @return void
     */
    public function getCustomerGroupId()
    {
        $customerGroup = $this->httpContext->getValue('customer_group');
        return $customerGroup;
    }
}
