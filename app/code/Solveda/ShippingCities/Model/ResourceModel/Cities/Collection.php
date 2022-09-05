<?php
namespace Solveda\ShippingCities\Model\ResourceModel\Cities;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'solveda_shippingcities_cities_collection';
	protected $_eventObject = 'cities_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Solveda\ShippingCities\Model\Cities', 'Solveda\ShippingCities\Model\ResourceModel\Cities');
    }
}
