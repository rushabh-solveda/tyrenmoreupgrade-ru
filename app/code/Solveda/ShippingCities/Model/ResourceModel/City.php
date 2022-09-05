<?php

namespace Solveda\ShippingCities\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;

class City extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('shipping_cities', 'entity_id');
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($this->getIsUniqueCity($object)) {
            throw new LocalizedException(
                __('A city with the same name "' . $object->getData('city_name') . '" already exists.')
            );
        }
        return $this;
    }

    /**
     * Check for unique of identifier of block to selected store(s).
     *
     * @param AbstractModel $object
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsUniqueCity(\Magento\Framework\Model\AbstractModel $object)
    {
        $select = $this->getConnection()->select()
            ->from(['cb' => $this->getMainTable()])
            ->where('cb.city_name = ?  ', $object->getData('city_name'));

        if ($object->getEntityId()) {
            $select->where('cb.entity_id <> ?', $object->getEntityId());
        }

        return $this->getConnection()->fetchRow($select);
    }
}
