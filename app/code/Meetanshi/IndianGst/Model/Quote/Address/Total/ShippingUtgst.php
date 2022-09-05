<?php
namespace Meetanshi\IndianGst\Model\Quote\Address\Total;

use Magento\Checkout\Model\Session as CheckoutSession;
use Meetanshi\IndianGst\Helper\Data;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Framework\Session\SessionManagerInterface;

class ShippingUtgst extends AbstractTotal
{
    protected $checkoutSession;
    protected $priceCurrency;
    protected $helper;
    protected $coreSession;
    private $isUnionTerritory = false;
 
    public function __construct(PriceCurrencyInterface $priceCurrency, CheckoutSession $checkoutSession, Data $helper, SessionManagerInterface $coreSession)
    {
        $this->priceCurrency = $priceCurrency;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
        $this->coreSession = $coreSession;
    }
 
    public function collect(Quote $quote, ShippingAssignmentInterface $shippingAssignment, Quote\Address\Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);
        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $total->setTotalAmount('shipping_utgst_amount', 0);
        $total->setBaseTotalAmount('shipping_utgst_amount', 0);

        $enabled = $this->helper->isEnabled();
        $isShipping = $this->helper->isShippingGst();
        $address = $shippingAssignment->getShipping()->getAddress();
        $shipRegion = $address->getRegion();
        if($this->helper->getCheckUnionTerritory($shipRegion))
        {
            $this->isUnionTerritory = true;
        }
        if ($this->helper->canApplyShipping('SSAME') &&  $this->isUnionTerritory) {
            if ($enabled && $isShipping && $address->getShippingAmount()) {
                $this->coreSession->setShippingGstAmount($address->getShippingAmount());
                $shippingGst = $this->helper->calculateCgstUtgstShipping($address->getShippingAmount(), $quote->getEntityId());

                $total->setShippingUtgstAmount($shippingGst);
                $total->setBaseShippingUtgstAmount($shippingGst);

                $address->setShippingUtgstAmount($shippingGst);
                $address->setBaseShippingUtgstAmount($shippingGst);
                $address->setTotalAmount('shipping_utgst_amount', $shippingGst);
                $address->setBaseTotalAmount('shipping_utgst_amount', $shippingGst);


                if ($this->helper->getShippingGstClass()) {
                    $total->setTotalAmount('shipping_utgst_amount', $shippingGst);
                    $total->setBaseTotalAmount('shipping_utgst_amount', $shippingGst);
                    $total->setGrandTotal($total->getGrandTotal() + $shippingGst);
                    $total->setBaseGrandTotal($total->getBaseGrandTotal() + $shippingGst);
                } else {
                    $total->setBaseGrandTotal($total->getBaseGrandTotal());
                }

                $quote->setShippingUtgstAmount($shippingGst);
                $quote->setBaseShippingUtgstAmount($shippingGst);
            }
        }

        return $this;
    }

    public function fetch(Quote $quote, Quote\Address\Total $total)
    {
        $enabled = $this->helper->isEnabled();
        $isShipping = $this->helper->isShippingGst();
        $result = [];
        if ($this->helper->canApplyShipping('SSAME')  && $this->isUnionTerritory) {
            $utgstAmount = $quote->getShippingUtgstAmount();
            if ($enabled && $utgstAmount && $isShipping) {
                $result = [
                    'code' => 'shipping_utgst_amount',
                    'title' => __('Shipping UTGST'),
                    'value' => $utgstAmount
                ];
            }
        }
        return $result;
    }

    public function getLabel()
    {
        return __('Shipping UTGST');
    }

    protected function clearValues(Quote\Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
}
