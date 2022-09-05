<?php

namespace Meetanshi\IndianGst\Model\Rewrite\Order\Pdf;

use \Magento\Sales\Model\Order\Pdf\Invoice as CoreInvoice;
use \Magento\Sales\Model\Order;
use \Magento\Sales\Model\Order\Shipment;

class Invoice extends CoreInvoice
{
    /**
     * Return PDF document
     *
     * @param array|Collection $invoices
     * @return \Zend_Pdf
     */
    public function getPdf($invoices = [])
    {
        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');

        $pdf = new \Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $this->_setFontBold($style, 10);

        foreach ($invoices as $invoice) {
            if ( $invoice->getStoreId() ) {
                $this->_localeResolver->emulate($invoice->getStoreId());
                $this->_storeManager->setCurrentStore($invoice->getStoreId());
            }
            $page = $this->newPage();
            $order = $invoice->getOrder();
            /* Add image */
            $this->insertLogo($page, $invoice->getStore());
            /* Add address */
            $this->insertAddress($page, $invoice->getStore());
            /* Add head */
            $this->insertOrder(
                $page,
                $order,
                $this->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );
            /* Add document text and number */
            $this->insertDocumentNumber($page, __('Invoice # ') . $invoice->getIncrementId());

            /* Add table */
            $this->_drawHeader($page);
            /* Add body */
            foreach ($invoice->getAllItems() as $item) {
                if ( $item->getOrderItem()->getParentItem() ) {
                    continue;
                }
                /* Draw item */
                $this->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
            /* Add totals */
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeInformation = $objectManager->create('Magento\Store\Model\Information');
            $storeInfo = $storeInformation->getStoreInformationObject($order->getStore());

            $page = $this->insertTotals($page, $invoice);
            $this->insertDigiSignature($page, $storeInfo);
            if ( $invoice->getStoreId() ) {
                $this->_localeResolver->revert();
            }
        }

        $this->_afterGetPdf();
        return $pdf;
    }

    protected function _setFontBold($object, $size = 7)
    {
        $font = \Zend_Pdf_Font::fontWithPath(
            $this->_rootDirectory->getAbsolutePath('app/code/Meetanshi/IndianGst/lib/DejavuSans/ttf/DejaVuSans.ttf')
        );
        $object->setFont($font, $size);
        return $font;
    }

    public function newPage(array $settings = [])
    {
        /* Add new table head */
        $page = $this->_getPdf()->newPage(\Zend_Pdf_Page::SIZE_A4);
        $this->_getPdf()->pages[] = $page;
        $this->y = 800;
        if ( !empty($settings['table_header']) ) {
            $this->_drawHeader($page);
        }
        return $page;
    }

    protected function _drawHeader(\Zend_Pdf_Page $page)
    {
        /* Add table head */
        $this->_setFontRegular($page, 10);
        $page->setFillColor(new \Zend_Pdf_Color_RGB(0.93, 0.92, 0.92));
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $this->y, 570, $this->y - 15);
        $this->y -= 10;
        $fontSize = 8;
        $removeGap = 30;
        $page->setFillColor(new \Zend_Pdf_Color_RGB(0, 0, 0));

        //columns headers
        $taxableAmountText = $this->string->split('Taxable Amount', 8);
        $lines[0][] = [
            'text' => __('Products (Price x Qty)'),
            'feed' => 35,
            'font_size' => $fontSize
        ];

        $lines[0][] = [
            'text' => __('Subtotal'),
            'feed' => 195 - $removeGap,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = ['text' => __('Discount'),
            'feed' => 248 - $removeGap,
            'align' => 'right',
            'font_size' => $fontSize
        ];

        $lines[0][] = [
            'text' => __('Taxable Amt'),
            'feed' => 305 - $removeGap,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = [
            'text' => __('CGST'),
            'feed' => 352 - $removeGap,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = [
            'text' => __('UTGST'),
            'feed' => 375,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = ['text' => __('SGST'),
            'feed' => 430,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = [
            'text' => __('IGST'),
            'feed' => 485,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lines[0][] = [
            'text' => __('Row Total'),
            'feed' => 565,
            'align' => 'right',
            'font_size' => $fontSize
        ];
        $lineBlock = [
            'lines' => $lines,
            'height' => 5, $this->y,
            'font_size' => $fontSize
        ];
        $this->drawLineBlocks($page, [$lineBlock], ['table_header' => true]);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $this->y -= 20;
    }

    protected function _setFontRegular($object, $size = 7)
    {
        $font = \Zend_Pdf_Font::fontWithPath(
            $this->_rootDirectory->getAbsolutePath('app/code/Meetanshi/IndianGst/lib/DejavuSans/ttf/DejaVuSans.ttf')
        );
        $object->setFont($font, $size);
        return $font;
    }

    protected function insertOrder(&$page, $obj, $putOrderId = true)
    {
        $order = '';
        if ( $obj instanceof Order ) {
            $shipment = null;
            $order = $obj;
        } elseif ( $obj instanceof Shipment ) {
            $shipment = $obj;
            $order = $shipment->getOrder();
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create('\Meetanshi\IndianGst\Helper\Data');

        $this->y = $this->y ? $this->y : 815;
        $top = $this->y;

        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0.45));
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.45));
        $page->drawRectangle(25, $top, 570, $top - 200);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));
        $this->setDocHeaderCoordinates([25, $top, 570, $top - 55]);
        $this->_setFontRegular($page, 10);
        if ( $putOrderId ) {
            $page->drawText(__('Order # ') . $order->getRealOrderId(), 35, $top -= 30, 'UTF-8');
        }

        try {
            $page->drawText(
                __('Order Date:: ') .
                $this->_localeDate->formatDate(
                    $this->_localeDate->scopeDate(
                        $order->getStore(),
                        $order->getCreatedAt(),
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                ),
                35,
                $top -= 15,
                'UTF-8'
            );
            foreach ($order->getInvoiceCollection() as $invoice)
            {
                $invoiceDate = $invoice->getCreatedAt();
            }
            $page->drawText(
                __('Invoice Date:: ') .
                $this->_localeDate->formatDate(
                    $this->_localeDate->scopeDate(
                        $order->getStore(),
                        $invoiceDate,
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                ),
                35,
                $top -= 15,
                'UTF-8'
            );
        } catch (\Zend_Pdf_Exception $e) {
        }
        $ttt = $top - 15;

        $page->drawText(__('Tax Invoice/Bill of Supply/Cash Memo'), 325, $top += 50, 'UTF-8');
        $page->drawText(__('GST Number : ') . $helper->getGstNumber(), 325, $top -= 15, 'UTF-8');

        $panNumber = $helper->getPanNumber();
        $top -= 15;
        if ( isset($panNumber) ) :
            $page->drawText(__('PAN Number : ') . $panNumber, 325, $top, 'UTF-8');
        endif;
        $cinNumber = $helper->getCinNumber();
        $top -= 15;
        if ( isset($cinNumber) ) :
            $page->drawText(__('CIN Number : ') . $cinNumber, 325, $top, 'UTF-8');
        endif;
        $top -= 10;
        $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $top, 275, $top - 25);
        $page->drawRectangle(275, $top, 570, $top - 25);


        /* Calculate blocks info */


        /* Billing Address */
        $billingAddress = $this->_formatAddress($this->addressRenderer->format($order->getBillingAddress(), 'pdf'));

        /* Payment */
        $paymentInfo = $this->_paymentData->getInfoBlock($order->getPayment())->setIsSecureMode(true)->toPdf();
        $paymentInfo = htmlspecialchars_decode($paymentInfo, ENT_QUOTES);
        $payment = explode('{{pdf_row_separator}}', $paymentInfo);
        foreach ($payment as $key => $value) {
            if ( strip_tags(trim($value)) == '' ) {
                unset($payment[$key]);
            }
        }
        reset($payment);
        $regionData = $order->getShippingAddress()->getRegion();
        /* Shipping Address and Method */
        if ( !$order->getIsVirtual() ) {
            /* Shipping Address */
            $shippingAddress = $this->_formatAddress($this->addressRenderer->format($order->getShippingAddress(), 'pdf'));
            $shippingMethod = $order->getShippingDescription();
            $order->getShippingAddress()->getCountryId();


        }

        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $this->_setFontBold($page, 12);
        $page->drawText(__('Sold to:'), 35, $top - 15, 'UTF-8');

        if ( !$order->getIsVirtual() ) {
            $page->drawText(__('Ship to:'), 285, $top - 15, 'UTF-8');
        } else {
            $page->drawText(__('Payment Method:'), 285, $top - 15, 'UTF-8');
        }

        $addressesHeight = $this->_calcAddressHeight($billingAddress);
        if ( isset($shippingAddress) ) {
            $addressesHeight = max($addressesHeight, $this->_calcAddressHeight($shippingAddress));
        }

        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));
        $page->drawRectangle(25, $top - 25, 570, $top - 33 - $addressesHeight);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $this->_setFontRegular($page, 10);
        $this->y = $top - 40;
        $addressesStartY = $this->y;

        foreach ($billingAddress as $value) {
            if ( $value !== '' ) {
                $text = [];
                foreach ($this->string->split($value, 45, true, true) as $_value) {
                    $text[] = $_value;
                }
                foreach ($text as $part) {
                    $page->drawText(strip_tags(ltrim($part)), 35, $this->y, 'UTF-8');
                    $this->y -= 15;
                }
            }
        }

        $addressesEndY = $this->y;

        if ( !$order->getIsVirtual() ) {
            $this->y = $addressesStartY;
            foreach ($shippingAddress as $value) {
                if ( $value !== '' ) {
                    $text = [];
                    foreach ($this->string->split($value, 45, true, true) as $_value) {
                        $text[] = $_value;
                    }
                    foreach ($text as $part) {
                        $page->drawText(strip_tags(ltrim($part)), 285, $this->y, 'UTF-8');
                        $this->y -= 15;
                    }
                }
            }

            $addressesEndY = min($addressesEndY, $this->y);

            $this->y = $addressesEndY - 10;
            $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 275, $this->y - 25);
            $page->drawRectangle(275, $this->y, 570, $this->y - 25);

            $storeInformation = $objectManager->create('Magento\Store\Model\Information');
            $storeInfo = $storeInformation->getStoreInformationObject($order->getStore());

            $storeAddress1 = $storeInfo['street_line1'] . ' ' . $storeInfo['street_line2']. ', ' .$storeInfo['city'].', '.$storeInfo['region'] . ', ' . $storeInfo['country'] . ' - ' . $storeInfo['postcode'];

            $this->y -= 15;
            $this->_setFontBold($page, 10);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
            $page->drawText(__('Supplier Address'), 35, $this->y, 'UTF-8');
            $page->drawText(__('Place of Supply'), 285, $this->y, 'UTF-8');


            $region = $objectManager->create('Magento\Directory\Model\Region')
                ->loadByName(trim($regionData), $order->getShippingAddress()->getCountryId());
            $regionData = $regionData;
            if(!empty($region->getStateCode())){
                $regionData = $regionData . ' (' . $region->getStateCode() . ')';
            }
            $this->y -= 25;
            $this->_setFontBold($page, 10);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
            $font = $this->_setFontBold($page, 9);
            $top = $this->y + 5;
            if($storeAddress1) {
                foreach ($this->string->split($storeAddress1, 45, true, true) as $_value) {
                    $page->drawText(
                        trim(strip_tags($_value)),
                        35,
                        $top,
                        'UTF-8'
                    );
                    $top -= 10;
                }
            }
            /*$page->drawText(__($storeAddress1), 35, $this->y + 2, 'UTF-8');
            $page->drawText(__($storeAddress2), 35, $this->y - 8, 'UTF-8');*/
            $this->_setFontBold($page, 10);
            $page->drawText(__($regionData), 285, $this->y, 'UTF-8');

            $page->drawLine(25, $addressesEndY - 17 , 25, $this->y - 22);
            $page->drawLine(570, $addressesEndY - 17, 570, $this->y - 22);
            $page->drawLine(25, $addressesEndY - 72, 570, $this->y - 22);

            $this->y = $this->y - 30;

            $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 275, $this->y - 25);
            $page->drawRectangle(275, $this->y, 570, $this->y - 25);

