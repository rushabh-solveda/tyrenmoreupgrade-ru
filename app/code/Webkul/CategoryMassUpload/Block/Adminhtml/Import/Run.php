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
namespace Webkul\CategoryMassUpload\Block\Adminhtml\Import;

class Run extends \Magento\Backend\Block\Widget\Form\Container
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Initialize CategoryMassUpload Import Run block.
     *
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Webkul_CategoryMassUpload';
        $this->_controller = 'adminhtml_import';
        parent::_construct();
        $this->buttonList->remove('save');
        $this->buttonList->remove('delete');
        $this->buttonList->remove('back');
        $this->buttonList->remove('reset');
    }

    public function returnRegistry()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $slct_options = $objectManager->create("Magento\Framework\Registry");
        return $slct_options;
    }
    /**
     * Get Header Text.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Manage Mass Upload');
    }

    /**
     * Check permission for passed action.
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
