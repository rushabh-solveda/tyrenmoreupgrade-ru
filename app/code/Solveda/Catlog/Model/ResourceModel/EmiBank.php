<?php
namespace Solveda\Catlog\Model\ResourceModel;
class EmiBank extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('emi_bank', 'bank_id');
    }
}