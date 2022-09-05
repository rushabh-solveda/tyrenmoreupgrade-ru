<?php

namespace Meetanshi\IndianGst\Model\Quote\Address\Total;

use Magento\Checkout\Model\Session as CheckoutSession;
use Meetanshi\IndianGst\Helper\Data;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;

class Sgst extends AbstractTotal
{
    protected $checkoutSession;
    protected $priceCurrency;
    protected $helper;
    private $isUnionTerritory = false;

    public function __construct(PriceCurrencyInterface $priceCurrency, CheckoutSession $checkoutSession, Data $helper)
    {
        $this->priceCurrency = $priceCurrency;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
    }

    public function collect(Quote $quote, ShippingAssignmentInterface $shippingAssignment, Quote\Address\Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);
        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $total->setTotalAmount('sgst_amount', 0);
        $total->setBaseTotalAmount('sgst_amount', 0);

        $enabled = $this->helper->isEnabled();
        $address = $shippingAssignment->getShipping()->getAddress();
        $shipRegion = $address->getRegion();
        if(!$this->helper->getCheckUnionTerritory($shipRegion))
        {
            $this->isUnionTerritory = true;
        }
        if ($this->helper->canApplyTax('SAME') && $this->isUnionTerritory) {
            $sgstAmount = $this->helper->calculateSgst($quote->getEntityId());
            if ($enabled) {
                $total->setSgstAmount($sgstAmount);
                $total->setBaseSgstAmount($sgstAmount);
                $quote->setSgstAmount($sgstAmount);
                $quote->setBaseSgstAmount($sgstAmount);
                if ($this->helper->isCatalogExclusiveGst()) {
                    $total->setTotalAmount('sgst_amount', $sgstAmount);
                    $total->setBaseTotalAmount('sgst_amount', $sgstAmount);
                    //$total->setBaseGrandTotal($total->getBaseGrandTotal() + $sgstAmount);
                } else {
                    $total->setBaseGrandTotal($total->getBaseGrandTotal());
                }
            }
        }
        return $this;
    }

    public function fetch(Quote $quote, Quote\Address\Total $total)
    {
        $enabled = $this->helper->isEnabled();

        $result = [];
        if ($this->helper->canApplyTax('SAME') && $this->isUnionTerritory) {
            $sgstAmount = $quote->getSgstAmount();
            if ($enabled && $sgstAmount) {
                $result = ['code' => 'sgst_amount', 'title' => __('SGST'), 'value' => $sgstAmount];
            }
        }

        return $result;
    }

    public function getLabel()
    {
        return __('SGST');
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
