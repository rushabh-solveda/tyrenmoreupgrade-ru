<?php 
namespace Solveda\Catlog\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Index extends Action {
protected $request;

	public function execute() {
	    $data = array();
	    $query = $this->getRequest()->getParam('totalprice'); 
	    $this->_view->loadLayout();
	    $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
	    $data['html'] = $this->_view->getLayout()
                     ->createBlock("\Solveda\Catlog\Block\Emi")
                     ->setTemplate("Solveda_Catlog::emicheckout.phtml")
                     ->setData('totalprice', $query)
                     ->toHtml();
		$data['emi'] = $this->_view->getLayout()
                     ->createBlock("\Solveda\Catlog\Block\Emi")
                     ->setTemplate("Solveda_Catlog::emistartingcheckout.phtml")
                     ->setData('totalprice', $query)
                     ->toHtml();
		$data['pdp'] = $this->_view->getLayout()
					 ->createBlock("\Solveda\Catlog\Block\Emi")
					 ->setTemplate("Solveda_Catlog::emiStartingPdp.phtml")
					 ->setData('product_emi_price', $query)
					 ->toHtml();
	    $resultJson->setData($data);
	    return $resultJson;

	}
}
