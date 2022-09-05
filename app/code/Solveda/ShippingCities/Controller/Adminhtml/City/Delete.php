<?php

declare(strict_types=1);

namespace Solveda\ShippingCities\Controller\Adminhtml\City;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Solveda_ShippingCities::manage_cities';

    /**
     * @param \Solveda\ShippingCities\Model\CityFactory
     */
    private $cityFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Solveda\ShippingCities\Model\CityFactory $cityFactory
    ) {
        $this->cityFactory = $cityFactory;
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
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $model = $this->cityFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the City.'));
                return $resultRedirect->setPath('*/*/grid');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/grid');
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a City to delete.'));
        return $resultRedirect->setPath('*/*/grid');
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
