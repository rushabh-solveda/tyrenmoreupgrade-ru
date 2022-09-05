<?php
namespace Meetanshi\IndianGst\Model\Order\Invoice\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal as InvoiceAbstractTotal;
use Meetanshi\IndianGst\Helper\Data as HelperData;
use Magento\Sales\Model\Order\Invoice;

class ShippingCgst extends InvoiceAbstractTotal
{
    protected $helper;

    public function __construct(HelperData $helper)
    {
        $this->helper = $helper;
    }
 
    public function collect(Invoice $invoice)
    {
        $invoice->getShippingCgstAmount(0);
        $amount = $invoice->getOrder()->getShippingCgstAmount();
        $invoice->setShippingCgstAmount($amount);


        if ($this->helper->getShippingGstClass()) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getShippingCgstAmount());
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getShippingCgstAmount());
        } else {
            $invoice->setGrandTotal($invoice->getGrandTotal());
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal());
        }
        return $this;
    }
}
