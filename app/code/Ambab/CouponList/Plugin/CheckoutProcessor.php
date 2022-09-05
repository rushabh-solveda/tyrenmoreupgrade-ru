<?php
/**
 * Ambab CouponList Extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ambab
 *
 * @copyright   Copyright (c) 2019 Ambab (https://www.ambab.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Ambab\CouponList\Plugin;

class CheckoutProcessor
{
    /**
     * @var \Ambab\CouponList\Helper\Data
     */
    private $helperData;

    /**
     * CheckoutProcessor constructor.
     */
    public function __construct(
        \Ambab\CouponList\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    /**
     * Checkout LayoutProcessor after process plugin.
     *
     * @param array $jsLayout
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $processor, $jsLayout)
    {
        $paymentConfig = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step'];

        if (!$this->helperData->isEnabled()) {
            unset($paymentConfig['children']['payment']['children']['afterMethods']['children']['coupon-link']);
            unset($paymentConfig['children']['payment']['children']['afterMethods']['children']['coupon-list']);
        }

        $sidebarConfig = &$jsLayout['components']['checkout']['children']['sidebar'];

        if (!$this->helperData->isEnabled()) {
            unset($sidebarConfig['children']['summary']['children']['coupon-link']);
            unset($sidebarConfig['children']['summary']['children']['coupon-list']);
        }

        return $jsLayout;
    }
}
