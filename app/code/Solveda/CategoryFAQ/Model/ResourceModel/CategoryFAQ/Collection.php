<?php

namespace Solveda\CategoryFAQ\Model\ResourceModel\CategoryFAQ;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'solveda_categoryfaq_category_faq_collection';
    protected $_eventObject = 'category_faq_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Solveda\CategoryFAQ\Model\CategoryFAQ', 'Solveda\CategoryFAQ\Model\ResourceModel\CategoryFAQ');
    }
}
