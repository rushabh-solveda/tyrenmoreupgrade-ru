<?php 
namespace Navyuginfo\CascadeSearch\Model;
class Category extends \Magento\Framework\Model\AbstractModel
{


    protected function _construct()
    {
    }

    public function getChildCategories($categoryId)
    {
    // Find the parent category identifier in the request.
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


    return $response['subcategories'];

    }
}