<?php 
namespace Advancetyre\Tyreadvanceserch\Controller\Index;

class Testdata extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
       $data = array(array('170',Array('171',Array('172'))),array('170',Array('171',Array(172))),array('170',Array('171',Array('172'))));
       echo "<pre>";
       print_r($data);
	}
}
