<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace FME\Contactus\Controller\Adminhtml\Index;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_Contactus::contactus');
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('contact_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('FME\Contactus\Model\Contact');
                $model->load($id);
                $title = $model->getName();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The Submission has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch(
                    'adminhtml_news_on_delete',
                    ['name' => $title, 'status' => 'success']
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_news_on_delete',
                    ['name' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['contact_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Submissions to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
