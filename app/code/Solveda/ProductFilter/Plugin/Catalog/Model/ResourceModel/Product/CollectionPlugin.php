<?php

namespace Solveda\ProductFilter\Plugin\Catalog\Model\ResourceModel\Product;

class CollectionPlugin
{
    protected $request;
    public function __construct(
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->request = $request;
    }
    /**
     * @param Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     */
    public function beforeLoad(\Magento\Catalog\Model\ResourceModel\Product\Collection $subject, $printQuery = false, $logQuery = false)
    {
        if (!$subject->isLoaded()) {
            $categoryId = $this->request->getParam('category_id');
            if (isset($categoryId) && $categoryId) {
                $subject->addCategoriesFilter(['in' => [$categoryId]]);
            }
        }
        return [$printQuery, $logQuery];
    }
}
