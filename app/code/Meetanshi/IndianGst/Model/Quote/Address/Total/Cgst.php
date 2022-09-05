<?php

namespace Meetanshi\IndianGst\Model\Quote\Address\Total;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Meetanshi\IndianGst\Helper\Data;

class Cgst extends AbstractTotal
{
    protected $checkoutSession;
    protected $priceCurrency;
    protected $helper;

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

        $total->setTotalAmount('cgst_amount', 0);
        $total->setBaseTotalAmount('cgst_amount', 0);
        $enabled = $this->helper->isEnabled();

        if (\Magento\Framework\App\Area::AREA_ADMINHTML) {
            $address = $shippingAssignment->getShipping()->getAddress();

            $shipOrigin = $address->getRegionId();
            $mainOrigin = $this->helper->getOrigin();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            if ($shipOrigin == $mainOrigin) {
                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSame("SAME");
                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSSame("SSAME");
            } elseif ($address->getCountryId() == 'IN' && (!empty($address->getRegionCode()))) {
                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSame("DIFF");
                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSSame("SDIFF");
            } else{
                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSame("N");

                $objectManager->get(
                    'Magento\Customer\Model\Session'
                )->setIsSSame("SN");

                $total->setCgstAmount(0);
                $total->setBaseCgstAmount(0);
                $total->setSgstAmount(0);
                $total->setBaseSgstAmount(0);
                $total->setIgstAmount(0);
                $total->setBaseIgstAmount(0);
            }
        }
        if ($this->helper->canApplyTax('SAME')) {
            $cgstAmount = $this->helper->calculateCgst($quote->getEntityId());
            if ($enabled) {
                $total->setCgstAmount($cgstAmount);
                $total->setBaseCgstAmount($cgstAmount);

                if ($this->helper->isCatalogExclusiveGst()) {
                    $total->setTotalAmount('cgst_amount', $cgstAmount);
                    $total->setBaseTotalAmount('cgst_amount', $cgstAmount);
                    //$total->setBaseGrandTotal($total->getBaseGrandTotal() + $cgstAmount);
                } else {
                    $total->setBaseGrandTotal($total->getBaseGrandTotal());
                }
                $quote->setCgstAmount($cgstAmount);
                $quote->setBaseCgstAmount($cgstAmount);
            }
        }
        return $this;
    }

    public function fetch(Quote $quote, Quote\Address\Total $total)
    {
        $enabled = $this->helper->isEnabled();
        $result = [];
        if ($this->helper->canApplyTax('SAME')) {
            $cgstAmount = $quote->getCgstAmount();
            if ($enabled && $cgstAmount) {
                $result = ['code' => 'cgst_amount', 'title' => __('CGST'), 'value' => $cgstAmount];
            }
        }
        return $result;
    }

    public function getLabel()
    {
        return __('CGST');
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
