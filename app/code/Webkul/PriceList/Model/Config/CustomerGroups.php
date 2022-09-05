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

class CustomerGroups implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @param \Magento\Customer\Model\ResourceModel\Group\Collection $customer
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $customer
    ) {
        $this->customer = $customer;
    }
    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $groupOptions = $this->customer->toOptionArray();
        return $groupOptions;
    }
}
