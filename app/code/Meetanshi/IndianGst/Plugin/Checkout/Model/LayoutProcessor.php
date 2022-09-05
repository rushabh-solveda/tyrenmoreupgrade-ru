<?php

namespace Meetanshi\IndianGst\Plugin\Checkout\Model;

use Magento\Checkout\Block\Checkout\LayoutProcessor as ChekcoutLayerprocessor;

class LayoutProcessor
{
    protected $dataHelper;

    public function __construct(
        \Meetanshi\IndianGst\Helper\Data $dataHelper
    ) {

        $this->dataHelper = $dataHelper;
    }

    public function afterProcess(
        ChekcoutLayerprocessor $subject,
        array $jsLayout
    ) {
        $flag = false;
        if ($this->dataHelper->getBuyerGst()) {
            $flag = true;
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['buyer_gst_number'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'gst_number'
            ],
            'dataScope' => 'shippingAddress.buyer_gst_number',
            'label' => 'GST Number#',
            'provider' => 'checkoutProvider',
            'visible' => $flag,
            'validation' => [],
            'sortOrder' => 252,
            'id' => 'buyer_gst_number'
        ];

        return $jsLayout;
    }
}
