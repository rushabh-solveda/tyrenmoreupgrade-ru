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

class Customer extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Webkul\PriceList\Model\PriceListFactory $priceList,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        $this->_priceList = $priceList;
        $this->_backendSession = $context->getSession();
        $this->_registry = $coreRegistry;
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $priceList = $this->_priceList->create();
        if ($this->getRequest()->getParam('id')) {
            $priceList->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $priceList->setData($data);
        }
        $this->_registry->register('pricelist_pricelist', $priceList);
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
