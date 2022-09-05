<?php
namespace Solveda\Catlog\Model;

use Magento\Framework\Model\AbstractModel;

class EmiBank extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Solveda\Catlog\Model\ResourceModel\EmiBank');
    }
}