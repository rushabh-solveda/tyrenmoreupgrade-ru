<?php
namespace Solveda\ShippingCities\Model\ResourceModel;

class Cities extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('solveda_cities', 'entity_id');
    }
}
