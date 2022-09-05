<?php

namespace Payment\Phonepe\Controller;

use Magento\Framework\App\RequestInterface;

/**
 * Phonepe Base Controller
 */
abstract class BaseController extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Phonepe\Magento\Model\CheckoutFactory
     */
    protected $checkoutFactory;

    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote = false;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Phonepe\Magento\Model\Checkout
     */
    protected $checkout;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;

    }

    /**
     * Instantiate quote and checkout
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function initCheckout()
    {
        $quote = $this->getQuote();
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->getResponse()->setStatusHeader(403, '1.1', 'Forbidden');
            throw new \Magento\Framework\Exception\LocalizedException(__('We can\'t initialize checkout.'));
        }
    }

    /**
     * Return checkout quote object
     *
     * @return \Magento\Quote\Model\Quote
     */
    protected function getQuote()
    {
        if (!$this->quote) {
            $this->quote = $this->checkoutSession->getQuote();
        }
        return $this->quote;
    }

    /**
     * @return \Phonepe\Magento\Model\Checkout
     */
    protected function getCheckout()
    {
        if (!$this->checkout) {
            $this->checkout = $this->checkoutFactory->create(
                [
                    'params' => [
                        'quote' => $this->checkoutSession->getQuote(),
                    ],
                ]
            );
        }
        return $this->checkout;
    }
}