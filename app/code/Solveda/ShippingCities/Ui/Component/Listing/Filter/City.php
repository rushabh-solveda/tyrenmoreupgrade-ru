<?php

namespace Solveda\ShippingCities\Ui\Component\Listing\Filter;

use Magento\Framework\Data\OptionSourceInterface;
use Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory;

class City implements OptionSourceInterface
{
    /**
     * @var \Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param SellStCollectionFactoryatus $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Return Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $cities = $this->collectionFactory->create();
        $cities->setOrder('position', 'ASC');
        foreach ($cities as $city) {
            $options[] = [
                'label' => $city->getCityName(),
                'value' => $city->getEntityId(),
            ];
        }
        return $options;
    }
}
