<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_CategoryMassUpload
 * @author    Webkul Software Private Limited
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\CategoryMassUpload\Controller\Adminhtml\Import;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $content = $resultPage->getLayout()->createBlock(\Webkul\CategoryMassUpload\Block\Adminhtml\Import\Index::class);
        $resultPage->addContent($content);
        $resultPage->setActiveMenu('Webkul_CategoryMassUpload::import');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Category Import'));
        return $resultPage;
    }
    /**
     * Check for is allowed.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_CategoryMassUpload::import');
    }
}
