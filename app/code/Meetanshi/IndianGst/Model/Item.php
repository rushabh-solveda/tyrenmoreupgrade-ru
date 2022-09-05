<?php
namespace Meetanshi\IndianGst\Model;

use Magento\Framework\Model\AbstractModel;

abstract class Item extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    abstract function getIdentities();
    protected function _construct()
    {
        $this->_init('Meetanshi\IndianGst\Model\ResourceModel\Item');
    }
}
