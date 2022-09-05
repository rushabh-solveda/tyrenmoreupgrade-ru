<?php

declare(strict_types=1);

namespace Solveda\CategoryFAQ\Controller\Adminhtml\Index;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Solveda_CategoryFAQ::addnew';

    /**
     * @param \Solveda\CategoryFAQ\Model\CategoryFAQFactory
     */
    private $categoryFAQFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Solveda\CategoryFAQ\Model\CategoryFAQFactory $categoryFAQFactory
    ) {
        $this->categoryFAQFactory = $categoryFAQFactory;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->categoryFAQFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the Category FAQ.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/index');
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a category FAQ to delete.'));
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
