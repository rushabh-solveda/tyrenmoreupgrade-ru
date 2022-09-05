<?php

namespace Solveda\CategoryFAQ\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Keywords
 */
class Keywords implements OptionSourceInterface
{

    public function toOptionArray()
    {
        $availableOptions = [
            ['label' => '-- Please Select Keyword --', 'value' => ''],
            ['label' => 'Cheapest Price', 'value' => 'cheapest_price'],
            ['label' => 'Highest Price', 'value' => 'highest_price']
        ];
        return $availableOptions;
    }
}
