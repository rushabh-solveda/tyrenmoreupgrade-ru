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
namespace Webkul\PriceList\Model\Config;

class Categories implements \Magento\Framework\Data\OptionSourceInterface
{
    public function __construct(
        \Magento\Catalog\Model\Category $categoryData
    ) {
        $this->category = $categoryData;
    }
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->category->getCollection();
        $collection->addAttributeToSelect("name");
        $collection->addAttributeToFilter("level", ["gteq" => 2]);
        $firstLevel = [];
        $secondLevel = [];
        $thirdLevel = [];
        $allCategories = [];

        $data = [];
        foreach ($collection as $category) {
            $parentId = $category->getParentId();
            $id = $category->getEntityId();
            $level = $category->getLevel();
            if ($level == 2) {
                $firstLevel[$parentId][] = $id;
            }
            if ($level == 3) {
                $secondLevel[$parentId][] = $id;
            }
            if ($level == 4) {
                $thirdLevel[$parentId][] = $id;
            }
            $allCategories[$id] = $category->getName();
        }
        foreach ($firstLevel as $flp => $flc) {
            foreach ($flc as $slc) {
                $data[] = ['value' => $slc, 'label' => $allCategories[$slc]];
                if (array_key_exists($slc, $secondLevel)) {
                    foreach ($secondLevel[$slc] as $slcId) {
                        $data[] = ['value' => $slcId, 'label' => "- ".$allCategories[$slcId]];
                        if (array_key_exists($slcId, $thirdLevel)) {
                            $data = $this->getMergedArray(
                                $data,
                                $this->getCategories($thirdLevel, $slcId, $allCategories)
                            );
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * get third level categories
     *
     * @param [type] $thirdLevel
     * @param [type] $slcId
     * @param [type] $allCategories
     * @return array
     */
    public function getCategories($thirdLevel, $slcId, $allCategories)
    {
        $data = [];
        foreach ($thirdLevel[$slcId] as $tlcId) {
            $data[] = ['value' => $tlcId, 'label' => "-- ".$allCategories[$tlcId]];
        }
        return $data;
    }

    /**
     * get merged array
     *
     * @param [type] $array1
     * @param [type] $array2
     * @return array
     */
    public function getMergedArray($array1, $array2)
    {
        return array_merge($array1, $array2);
    }
}
