<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webkul\PriceList\Block\Adminhtml\Rule;

use Webkul\PriceList\Model\ResourceModel\Items\CollectionFactory as ItemsCollection;

class AssignProducts extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'rule/products.phtml';

    /**
     * @var \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * AssignProducts constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        ItemsCollection $itemsCollection,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_jsonEncoder = $jsonEncoder;
        $this->_itemsCollection = $itemsCollection;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Webkul\PriceList\Block\Adminhtml\Rule\Products::class,
                'rule.product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * @return array|null
     */
    public function getRule()
    {
        return $this->_coreRegistry->registry('pricelist_rule');
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
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
