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
namespace Webkul\PriceList\Block\Adminhtml\Rule;

use Webkul\PriceList\Block\Adminhtml\Button;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class CreateButton extends Button implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        if ($this->getRule()->getId()) {
            return [
                'label' => __('Create New Rule'),
                'on_click' => sprintf("location.href = '%s';", $this->getCreateUrl()),
                'class' => 'primary'
            ];
        }
        return [];
    }

    /**
     * Get URL for create new Rule
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }
}
