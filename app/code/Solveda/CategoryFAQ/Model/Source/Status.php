<?php

namespace Solveda\CategoryFAQ\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class Status implements OptionSourceInterface
{

    public function toOptionArray()
    {

        $availableOptions = [0 => __('Disable'), 1 => __('Enable')];

        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
