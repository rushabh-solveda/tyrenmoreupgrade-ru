<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Controller\Adminhtml\Index;

use Magento\Framework\View\Result\Page;
use Mageplaza\AbandonedCart\Controller\Adminhtml\AbandonedCart;

/**
 * Class Report
 * @package Mageplaza\AbandonedCart\Controller\Adminhtml\Index
 */
class CheckoutReport extends AbandonedCart
{
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend((__('Checkout Abandonment Report')));

        return $resultPage;
    }
}
