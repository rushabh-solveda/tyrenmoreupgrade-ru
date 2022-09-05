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
namespace Webkul\CategoryMassUpload\Block\Adminhtml\Export\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Webkul\CategoryMassUpload\Helper\Data $massUploadHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Webkul\CategoryMassUpload\Helper\Data $massUploadHelper,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->massUploadHelper = $massUploadHelper;
    }

    /**
     * Init form.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('upload_form');
        $this->setTitle(__('Mass Upload'));
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getUrl('categorymassupload/export/export'),
                'method' => 'post']
            ]
        );
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Export Categories'),
                'class' => 'fieldset-wide'
            ]
        );
        $fieldset->addField(
            'store_id',
            'select',
            [
                'name'  => 'store_id',
                'label' => __('Select Store View'),
                'text' => __('Select Store View'),
                'values'  => $this->massUploadHelper->getAllStoresNames()
            ]
        );
        
        $fieldset->addField(
            'export_categories',
            'submit',
            [
                'name'  => 'export_categories',
                'text' => __('Export Categories'),
                'label' => __(' '),
                'style' => 'width:178px',
                'class' => 'action-default',
                'value'     => __('Export Categories'),
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
