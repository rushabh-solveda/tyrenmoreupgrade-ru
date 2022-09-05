<?php
/**
 * @category   Clarksfield
 * @package    Clarksfield_Customersspeak
 * @author     nitish.bluethink@gmail.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Clarksfield\Customersspeak\Block;

use Magento\Framework\View\Element\Template\Context;
use Clarksfield\Customersspeak\Model\CustomersspeakFactory;
use Magento\Cms\Model\Template\FilterProvider;
/**
 * Customersspeak View block
 */
class CustomersspeakView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Customersspeak
     */
    protected $_customersspeak;
    public function __construct(
        Context $context,
        CustomersspeakFactory $customersspeak,
        FilterProvider $filterProvider
    ) {
        $this->_customersspeak = $customersspeak;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Clarksfield Customersspeak Module View Page'));
        
        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $customersspeak = $this->_customersspeak->create();
        $singleData = $customersspeak->load($id);
        if($singleData->getCustomersspeakId() || $singleData['customersspeak_id'] && $singleData->getStatus() == 1){
            return $singleData;
        }else{
            return false;
        }
    }
}