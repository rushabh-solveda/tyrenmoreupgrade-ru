<?php

namespace Solveda\CategoryFAQ\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CategoryAttribute
 */
class CategoryAttribute implements OptionSourceInterface
{

    public function toOptionArray()
    {
        $availableOptions = [
            ['label' => '-- Please Select Category Attribute --', 'value' => ''],
            ['label' => 'faq_best_tyre', 'value' => 'Best Tyres'],
        ];
        return $availableOptions;
    }
}
