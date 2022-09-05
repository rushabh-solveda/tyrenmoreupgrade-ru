<?php
namespace Solveda\Catlog\Model;

use Magento\Framework\Model\AbstractModel;

class EmiDetails extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Solveda\Catlog\Model\ResourceModel\EmiDetails');
    }
}