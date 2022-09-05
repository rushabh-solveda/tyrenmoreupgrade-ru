<?php

namespace Solveda\CategoryProductPrice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Category implements ArgumentInterface
{
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->registry = $registry;
    }

    public function getParentCategory($categoryId)
    {
        $collection = $this->collectionFactory
            ->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', ['eq' => $categoryId])
            ->setPageSize(1);

        return $collection->getFirstItem()->getData();
    }

    /**
     * Get current categroy
     * @return object
     */
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }

    public function getCategoryName()
    {
        $category = $this->getCurrentCategory();

        $categoryLevel = $category->getLevel();
        $categoryName = $category->getName();

        if ($categoryLevel == 5) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));

            $categoryName = $parentCategory['name'] . ' ' . $categoryName;
        }

        if ($categoryLevel == 6) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));

            $categoryName = $parentCategory['name'] . ' ' . $categoryName;

            $parentCategory = $this->getParentCategory($parentCategory['parent_id']);
            $categoryName = $parentCategory['name'] . ' ' . $categoryName;
        }
        return $categoryName;
    }
}
