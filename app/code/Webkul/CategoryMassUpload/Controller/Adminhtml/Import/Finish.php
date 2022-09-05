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

class Finish extends \Magento\Backend\App\Action
{
    /**
     * @param Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $result = [];
        $total = (int) $this->getRequest()->getParam('row');
        $skipCount = (int) $this->getRequest()->getParam('skip');
        $total = $total - $skipCount;
        $msg = '<div class="wk-mu-success wk-mu-box">';
        $msg .= __('Total %1 Category(s) Imported.', $total);
        $msg .= '</div>';
        $msg .= '<div class="wk-mu-note wk-mu-box">';
        $msg .= __('Finished Execution.');
        $msg .= '</div>';
        $result['msg'] = $msg;
        $result = $this->jsonHelper->jsonEncode($result);
        $this->getResponse()->representJson($result);
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
