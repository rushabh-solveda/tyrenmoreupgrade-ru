<?php

namespace Solveda\Checkout\Block;

class LayoutProcessor
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        $payment_methods = ['cashondelivery', 'pumbolt'];
        foreach ($payment_methods as $payment) {
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$payment . '-form']['children']['form-fields']['children']['telephone']['validation']['max_text_length'] = 10;
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$payment . '-form']['children']['form-fields']['children']['telephone']['validation']['min_text_length'] = 10;
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$payment . '-form']['children']['form-fields']['children']['telephone']['validation']['validate-digits'] = true;
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'][$payment . '-form']['children']['form-fields']['children']['telephone']['sortOrder'] = 10;
        }
        return $jsLayout;
    }
}
