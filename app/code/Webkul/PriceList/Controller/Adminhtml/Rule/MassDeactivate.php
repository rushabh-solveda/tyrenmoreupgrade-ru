<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\PriceList\Model\ResourceModel\Rule\CollectionFactory;

class MassDeactivate extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_PriceList::rule');
    }

    public function execute()
    {
        $ruleIds = [];
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        foreach ($collection as $rule) {
            $this->updateItem($rule, 2);
        }
        $this->messageManager->addSuccess(__('Rule(s) deactivated succesfully'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param object $item
     * @param int $status
     */
    public function updateItem($item, $status)
    {
        $item->setStatus($status)->save();
    }
}
