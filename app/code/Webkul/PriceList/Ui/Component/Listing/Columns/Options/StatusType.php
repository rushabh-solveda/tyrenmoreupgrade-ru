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
namespace Webkul\PriceList\Ui\Component\Listing\Columns\Options;

use Magento\Framework\Data\OptionSourceInterface;

class StatusType implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
                        [
                            'label' =>  __('Active'),
                            'value' => 1
                        ],
                        [
                            'label' =>  __('Deactivate'),
                            'value' => 2
                        ]
                    ];
        return $options;
    }
}
