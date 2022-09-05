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

class Delete extends Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\PriceList\Model\PriceListFactory $pricelist
    ) {
        $this->_pricelist = $pricelist;
        parent::__construct($context);
    }

    public function execute()
    {
        $pricelist = $this->_pricelist->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->getParam('id')) {
            try {
                $pricelist->load($this->getRequest()->getParam('id'));
                if (!$pricelist->getId()) {
                    $this->messageManager->addError(__('Pricelist does not exists'));
                } else {
                    $pricelist->delete();
                    $this->messageManager->addSuccess(__('Pricelist deleted succesfully'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong'));
            }
            return $resultRedirect->setPath('*/*/');
        }
        $this->messageManager->addError(__('Something went wrong'));
        return $resultRedirect->setPath('*/*/');
    }
}
