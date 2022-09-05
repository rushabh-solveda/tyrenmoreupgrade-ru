<?php

declare(strict_types=1);

namespace Solveda\CategoryFAQ\Block\Adminhtml\CategoryFAQ\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Save The Sell record
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save FAQ'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
