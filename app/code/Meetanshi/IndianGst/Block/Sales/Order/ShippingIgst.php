<?php
namespace Meetanshi\IndianGst\Block\Sales\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\IndianGst\Helper\Data as HelperData;
use Magento\Directory\Model\Currency;
use Magento\Framework\DataObject;

/**
 * Class ShippingIgst
 * @package Meetanshi\IndianGst\Block\Sales\Order
 */
class ShippingIgst extends Template
{
    /**
     * @var HelperData
     */
    protected $helper;
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * ShippingIgst constructor.
     * @param Context $context
     * @param HelperData $helper
     * @param Currency $currency
     * @param array $data
     */
    public function __construct(Context $context, HelperData $helper, Currency $currency, array $data = [])
    {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->currency = $currency;
    }

    /**
     * Retrieve current order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }

    /**
     *
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getOrder();
        $this->getSource();

    
        if (!$this->getSource()->getShippingIgstAmount() || $this->getSource()->getShippingIgstAmount() <= 0) {
            return $this;
        }
        $total = new DataObject(
            [
                'code' => 'shipping_igst_amount',
                'value' => $this->getSource()->getShippingIgstAmount(),
                'label' => 'Shipping IGST',
            ]
        );
       
        $this->getParentBlock()->addTotalBefore($total, 'grand_total');

        return $this;
    }
}
