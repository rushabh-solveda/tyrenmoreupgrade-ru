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
namespace Webkul\PriceList\Block\Adminhtml\Rule;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Customer\Controller\RegistryConstants;
use Webkul\PriceList\Model\ResourceModel\Rule\CollectionFactory as RuleCollection;
use Webkul\PriceList\Model\ResourceModel\Items\CollectionFactory as ItemsCollection;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param ItemsCollection $itemsCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $coreRegistry,
        ItemsCollection $itemsCollection,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_itemsCollection = $itemsCollection;
        $this->_productFactory = $productFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('rule_products_grid');
        $this->setDefaultSort('id', 'desc');
        $this->setUseAjax(true);
    }

    /**
     * Apply various selection filters to prepare collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        if ($this->getRule()->getId()) {
            $this->setDefaultFilter(['in_rule' => 1]);
        }
        $exclude = ["bundle", "configurable", "grouped"];
        $collection = $this->_productFactory->create()->getCollection()->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'sku'
        )->addAttributeToSelect(
            'price'
        )->joinField(
            'position',
            'catalog_category_product',
            'position',
            'product_id=entity_id',
            'category_id=' . (int)$this->getRequest()->getParam('id', 0),
            'left'
        )
        ->addAttributeToFilter('type_id', ['nin' => $exclude]);
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        if ($storeId > 0) {
            $collection->addStoreFilter($storeId);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return array|null
     */
    public function getRule()
    {
        return $this->_coreRegistry->registry('pricelist_rule');
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_rule') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_rule',
            [
                'type' => 'checkbox',
                'name' => 'in_rule',
                'values' => $this->_getSelectedProducts(),
                'index' => 'entity_id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction'
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('sku', ['header' => __('SKU'), 'index' => 'sku']);
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index' => 'price'
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * {@inheritdoc}
     */
    public function getGridUrl()
    {
        return $this->getUrl('pricelist/rule/products', ['_current' => true]);
    }

    /**
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = array_keys($this->getSelectedProducts());
        return $products;
    }

    public function getSelectedProductsJson()
    {
        $jsonProducts = [];
        $products = array_keys($this->getSelectedProducts());
        if (!empty($products)) {
            foreach ($products as $product) {
                $jsonProducts[$product] = true;
            }
            return $this->_jsonEncoder->encode($jsonProducts);
        }
        return '{}';
    }

    public function getSelectedProducts()
    {
        $allProducts = $this->getRequest()->getPost('pricelist_rule_products');
        $products = [];
        if ($allProducts === null) {
            $rule = $this->getRule();
            $id = $rule->getId();
            $collection = $this->_itemsCollection
                                ->create()
                                ->addFieldToFilter("entity_type", 1)
                                ->addFieldToFilter("parent_id", $id);
            foreach ($collection as $product) {
                $products[$product->getEntityValue()] = ['position' => $product->getEntityValue()];
            }
        } else {
            foreach ($allProducts as $product) {
                $products[$product] = ['position' => $product];
            }
        }
        return $products;
    }
}
