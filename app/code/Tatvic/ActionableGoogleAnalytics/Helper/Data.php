<?php
namespace Tatvic\ActionableGoogleAnalytics\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
    protected $_tvc_ga_options;

    protected $tvc_categoryCollectionFactory;

    protected $tvc_registry;

    protected $categoryFactory;

    protected $cart;

    protected $order;

    protected $checkoutSession;

    protected $orderRepository;

    protected $storeManager;
    
    protected $customerSession;
    
    protected $tvc_cookieManager;
    
    protected $tvc_cookieMetaData;
    
    protected $sessionManager;
    
    protected $listProduct;
    
    protected $_toolbar;
    
    protected $productAttributeRepository;

    protected $productListBlockToolbar;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Sales\Model\Order $order,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetaData,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar,
        \Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
        \Magento\Catalog\Block\Product\ProductList\Toolbar $productListBlockToolbar
    ){
        parent::__construct($context);
        $this->_tvc_ga_options = $this->scopeConfig->getValue('tatvic_ee', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->tvc_categoryCollectionFactory = $categoryCollectionFactory;
        $this->tvc_registry = $registry;
        $this->categoryFactory = $categoryFactory;
        $this->cart = $cart;
        $this->order = $order;
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
        $this->storeManager    = $storeManager;
        $this->customerSession = $customerSession;
        $this->tvc_cookieManager = $cookieManager;
        $this->tvc_cookieMetaData = $cookieMetaData;
        $this->sessionManager = $sessionManager;
        $this->listProduct = $listProduct;
        $this->_toolbar = $toolbar;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productListBlockToolbar = $productListBlockToolbar;

    }
    public function isEnabled() {
        return $this->_tvc_ga_options['general']['enable'];
    }
    public function getUaID() {
        
        return $this->_tvc_ga_options['general']['ua_id'];
    }
    public function checkDf_enabled() {
        return $this->_tvc_ga_options['general']['enableDF'];
    }
    public function checkIP_enabled(){
        return $this->_tvc_ga_options['general']['enableIP'];
    }
    public function checkUserId_Enabled(){
        return $this->_tvc_ga_options['general']['enableUserID'];
    }
    public function checkClientId_Enabled(){
        return $this->_tvc_ga_options['general']['enableClientID'];
    }
    public function checkOptOut_Enabled(){
        return $this->_tvc_ga_options['general']['enableOptOut'];
    }
    public function checkAdwords_Enabled(){
        return $this->_tvc_ga_options['conversion']['advenable'];
    }
    public function checkFbpixelEnabled(){
        return $this->_tvc_ga_options['conversion']['fbPixelenable'];
    }
    public function getAdwordsID(){
        return $this->_tvc_ga_options['conversion']['adv_id'];
    }
    public function getAdwordsLabel(){
        return $this->_tvc_ga_options['conversion']['adv_label'];
    }
    public function getFBPixelID(){
        $fb_id = !empty($this->_tvc_ga_options['conversion']['fb_id']) ? $this->_tvc_ga_options['conversion']['fb_id'] : '';
        return $fb_id;
    }
    protected function getCurrentProduct()
    {
        return $this->tvc_registry->registry('current_product');
    }
    protected function getCurrentCategoryID()
    {
        return $this->tvc_registry->registry('current_category')->getId();
    }
    protected function getCurrentCategoryName()
    {
        return $this->tvc_registry->registry('current_category')->getName();
    }
    protected function setPageLimit(){
        $pageSize = $this->productListBlockToolbar->getLimit() ? $this->productListBlockToolbar->getLimit() : 9;
        return $pageSize;
    }
    protected function getCurrentPage(){
         $page= ($this->_request->getParam('p')) ? $this->_request->getParam('p') : 1;
         return $page;
    }
    protected function getCategoryByIds($tvc_cat_ids){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $tvc_cat_names = array();
        foreach($tvc_cat_ids as $category){
            $cat = $objectManager->create('Magento\Catalog\Model\Category')->load($category);
            $tvc_cat_names[] = $cat->getName();
        }
        $tvc_category = implode('/', $tvc_cat_names);
        
        return $tvc_category;
    }
    public function getCategoryProduct()
    {
        $tvc_catProd = [];
        $tvc_cat_name = $this->getCurrentCategoryName();
        $tvc_cat_id   = $this->getCurrentCategoryID();
        $tvc_category   = $this->categoryFactory->create()->load($tvc_cat_id);
        $tvc_collection = $this->tvc_categoryCollectionFactory->create();
        $tvc_collection->addAttributeToSelect('*');
        $tvc_collection->addCategoryFilter($tvc_category);
        if($this->_request->getParam('product_list_order')) {
            $tvc_collection->addAttributeToSort($this->_request->getParam('product_list_order'));
         }
         else{
            $tvc_collection->setOrder('position');
         }
         $tvc_collection->setCurPage($this->_toolbar->getCurrentPage());
         $tvc_collection->setPageSize($this->setPageLimit());
         $tvc_metaData = $this->tvc_cookieMetaData->createPublicCookieMetadata()->setPath($this->sessionManager->getCookiePath());
         $this->tvc_cookieManager->setPublicCookie('tvc_list', 'Category Page', $tvc_metaData);
        foreach ($tvc_collection as $product) {
             $prod_arr = ['tvc_id' => $product->getId(),
                     'tvc_i'    => $product->getSku(),
                     'tvc_name' => $product->getName(),
                     'tvc_p'    => $product->getFinalPrice(),
                     'tvc_url'  => $product->getProductUrl(),
                     'tvc_c'    => $tvc_cat_name
             ];
             array_push($tvc_catProd, $prod_arr);
        }
        return $tvc_catProd;
    }
    public function getProductDetails(){
        $tvc_cat_ids = $this->getCurrentProduct()->getCategoryIds();
        $tvc_category = $this->getCategoryByIds($tvc_cat_ids);
        $tvc_metaData = $this->tvc_cookieMetaData->createPublicCookieMetadata()->setPath($this->sessionManager->getCookiePath());
        $size = $this->getCurrentProduct()->getResource()->getAttribute('color');
        $tvc_prod_details = [
            'tvc_id'=>$this->getCurrentProduct()->getId() ,
            'tvc_i' => $this->getCurrentProduct()->getSku(),
            'tvc_name' => $this->getCurrentProduct()->getName(),
            'tvc_p' => $this->getCurrentProduct()->getFinalPrice(),
            'tvc_c' => $tvc_category,
            'tvc_list' => $this->tvc_cookieManager->getCookie('tvc_list')
        ];
        $this->tvc_cookieManager->deleteCookie('tvc_list',$tvc_metaData);
        return $tvc_prod_details;
    }

    public function getCartpageInfo(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $items = $this->cart->getQuote()->getAllVisibleItems();
        $tvc_cart = [];
       foreach($items as $product){
        $tvc_cat_ids = $product->getProduct()->getCategoryIds();
        $tvc_category = $this->getCategoryByIds($tvc_cat_ids);
            $prod_arr = ['tvc_id' => $product->getId(),
                'tvc_i'    => $product->getSku(),
                'tvc_name' => $product->getName(),
                'tvc_p'    => $product->getPrice(),
                'tvc_q'    => $product->getQty(),
                'tvc_c'    => $tvc_category
            ];
            array_push($tvc_cart, $prod_arr);
       }
       return $tvc_cart;
    }

    public function getOrderDetails(){
        $tvc_order = $this->getTotalOrder();
        $tvc_order_obj = [];
        foreach($tvc_order->getAllVisibleItems() as $item){
            $product = $item->getProduct();
            $tvc_cat_ids = $item->getProduct()->getCategoryIds();
            $tvc_category = $this->getCategoryByIds($tvc_cat_ids);
            $prod_arr = [
                'tvc_id' => $item->getProductId(),
                'tvc_i'    => $item->getId(),
                'tvc_name' => $item->getName(),
                'tvc_p'    => $item->getBasePrice(),
                'tvc_Qty'  => $item->getQtyOrdered(),
                'tvc_c'    => $tvc_category
            ];
            
            array_push($tvc_order_obj, $prod_arr);
        }
        return $tvc_order_obj;
       
    }
    public function getTotalOrder(){
        $lastOrderId = $this->checkoutSession->getLastOrderId();
        $tvc_order = $this->orderRepository->get($lastOrderId);
        return $tvc_order;
    }
    
    public function getFbTotal(){

     
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart_total = $this->cart->getQuote()->getGrandTotal();
        $cart_item_count = $this->cart->getQuote()->getItemsCount();
        return array($cart_total , $cart_item_count);
    }

    public function getTransactionDetails(){
        $tvc_order = $this->getTotalOrder();
        $payment_method = $this->checkoutSession->getLastRealOrder()->getPayment()->getMethod();
        $prod_arr = ['tvc_id' =>  $tvc_order->getId(),
        'tvc_revenue'        => $tvc_order->getGrandTotal(),
        'tvc_affiliate'      => $this->getAffiliationName(),
        'tvc_tt'             => $tvc_order->getTaxAmount(),
        'tvc_ts'             => $tvc_order->getShippingAmount(),
        'tvc_payment'        => $payment_method,
        'tvc_shipping'       => $tvc_order->getShippingDescription()
        ];
        return $prod_arr;
    }
    public function getAffiliationName()
    {
        return $this->storeManager->getWebsite()->getName() . ' - ' .
        $this->storeManager->getGroup()->getName() . ' - ' .
        $this->storeManager->getStore()->getName();
    }
    public function getCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }
    public function getUser_ID()
    {
        if($this->checkUserId_Enabled()){
            return $this->customerSession->getCustomer()->getId();
        }
    }
    public function check_IsLoggedIn()
    {
        return  $this->customerSession->isLoggedIn();
    }
}