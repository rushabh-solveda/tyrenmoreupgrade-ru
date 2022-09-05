<?php
/**
 * @category   Tyresclarksfield
 * @package    Tyresclarksfield_Testimonials
 * @author     mukesh.bluethink@gmail.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Tyresclarksfield\Testimonials\Block;

use Magento\Framework\View\Element\Template\Context;
use Tyresclarksfield\Testimonials\Model\TestimonialsFactory;
use Magento\Cms\Model\Template\FilterProvider;
/**
 * Testimonials View block
 */
class TestimonialsView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Testimonials
     */
    protected $_testimonials;
    public function __construct(
        Context $context,
        TestimonialsFactory $testimonials,
        FilterProvider $filterProvider
    ) {
        $this->_testimonials = $testimonials;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Tyresclarksfield Testimonials Module View Page'));
        
        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $testimonials = $this->_testimonials->create();
        $singleData = $testimonials->load($id);
        if($singleData->getTestimonialsId() || $singleData['testimonials_id'] && $singleData->getStatus() == 1){
            return $singleData;
        }else{
            return false;
        }
    }
}