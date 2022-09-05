<?php

namespace Meetanshi\IndianGst\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Template;

class ShowBuyerGstShipping implements ObserverInterface
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function execute(EventObserver $observer)
    {
        if ($observer->getElementName() == 'sales.order.info') {
            $orderShippingView = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingView->getOrder();
            $buyerGst = __('N/A');
            if ($order->getShippingAddress()->getBuyerGstNumber() != '') {
                $buyerGst = $order->getShippingAddress()->getBuyerGstNumber();
            }

            $this->template->setBuyerGstNumber($buyerGst);
            $html = $observer->getTransport()->getOutput() . $this->template->setTemplate('Meetanshi_IndianGst::customer/buyergst.phtml')->toHtml();
            $observer->getTransport()->setOutput($html);
        }
    }
}
