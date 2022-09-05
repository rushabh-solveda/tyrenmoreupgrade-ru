<?php

namespace Solveda\CrossSell\Block;

use Exception;
use Magento\Framework\View\Element\Block\ArgumentInterface;

//class CrossSellProducts extends \Magento\Framework\View\Element\Template
class CrossSellProducts implements ArgumentInterface
{

    const CAR_TYRE_ID = 46;
    const BIKE_TYRE_ID = 42;
    const CAR_BATTERY_ID = 3405;
    const BIKE_BATTERY_ID = 4152;
    const PRODUCT_CATEGORY_LEVEL = 5;

    /**
     * @param \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->registry = $registry;
        $this->logger = $logger;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        // parent::__construct($context, $data);
    }

    public function getProducts()
    {
        try {
            $productCollection = $this->getProductCollection();
        } catch (Exception $e) {
            echo $e->getMessage();die;
            $this->logger->error('Get product error', [$e->getMessage()]);
        }
        return $productCollection;
    }

    public function getProductCollection()
    {
        $categoryIds = $this->getProductCategoryIds();
        $categoryCollection = $this->getCategoryCollection($categoryIds);
        $carBikeCategoryIds = $this->getCarBikeCategoryCollection($categoryCollection);

        $categoryIds = $this->getCategoryIdByName($carBikeCategoryIds);

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $categoryIds]);
        $collection->setPageSize(10);
        return $collection;
    }

    public function getCategoryIdByName($categoryNames)
    {
        $parentCategoryId = $this->checkProductType();

        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('name', ['in' => $categoryNames]);
        $collection->addFieldToFilter('path', ['like' => "%/$parentCategoryId/%"]);

        $categoryIds = [];
        foreach ($collection as $cat) {
            $categoryIds[] =  $cat->getId();
        }

        return $categoryIds;
    }

    public function getCarBikeCategoryCollection($categoryCollection)
    {
        $collection = [];
        foreach ($categoryCollection as $category) {
            if ($category->getLevel() == self::PRODUCT_CATEGORY_LEVEL) {
                $collection[] = $category->getName();
                // $collection[] = $category->getId();
                // echo $category->getName();
                // echo $category->getId();
                // echo '<br />';
            }
        }
        return $collection;
    }

    public function getCategoryCollection($categoryIds)
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addFieldToFilter('entity_id', ['in' => $categoryIds]);
        return $collection;
    }

    public function checkProductType()
    {
        $productTypeId = null;
        $categoryIds = $this->getProductCategoryIds();
        if (in_array(self::CAR_TYRE_ID, $categoryIds)) {
            $productTypeId =  self::CAR_BATTERY_ID;
        } elseif (in_array(self::BIKE_TYRE_ID, $categoryIds)) {
            $productTypeId =  self::BIKE_BATTERY_ID;
        } elseif (in_array(self::CAR_BATTERY_ID, $categoryIds)) {
            $productTypeId =  self::CAR_TYRE_ID;
        } elseif (in_array(self::BIKE_BATTERY_ID, $categoryIds)) {
            $productTypeId =  self::BIKE_TYRE_ID;
        }
        return $productTypeId;
    }

    public function getProductCategoryIds()
    {
        $categoryIds = [];
        try {
            $product = $this->getCurrentProduct();
            if ($product && $product->getId()) {
                $categoryIds = $product->getCategoryIds($product->getId());
            }
            if ($categoryIds) {
                $categoryIds = array_unique($categoryIds);
            }
        } catch (Exception $e) {
            $this->logger->error('Error', [$e->getMessage()]);
        }
        return $categoryIds;
    }

    public function getCurrentProduct()
    {
        $product = null;
        try {
            $product = $this->registry->registry('current_product');
        } catch (Exception $e) {
            $this->logger->error("Registry current product not found", [$e->getMessage()]);
        }
        return $product;
    }
}
