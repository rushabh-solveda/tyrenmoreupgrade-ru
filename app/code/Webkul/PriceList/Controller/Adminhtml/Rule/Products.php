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
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Products extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\PriceList\Model\PriceListFactory $priceList,
        \Webkul\PriceList\Model\RuleFactory $rule,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        $this->_priceList = $priceList;
        $this->_rule = $rule;
        $this->_backendSession = $context->getSession();
        $this->_registry = $coreRegistry;
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $rule = $this->_rule->create();
        if ($this->getRequest()->getParam('id')) {
            $rule->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $rule->setData($data);
        }
        $this->_registry->register('pricelist_rule', $rule);
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
