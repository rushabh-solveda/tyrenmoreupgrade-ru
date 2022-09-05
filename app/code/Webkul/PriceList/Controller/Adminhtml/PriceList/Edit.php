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
namespace Webkul\PriceList\Controller\Adminhtml\PriceList;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Webkul\PriceList\Model\PriceListFactory $priceList
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        $this->_priceList = $priceList;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $priceList = $this->_priceList->create();
        $id = (int)$this->getRequest()->getParam('id');
        if ($id) {
            $priceList->load($this->getRequest()->getParam('id'));
            if (!$priceList->getId()) {
                $this->messageManager->addError(__('Item does not exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $priceList->setData($data);
        }
        $this->_registry->register('pricelist_pricelist', $priceList);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Webkul_PriceList::pricelist');
        $resultPage->getConfig()->getTitle()->prepend(__('Price List'));
        $resultPage->getConfig()->getTitle()->prepend($id ? $priceList->getTitle() : __('New Price List'));
        return $resultPage;
    }
}
