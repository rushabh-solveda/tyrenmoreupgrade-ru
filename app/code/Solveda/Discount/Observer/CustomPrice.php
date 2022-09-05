<?php

namespace Solveda\Discount\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomPrice implements ObserverInterface
{

    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Magento\Catalog\Model\ProductFactory
     */
    private $productFactory;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->logger = $logger;
        $this->productFactory = $productFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote_item = $observer->getEvent()->getQuoteItem();
        $options = $quote_item->getProduct()->getTypeInstance(true)->getOrderOptions($quote_item->getProduct());
        $discountAmount = 0;
        $label = '';
        if (array_key_exists('options', $options)) {
            foreach ($options['options'] as $option) {
                if (strtolower($option['label']) == strtolower('Exchange')) {
                    $discount = $this->getCustomOptionPrice($quote_item->getProduct(), $option['option_id'], $option['option_value']);
                    if ($discount) {
                        $discountAmount += $discount;
                        $label .= " Replace with old battery -" . $quote_item->getName() . " ";
                    }
                }
            }
        }
        $productId = $quote_item->getproduct()->getId();
        $product = $this->productFactory->create()->load($productId);

        //$this->logger->debug("final price", [$product->getFinalPrice()]);
        $finalPrice = $product->getFinalPrice();
        //$price = $quote_item->getproduct()->getFinalPrice();
        $quote_item->setCustomPrice($finalPrice);
        $quote_item->setOriginalCustomPrice($finalPrice);
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
