<?php

namespace Solveda\ShippingCities\Block\Order;

use Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory;

class Totals extends \Magento\Sales\Block\Order\Totals
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $this->_coreRegistry);
    }


    /**
     * @return $this
     */
    protected function _initTotals()
    {
        $parent = parent::_initTotals();
        $source = $this->getSource();
        $this->_totals = $parent->_totals;
        $this->_totals['subtotal'] = new \Magento\Framework\DataObject(
            [
                'code' => 'subtotal',
                'value' => $source->getSubtotal(),
                'label' => __('Subtotal')
            ]
        );

        if (!$source->getIsVirtual() && ((float)$source->getShippingAmount() || $source->getShippingDescription())) {

            $shippingCityId = $this->getSource()->getCustomCityId();

            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('entity_id', ['eq' => $shippingCityId]);

            $displayInputForCity = 0;
            $shippingText = 'Doorstep Fitment Fees';
            if ($collection->count()) {
                $city = $collection->getFirstItem();
                $displayInputForCity = $city->getDisplayInputForCity();
            }
            if ($displayInputForCity) {
                $shippingText = 'Shipping & Handling';
            }

            $this->_totals['shipping'] = new \Magento\Framework\DataObject(
                [
                    'code' => 'shipping',
                    'field' => 'shipping_amount',
                    'value' => $this->getSource()->getShippingAmount(),
                    'label' => __($shippingText),
                ]
            );
        }

        return $this;
    }
}
