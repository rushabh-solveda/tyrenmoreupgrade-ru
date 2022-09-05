<?php

namespace Solveda\Brand\ViewModel;

use Magento\Framework\Registry;
use Magento\Catalog\Model\Product\Option;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Product implements ArgumentInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Option
     */
    protected $option;

    /**
     * Product helper constructor
     *
     * @param Registry  $registry
     * @param Option    $option
     */
    public function __construct(
        Registry $registry,
        Option $option
    ) {
        $this->registry = $registry;
        $this->option = $option;
    }

    /**
     * Get product custom attributes
     * 
     * @return array
     */
    public function getCustomAttributes()
    {
        $custom = [];
        $product = $this->getProduct();
        $attributes = $product->getCustomAttributes();
        foreach ($attributes as $attribute) {
            $custom[$attribute->getAttributeCode()] = [$attribute->getValue()];
        }
        return $custom;
    }

    /**
     * Get Product Custom Options
     * 
     * @return object
     */
    public function getCustomOptions()
    {
        $product = $this->getProduct();
        $customOptions = $this->option->getProductOptionCollection($product);
        return $customOptions;
    }

    /**
     * Get current product
     * 
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        $product = $this->registry->registry('current_product');
        return $product;
    }
}
