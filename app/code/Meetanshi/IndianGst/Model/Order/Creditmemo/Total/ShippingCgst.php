<?php
namespace Meetanshi\IndianGst\Model\Order\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal as CreditmemoAbstractTotal;
use Magento\Sales\Model\Order\Creditmemo;
use Meetanshi\IndianGst\Helper\Data as HelperData;

class ShippingCgst extends CreditmemoAbstractTotal
{
    protected $helper;

    public function __construct(HelperData $helper)
    {
        $this->helper = $helper;
    }

    public function collect(Creditmemo $creditmemo)
    {
        $amount = $creditmemo->getOrder()->getShippingCgstAmount();
        $creditmemo->setShippingCgstAmount($amount);

        if ($this->helper->getShippingGstClass()) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getShippingCgstAmount());
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getShippingCgstAmount());
        } else {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal());
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal());
        }
        return $this;
    }
}
