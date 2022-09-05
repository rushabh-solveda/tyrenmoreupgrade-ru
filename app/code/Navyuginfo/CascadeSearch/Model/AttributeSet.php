<?php 
namespace Navyuginfo\CascadeSearch\Model;

class AttributeSet extends \Magento\Framework\Model\AbstractModel
{


	protected function _construct()
	{
	}

	
	public function getAttributeSet($attributeCodes)
	{

		$attributeCode1 = $attributeCodes[0];
		$attributeCode2 = $attributeCodes[1];
		$attributeCode3 = $attributeCodes[2];


		$products = \Magento\Framework\App\ObjectManager::getInstance()
			->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
			->addAttributeToSelect(array($attributeCode1, $attributeCode2, $attributeCode3, $attributeCode1."_value", $attributeCode2."_value", $attributeCode3."_value"))
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode1,'notnull' => true)
				))
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode1,'neq' => true)
				))				
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode2,'notnull' => true)
				))
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode2,'neq' => true)
				))		
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode3,'notnull' => true)
				))
			->addAttributeToFilter(
				array(
					array('attribute'=> $attributeCode3,'neq' => true)
				))		
			->distinct(true);


		$products->getSelect()->group(array($attributeCode1,$attributeCode2,$attributeCode3))->distinct(true);
		$products = $products->load();


		$attribute1Method = "get".$this->camelize($attributeCode1, "_");
		$attribute2Method = "get".$this->camelize($attributeCode2, "_");
		$attribute3Method = "get".$this->camelize($attributeCode3, "_");

		$attribute1ValueMethod = $attribute1Method."Value";
		$attribute2ValueMethod = $attribute2Method."Value";
		$attribute3ValueMethod = $attribute3Method."Value";


		$attributeObjects = [];

		foreach ($products as $product) {
			array_push($attributeObjects, 
				["attribute_1" => ["id" => $product->$attribute1Method(), "value" => $product->$attribute1ValueMethod()], 
				 "attribute_2" => ["id" => $product->$attribute2Method(), "value" => $product->$attribute2ValueMethod()],
				 "attribute_3"=> ["id" => $product->$attribute3Method(), "value" => $product->$attribute3ValueMethod()]
				]); 
		}


		return $attributeObjects;


	} 


	function camelize($input, $separator = '_')
	{

		return str_replace($separator, '', ucwords($input, $separator));
	}


}    