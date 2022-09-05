<?php
namespace Dev\Testing\Plugin\Checkout\Block\Checkout;
class LayoutProcessor
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        
        /* For Disable Country  field from checkout page shipping form */
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['company'] = [    
            'visible' => false
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['label'] = __('Email');

         $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['label'] = __('FIRST NAME'); 

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['label'] = __('Mobile Number');

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['label'] = __('State');

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']['label'] = __('Pincode');

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_notes'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'custom-notes'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_notes',
            'label' => 'Your Business GST (Optional)',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 299,
            'id' => 'custom-notes'
        ];
 
 
        return $jsLayout;
    }
}