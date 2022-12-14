<?php
/**
 * @category   Tyres
 * @package    Tyres_Faq
 * @author     anuj95455@gmail.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Tyres\Faq\Model\ResourceModel;

class Faq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('tyres_faq', 'faq_id');   //here "tyres_faq" is table name and "faq_id" is the primary key of custom table
    }
}