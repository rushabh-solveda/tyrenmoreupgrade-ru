<?php

namespace Meetanshi\IndianGst\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Template;

class ShowBuyerGst implements ObserverInterface
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function execute(EventObserver $observer)
    {
        if ($observer->getElementName() == 'order_shipping_view') {
            $orderShippingView = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingView->getOrder();
            $buyerGst = __('N/A');
            if ($order->getShippingAddress()->getBuyerGstNumber() != '') {
                $buyerGst = $order->getShippingAddress()->getBuyerGstNumber();
            }
            if ($order->getBuyerGstNumber() != '') {
                $buyerGst = $order->getBuyerGstNumber();
            }

            $this->template->setBuyerGstNumber($buyerGst);
            $html = $observer->getTransport()->getOutput() . $this->template->setTemplate('Meetanshi_IndianGst::buyergst.phtml')->toHtml();
            $observer->getTransport()->setOutput($html);
        }
        if ($observer->getElementName() == 'sales_invoice_view') {
            $orderInvoiceView = $observer->getLayout()->getBlock($observer->getElementName());
            $invoice = $orderInvoiceView->getInvoice();

            $buyerGst = __('N/A');
            if ($invoice->getShippingAddress()->getBuyerGstNumber() != '') {
                $buyerGst = $invoice->getShippingAddress()->getBuyerGstNumber();
            }
            if ($invoice->getOrder()->getBuyerGstNumber() != '') {
                $buyerGst = $invoice->getOrder()->getBuyerGstNumber();
            }
            $this->template->setBuyerGstNumber($buyerGst);

            $html = $observer->getTransport()->getOutput() . $this->template->setTemplate('Meetanshi_IndianGst::buyergst.phtml')->toHtml();
            $observer->getTransport()->setOutput($html);
        }
        if ($observer->getElementName() == 'sales_creditmemo_view') {
            $orderCreditmemoView = $observer->getLayout()->getBlock($observer->getElementName());
            $creditmemo = $orderCreditmemoView->getCreditmemo();
            $buyerGst = __('N/A');
            if ($creditmemo->getShippingAddress()->getBuyerGstNumber() != '') {
                $buyerGst = $creditmemo->getBuyerGstNumber();
            }
            if ($creditmemo->getOrder()->getBuyerGstNumber() != '') {
                $buyerGst = $creditmemo->getOrder()->getBuyerGstNumber();
            }
            $this->template->setBuyerGstNumber($buyerGst);

            $html = $observer->getTransport()->getOutput() . $this->template->setTemplate('Meetanshi_IndianGst::buyergst.phtml')->toHtml();
            $observer->getTransport()->setOutput($html);
        }
    }
}
