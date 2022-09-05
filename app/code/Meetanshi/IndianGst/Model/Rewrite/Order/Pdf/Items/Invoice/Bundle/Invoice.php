<?php

namespace Meetanshi\IndianGst\Model\Rewrite\Order\Pdf\Items\Invoice\Bundle;

use Magento\Bundle\Model\Sales\Order\Pdf\Items\Invoice as CoreInvoice;

class Invoice extends CoreInvoice
{
    public function draw()
    {
        $orderData = $this->getOrder();
        $itemData = $this->getItem();
        $pdfData = $this->getPdf();
        $pageData = $this->getPage();

        $this->_setFontRegular();
        $orderItems = $this->getChildren($itemData);

        $prevOptionDataId = '';
        $drawItemsData = [];

        foreach ($orderItems as $orderItem) {
            $lineArray = [];

            $itemAttributes = $this->getSelectionAttributes($orderItem);
            if (is_array($itemAttributes)) {
                $itemOptionId = $itemAttributes['option_id'];
            } else {
                $itemOptionId = 0;
            }

            if (!isset($drawItemsData[$itemOptionId])) {
                $drawItemsData[$itemOptionId] = ['lines' => [], 'height' => 15];
            }

            if ($orderItem->getOrderItem()->getParentItem()) {
                if ($prevOptionDataId != $itemAttributes['option_id']) {
                    $lineArray[0] = [
                        'font' => 'italic',
                        'text' => $this->string->split($itemAttributes['option_label'], 45, true, true),
                        'feed' => 35,
                    ];

                    $drawItemsData[$itemOptionId] = ['lines' => [$lineArray], 'height' => 15];

                    $lineArray = [];
                    $prevOptionDataId = $itemAttributes['option_id'];
                }
            }

            if ($this->canShowPriceInfo($orderItem)) {
                $taxableAmount = $orderItem->getRowTotal() - $orderItem->getDiscountAmount();
                if ($orderItem->getGstExclusive()) {
                    $subTotal = $orderItem->getRowTotal();
                    $itemTotal = $subTotal + $orderItem->getCgstAmount() + $orderItem->getSgstAmount() + $orderItem->getIgstAmount();
                } else {
                    $subTotal = $orderItem->getRowTotal() - $orderItem->getCgstAmount() - $orderItem->getSgstAmount() - $orderItem->getIgstAmount();
                    $taxableAmount = $subTotal - $orderItem->getDiscountAmount();
                    $itemTotal = $taxableAmount + $orderItem->getCgstAmount() + $orderItem->getSgstAmount() + $orderItem->getIgstAmount();
                }

                $price = $orderData->formatPriceTxt($orderItem->getPrice());
                $lineArray[] = ['text' => $orderItem->getQty() * 1, 'feed' => 150, 'font' => 'bold', 'align' => 'right'];
                $lineArray[] = ['text' => $price, 'feed' => 160, 'font' => 'bold'];

                $subTotal = $orderData->formatPriceTxt($subTotal);
                $lineArray[] = ['text' => $subTotal, 'feed' => 235, 'font' => 'bold', 'align' => 'right'];

                $discount = $orderData->formatPriceTxt($orderItem->getDiscountAmount());
                $lineArray[] = ['text' => $discount, 'feed' => 290, 'font' => 'bold', 'align' => 'right'];

                $tax = $orderData->formatPriceTxt($taxableAmount);
                $lineArray[] = ['text' => $tax, 'feed' => 345, 'font' => 'bold', 'align' => 'right'];

                $cgst = $this->string->split($orderData->formatPriceTxt($orderItem->getCgstAmount()), 10);
                $cgst[] = "Rate:".floatval($orderItem->getCgstPercent())."%";
                $lineArray[] = ['text' => $cgst, 'feed' => 400, 'font' => 'bold','align' => 'right'];
                $sgst = $this->string->split($orderData->formatPriceTxt($orderItem->getSgstAmount()), 10);
                $sgst[] = "Rate:".floatval($orderItem->getSgstPercent())."%";
                $lineArray[] = ['text' => $sgst, 'feed' => 455, 'font' => 'bold', 'align' => 'right'];
                $igst = $this->string->split($orderData->formatPriceTxt($orderItem->getIgstAmount()), 10);
                $igst[] = "Rate:".floatval($orderItem->getIgstPercent())."%";
                $lineArray[] = ['text' => $igst, 'feed' => 510, 'font' => 'bold', 'align' => 'right'];

                $row_total = $orderData->formatPriceTxt($itemTotal);
                $lineArray[] = ['text' => $row_total, 'feed' => 570, 'font' => 'bold', 'align' => 'right'];
            }

            $drawItemsData[$itemOptionId]['lines'][] = $lineArray;
        }

        $optionsData = $itemData->getOrderItem()->getProductOptions();
        if ($optionsData) {
            if (isset($optionsData['options'])) {
                foreach ($optionsData['options'] as $option) {
                    $lines = [];
                    $lines[][] = [
                        'text' => $this->string->split(
                            $this->filterManager->stripTags($option['label']),
                            40,
                            true,
                            true
                        ),
                        'font' => 'italic',
                        'feed' => 35,
                    ];

                    if ($option['value']) {
                        $text = [];
                        $printValue = isset(
                            $option['print_value']
                        ) ? $option['print_value'] : $this->filterManager->stripTags(
                            $option['value']
                        );
                        $values = explode(', ', $printValue);
                        foreach ($values as $value) {
                            foreach ($this->string->split($value, 30, true, true) as $subValue) {
                                $text[] = $subValue;
                            }
                        }

                        $lines[][] = ['text' => $text, 'feed' => 40];
                    }

                    $drawItemsData[] = ['lines' => $lines, 'height' => 15];
                }
            }
        }

        $pageData = $pdfData->drawLineBlocks($pageData, $drawItemsData, ['table_header' => true]);

        $this->setPage($pageData);
    }
}
