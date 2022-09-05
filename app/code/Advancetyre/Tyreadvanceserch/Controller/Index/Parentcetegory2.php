<?php 
namespace Advancetyre\Tyreadvanceserch\Controller\Index;
ob_start();

class Parentcetegory extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_storeManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);	
	}

	public function execute()
	{
		$catId = 3161;  //376;  //Parent Category ID
		$data = $this->getCategory($catId);


		echo json_encode($data);
	}

	protected function getCategory($catId)
	{
		$catData = array();
		$subCats = $this->getCatData($catId);
		$i = 0;
        foreach ($subCats as $subcat) 
        {
        	
        	$catData[$i]['entity_id'] = $subcat->getId();
        	$catData[$i]['name'] = $subcat->getName();
        	$catData[$i]['path'] = $subcat->getPath();
        	$catData[$i]['is_active'] = $subcat->getData('is_active');
        	$catData[$i]['is_anchor'] = $subcat->getData('is_anchor');
        	$catData[$i]['request_path'] = $subcat->getData('request_path');
        	$catData[$i]['childes'] = $this->getCategory($subcat->getId());

        	$i++;
        }
        return $catData;
	}

	protected function getCatData($catId){

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	    $subCategory = $objectManager->create('Magento\Catalog\Model\Category')->load($catId);
	    $subCats = $subCategory->getChildrenCategories();
	    return $subCats; 
	}
}
