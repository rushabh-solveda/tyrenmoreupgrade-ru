<?php
namespace Solveda\ShippingCities\Model\ResourceModel\City;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'solveda_shippingcities_city_collection';
	protected $_eventObject = 'city_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Solveda\ShippingCities\Model\City', 'Solveda\ShippingCities\Model\ResourceModel\City');
    }
}
