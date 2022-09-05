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

class StatusOptions implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = [
                    ['value' => '1', 'label' => __('Active')],
                    ['value' => '2', 'label' => __('Deactivate')]
                ];

        return $data;
    }
}
