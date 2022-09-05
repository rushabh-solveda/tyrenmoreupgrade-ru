<?php

namespace Solveda\Discount\Model\Total\Quote;

class CustomDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;
    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Magento\Framework\Pricing\Helper\Data
     */
    private $helperData;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Pricing\Helper\Data $helperData
    ) {
        $this->priceCurrency = $priceCurrency;
        $this->logger = $logger;
        $this->helperData = $helperData;
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        //Fix for discount applied twice
        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }

        parent::collect($quote, $shippingAssignment, $total);

        $discountAmount = 0;
        $discount = 0;
        $label = '';

        // get quote items array
        $items = $quote->getAllItems();
        foreach ($items as $item) {
            $options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
            if (array_key_exists('options', $options)) {
                foreach ($options['options'] as $option) {
                    if (strtolower($option['label']) == strtolower('Exchange')) {
                        $discount = $this->getCustomOptionPrice($item->getProduct(), $option['option_id'], $option['option_value']);
                        if ($discount) {
                            $discountAmount += $discount;
                            // $discountPrice = $this->priceCurrency->convertAndFormat($discount);
                            $discountPrice = $this->helperData->currency($discount, true, false);
                            $label .= "Replace with old battery -" . $item->getName() . " $discountPrice ";
                        }
                    }
                }
            }
        }

        $appliedCartDiscount = 0;
        if ($total->getDiscountAmount()) {
            // If a discount exists in cart and another discount is applied, then add both discounts.
            $appliedCartDiscount = $total->getDiscountAmount();
            $discountAmount      = $total->getDiscountAmount() + $discountAmount;
            if($total->getDiscountDescription() && !empty($total->getDiscountDescription())) {
                $label = $total->getDiscountDescription() . ', ' . $label;
            }
            $label = trim(trim($label, ','), ', ');
        }

        $total->setDiscountDescription($label);
        $total->setDiscountAmount($discountAmount);
        $total->setBaseDiscountAmount($discountAmount);
        $total->setSubtotalWithDiscount($total->getSubtotal() + $discountAmount);
        $total->setBaseSubtotalWithDiscount($total->getBaseSubtotal() + $discountAmount);

        if (isset($appliedCartDiscount)) {
            $total->addTotalAmount($this->getCode(), $discountAmount - $appliedCartDiscount);
            $total->addBaseTotalAmount($this->getCode(), $discountAmount - $appliedCartDiscount);
        } else {
            $total->addTotalAmount($this->getCode(), $discountAmount);
            $total->addBaseTotalAmount($this->getCode(), $discountAmount);
        }

        return $this;
    }

    private function getCustomOptionPrice($_product, $option_id, $option_value)
    {
        $options = $_product->getData('options');
        $price = '';
        foreach ($options as $option) {
            if ($option->getValues() !== null) {
                $values = $option->getValues();
                foreach ($values as $key => $value) {
                    if ($key === intval($option_value)) {
                        $optionValues = $values[$option_value]->getData();
                        if ($optionValues['price'] !== null && $optionValues['price'] != "0.0000") {
                            $price = $optionValues['price'];
                        }
                    }
                }
            } elseif ($option->getValues() === null) {
                $optionData = $option->getData();
                if ($optionData['option_id'] == $option_id && ($optionData['price'] != "0.0000" && $optionData['price'] !== null)) {
                    $price = $optionData['price'];
                }
            }
        }
        return $price;
    }
}
