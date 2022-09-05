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
namespace Webkul\CategoryMassUpload\Block\Adminhtml\Import\Edit;

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
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
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
                'action' => $this->getUrl('categorymassupload/import/run'),
                'method' => 'post']
            ]
        );
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Import Categories'),
                'class' => 'fieldset-wide'
            ]
        );
        $fieldset->addField(
            'massupload_csv',
            'file',
            [
                'name' => 'massupload_csv',
                'label' => __('Upload CSV/XLS/XML'),
                'title' => __('Upload CSV/XLS/XML'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'massupload_images',
            'file',
            [
                'name' => 'massupload_images',
                'label' => __('Upload Images Zip File'),
                'title' => __('Upload Images Zip File'),
                'required' => false
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
