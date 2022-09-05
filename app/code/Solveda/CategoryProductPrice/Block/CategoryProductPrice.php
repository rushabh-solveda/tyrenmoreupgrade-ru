<?php

namespace Solveda\CategoryProductPrice\Block;

class CategoryProductPrice extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @param \Magento\Framework\Url
     */
    private $urlBuilder;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Url $urlBuilder,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getLowestPriceProduct()
    {
        $currentPage = $this->getCurrentPage();
        $urls = ['battery.html', 'car-tyres.html', 'bike-tyres.html', 'alloy-wheels.html'];
        // hide product price block for battery home page
        if (in_array($currentPage, $urls)) {
            return null;
        }
        $category = $this->registry->registry('current_category');

        $products = $category->getLowestPriceHtml();

        return $products;
    }

    public function getCurrentPage()
    {
        $url = $this->getCurrentUrl();
        $urls = explode('/', $url);
        return end($urls);
    }

    public function getCurrentUrl()
    {
        return $this->urlBuilder->getCurrentUrl();
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
            $name = $parentCategory['name'];

            $parentCategory = $this->getParentCategory($parentCategory['parent_id']);

            $name = $parentCategory['name'] . ' ' . $name;

            $categoryName = $name . ' ' . $categoryName;
        }
        return $categoryName;
    }

    public function getCategoryType()
    {
        $text = 'Tyres';
        $currentCategory = $this->getCurrentCategory();
        $path = $currentCategory->getPath();
        if (strpos($path, '/3404/') !== false) {
            $text = 'battery';
        }
        elseif (strpos($path, '/4766/') !== false) {
            $text = 'alloy wheels';
        }
        return $text;
    }

    /**
     * Get parent categroy
     * @return array
     */
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
}