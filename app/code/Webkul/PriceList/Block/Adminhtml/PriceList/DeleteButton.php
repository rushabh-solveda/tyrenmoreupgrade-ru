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
namespace Webkul\PriceList\Block\Adminhtml\PriceList;

use Webkul\PriceList\Block\Adminhtml\Button;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends Button implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        if ($this->getPriceList()->getId()) {
            return [
                'label' => __('Delete Pricelist'),
                'on_click' => sprintf("location.href = '%s';", $this->getDeleteRuleUrl()),
            ];
        }
        return [];
    }

    /**
     * Get URL for delete Pricelist
     *
     * @return string
     */
    public function getDeleteRuleUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getPriceList()->getId()]);
    }
}
