<?php

namespace Solveda\CategoryFAQ\Model\ResourceModel;

class CategoryFAQ extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('category_dynamic_faq', 'entity_id');
    }
}
