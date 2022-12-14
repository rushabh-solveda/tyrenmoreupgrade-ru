<?php
/**
 * @category   Clarksfield
 * @package    Clarksfield_Customersspeak
 * @author     nitish.bluethink@gmail.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Clarksfield\Customersspeak\Model\ResourceModel\Customersspeak;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'customersspeak_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Clarksfield\Customersspeak\Model\Customersspeak',
            'Clarksfield\Customersspeak\Model\ResourceModel\Customersspeak'
        );
    }
}