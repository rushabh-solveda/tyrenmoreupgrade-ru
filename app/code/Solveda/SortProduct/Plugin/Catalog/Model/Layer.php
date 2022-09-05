<?php

namespace Solveda\SortProduct\Plugin\Catalog\Model;

class Layer
{

    /**
     * @param \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * Retrieve current layer product collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function aroundGetProductCollection(
        \Magento\Catalog\Model\Layer $subject,
        callable $proceed
    ) {

        $collection = $proceed();

        $currentCategory = $this->registry->registry('current_category');

        if ($currentCategory) {
            $path = $currentCategory->getPath();
            $categories = explode('/', $path);

            if (in_array(3161, $categories)) {
                $collection->getSelect()
                    ->reset(\Zend_Db_Select::ORDER)
                    ->order(new \Zend_Db_Expr('case when name LIKE "%Ceat%" then 1 when name LIKE "%Goodyear%"  then 2 when name LIKE "%yokohama%"  then 3 when name LIKE "%kelly%"  then 4 when name LIKE "%Ultramile%" then 5 when name LIKE "%Apollo%" then 6 when name LIKE "%MRF%" then 7 when name LIKE "%Pirelli%" then 8 when name LIKE "%Bridgestone%" then 9 when name LIKE "%JK%" then 10 when name LIKE "%Michelin%" then 11 when name LIKE "%Continental%" then 12 when name LIKE "%TVS%" then 13 else 14 END'));
            }
        }

        return $collection;
    }
}
