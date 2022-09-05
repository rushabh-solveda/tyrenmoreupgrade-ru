<?php
namespace Solveda\Catlog\Model\ResourceModel\EmiBank;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'emi_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Solveda\Catlog\Model\EmiBank',
            'Solveda\Catlog\Model\ResourceModel\EmiBank'
        );
    }
}

