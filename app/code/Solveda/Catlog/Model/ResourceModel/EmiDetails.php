<?php
namespace Solveda\Catlog\Model\ResourceModel;
class EmiDetails extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('emi_details', 'emi_id');   //here "emi_details" is table name and "emi_id" is the primary key of custom table
    }
}