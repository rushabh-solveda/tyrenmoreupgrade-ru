<?php
 
namespace Meetanshi\IndianGst\Model\Sales\Pdf;

use Magento\Sales\Model\Order\Pdf\Total\DefaultTotal;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;

class ShippingIgst extends DefaultTotal
{
    protected $helper;

    public function __construct(PricingHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getTotalsForDisplay()
    {
        $orderData = $this->getOrder();
        $amount = $orderData->getData('shipping_igst_amount');
        $priceHelper = $this->helper; // Instance of Pricing Helper
        $formattedPrice = $priceHelper->currency($amount, true, false);
        if ($this->getAmountPrefix()) {
            $amount = $this->getAmountPrefix() . $formattedPrice;
        }
 
        $title = __($this->getTitle());
        if ($this->getTitleSourceField()) {
            $label = $title . ' (' . $this->getTitleDescription() . '):';
        } else {
            $label = $title . ':';
        }
 
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        $total = ['amount' => $formattedPrice, 'label' => $label, 'font_size' => $fontSize];
        return [$total];
    }
}