            $this->y -= 15;
            $this->_setFontBold($page, 12);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
            $page->drawText(__('Payment Method'), 35, $this->y, 'UTF-8');
            $page->drawText(__('Shipping Method:'), 285, $this->y, 'UTF-8');

            $this->y -= 10;
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));

            $this->_setFontRegular($page, 10);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));

            $paymentLeft = 35;
            $yPayments = $this->y - 15;
        } else {
            $yPayments = $addressesStartY;
            $paymentLeft = 285;
        }

        foreach ($payment as $value) {
            if ( trim($value) != '' ) {
                //Printing "Payment Method" lines
                $value = preg_replace('/<br[^>]*>/i', "\n", $value);
                foreach ($this->string->split($value, 45, true, true) as $_value) {
                    $page->drawText(strip_tags(trim($_value)), $paymentLeft, $yPayments, 'UTF-8');
                    $yPayments -= 15;
                }
            }
        }

        if ( $order->getIsVirtual() ) {
            // replacement of Shipments-Payments rectangle block
            $yPayments = min($addressesEndY, $yPayments);
            $page->drawLine(25, $top - 25, 25, $yPayments);
            $page->drawLine(570, $top - 25, 570, $yPayments);
            $page->drawLine(25, $yPayments, 570, $yPayments);

            $this->y = $yPayments - 15;
        } else {
            $topMargin = 15;
            $methodStartY = $this->y;
            $this->y -= 15;

            foreach ($this->string->split($shippingMethod, 45, true, true) as $_value) {
                $page->drawText(strip_tags(trim($_value)), 285, $this->y, 'UTF-8');
                $this->y -= 15;
            }

            $yShipments = $this->y;
            $totalShippingChargesText = "(" . __(
                    'Total Shipping Charges'
                ) . " " . $order->formatPriceTxt(
                    $order->getShippingAmount()
                ) . ")";

            $page->drawText($totalShippingChargesText, 285, $yShipments - $topMargin, 'UTF-8');
            $yShipments -= $topMargin + 10;

            $tracks = [];
            if ( $shipment ) {
                $tracks = $shipment->getAllTracks();
            }
            if ( count($tracks) ) {
                $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
                $page->setLineWidth(0.5);
                $page->drawRectangle(285, $yShipments, 510, $yShipments - 10);
                $page->drawLine(400, $yShipments, 400, $yShipments - 10);
                //$page->drawLine(510, $yShipments, 510, $yShipments - 10);

                $this->_setFontRegular($page, 9);
                $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                //$page->drawText(__('Carrier'), 290, $yShipments - 7 , 'UTF-8');
                $page->drawText(__('Title'), 290, $yShipments - 7, 'UTF-8');
                $page->drawText(__('Number'), 410, $yShipments - 7, 'UTF-8');

                $yShipments -= 20;
                $this->_setFontRegular($page, 8);
                foreach ($tracks as $track) {
                    $maxTitleLen = 45;
                    $endOfTitle = strlen($track->getTitle()) > $maxTitleLen ? '...' : '';
                    $truncatedTitle = substr($track->getTitle(), 0, $maxTitleLen) . $endOfTitle;
                    $page->drawText($truncatedTitle, 292, $yShipments, 'UTF-8');
                    $page->drawText($track->getNumber(), 410, $yShipments, 'UTF-8');
                    $yShipments -= $topMargin - 5;
                }
            } else {
                $yShipments -= $topMargin - 5;
            }

            $currentY = min($yPayments, $yShipments);

            // replacement of Shipments-Payments rectangle block
            $page->drawLine(25, $methodStartY, 25, $currentY);
            //left
            $page->drawLine(25, $currentY, 570, $currentY);
            //bottom
            $page->drawLine(570, $currentY, 570, $methodStartY);
            $this->_drawFooter($page);
            //right

            $this->y = $currentY;
            $this->y -= 15;
        }
    }

    protected function _drawFooter(\Zend_Pdf_Page $page)
    {
        /* Add table foot */
        $this->_setFontRegular($page, 10);
        $this->y -= 10;
        $page->setFillColor(new \Zend_Pdf_Color_RGB(0, 0, 0));
    }

    protected function insertDigiSignature(&$page, $storeInfo)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helperData = $objectManager->create('\Meetanshi\IndianGst\Helper\Data');
        $this->y = $this->y ? $this->y : 815;
        $image = $helperData->getSignature();

        if ( $image ) {
            $fileSystem = $objectManager->create('\Magento\Framework\Filesystem');
            $image = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath("indiangst/" . $helperData->getSignature());
            if ( is_file($image) ) {
                $mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath("indiangst/" . $helperData->getSignature());
                $image = \Zend_Pdf_Image::imageWithPath($mediaPath);

                $top = $this->y - 100; //top border of the page
                $widthLimit = 100; //half of the page width
                $heightLimit = 100; //assuming the image is not a "skyscraper"
                $width = $image->getPixelWidth();
                $height = $image->getPixelHeight();

                $ratio = $width / $height;
                if ( $ratio > 1 && $width > $widthLimit ) {
                    $width = $widthLimit;
                    $height = $width / $ratio;
                } elseif ( $ratio < 1 && $height > $heightLimit ) {
                    $height = $heightLimit;
                    $width = $height * $ratio;
                } elseif ( $ratio == 1 && $height > $heightLimit ) {
                    $height = $heightLimit;
                    $width = $widthLimit;
                }

                $y1 = $top - $height;
                $y2 = $top;
                $x1 = 450;
                $x2 = $x1 + $width;

                $imgY = $this->y - $height - 60;
                $font = $this->_setFontRegular($page, 10);
                $feed = $this->getAlignCenter(__($helperData->getSignatureText()), $x1, $width, $font, 10);
                $page->drawImage($image, $x1, $y1 + 100, $x2, $y2 + 100);
                $page->drawText(__($helperData->getSignatureText()), $feed, $this->y - 40, 'UTF-8');
                $page->drawText(__('Authorized Signatory'), $x1, $this->y - 60, 'UTF-8');

                $this->y = $y1 - 5;
            }
        }
    }

    protected function _setFontItalic($object, $size = 7)
    {
        $font = \Zend_Pdf_Font::fontWithPath(
            $this->_rootDirectory->getAbsolutePath('app/code/Meetanshi/IndianGst/lib/DejavuSans/ttf/DejaVuSans.ttf')
        );
        $object->setFont($font, $size);
        return $font;
    }
}
