<?php

namespace Meetanshi\IndianGst\Block\Sales\Order;

use Magento\Framework\View\Element\Template\Context;
use Meetanshi\IndianGst\Helper\Data as HelperData;
use Magento\Directory\Model\Currency;
use Magento\Framework\DataObject;

/**
 * Class Gst
 * @package Meetanshi\IndianGst\Block\Sales\Order
 */
class Gst extends \Magento\Framework\View\Element\Template
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
     * Gst constructor.
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
     * Get label cell tag properties
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * Get order store object
     *
     * @return \Magento\Sales\Model\Order
     * @codeCoverageIgnore
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * Get totals source object
     *
     * @return \Magento\Sales\Model\Order
     * @codeCoverageIgnore
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Get value cell tag properties
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        if ((double)$this->getOrder()->getCgstAmount()) {
            $source = $this->getSource();
            $value = $source->getCgstAmount();

            $this->getParentBlock()->addTotal(
                new \Magento\Framework\DataObject(
                    [
                        'code' => 'cgst_amount',
                        'strong' => false,
                        'label' => 'CGST',
                        'value' => $value,
                    ]
                )
            );
        }

        if ((double)$this->getOrder()->getUtgstAmount()) {
            $source = $this->getSource();
            $value = $source->getUtgstAmount();
            $this->getParentBlock()->addTotal(
                new \Magento\Framework\DataObject(
                    [
                        'code' => 'utgst_amount',
                        'strong' => false,
                        'label' => 'UTGST',
                        'value' => $value,
                    ]
                )
            );
        }

        if ((double)$this->getOrder()->getSgstAmount()) {
            $source = $this->getSource();
            $value = $source->getSgstAmount();

            $this->getParentBlock()->addTotal(
                new \Magento\Framework\DataObject(
                    [
                        'code' => 'sgst_amount',
                        'strong' => false,
                        'label' => 'SGST',
                        'value' => $value,
                    ]
                )
            );
        }


        if ((double)$this->getOrder()->getIgstAmount()) {
            $source = $this->getSource();
            $value = $source->getIgstAmount();

            $this->getParentBlock()->addTotal(
                new \Magento\Framework\DataObject(
                    [
                        'code' => 'igst_amount',
                        'strong' => false,
                        'label' => 'IGST',
                        'value' => $value,
                    ]
                )
            );
        }

        return $this;
    }
}
