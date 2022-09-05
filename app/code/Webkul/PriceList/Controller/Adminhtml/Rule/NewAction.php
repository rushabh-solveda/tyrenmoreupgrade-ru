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
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
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

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        $result->forward('edit');
        return $result;
    }
}
