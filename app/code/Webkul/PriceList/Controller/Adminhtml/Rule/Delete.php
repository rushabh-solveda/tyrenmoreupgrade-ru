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

use Magento\Backend\App\Action;

class Delete extends Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\PriceList\Model\RuleFactory $rule
    ) {
        $this->_rule = $rule;
        parent::__construct($context);
    }

    public function execute()
    {
        $rule = $this->_rule->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->getParam('id')) {
            try {
                $rule->load($this->getRequest()->getParam('id'));
                if (!$rule->getId()) {
                    $this->messageManager->addError(__('Rule does not exists'));
                } else {
                    $rule->delete();
                    $this->messageManager->addSuccess(__('Rule deleted succesfully'));
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
