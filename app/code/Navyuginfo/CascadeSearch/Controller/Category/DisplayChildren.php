<?php
namespace Navyuginfo\CascadeSearch\Controller\Category;
use Magento\Framework\Controller\ResultFactory;

class DisplayChildren extends \Magento\Framework\App\Action\Action
{
  public function __construct(
\Magento\Framework\App\Action\Context $context)
  {
	return parent::__construct($context);
  }

  public function execute()
  {
	// Find the parent category identifier in the request.
	$categoryId = $this->getRequest()->getParam('categoryId', null);
	$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$category = $_objectManager->create('Magento\Catalog\Model\Category')
							->load($categoryId);

	// Populate the child categories in the response.
	$children = $category->getChildrenCategories();
	$response = array();
	$response['success'] = false;
	$response['subcategories'] = array();
	foreach($children as $child) {
		$child->load($child->getId());

		if($child->getIsActive() && $child->getIncludeInMenu()) {
			$childArray = array();
			$childArray['name'] = $child->getName();
			$childArray['URL'] = $child->getUrl();
			$childArray['id'] = $child->getId();
		

			$response['subcategories'][] = $childArray;
	  }
	}

	if(!empty($response['subcategories'])) {
		$response['success'] = true;
	}

	$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
	$resultJson->setData($response);

	return $resultJson;
  }
}

?>