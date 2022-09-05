<?php
namespace Navyuginfo\CascadeSearch\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Search extends Template  implements BlockInterface{


	protected $_selectedCategoryId;
	protected $_selectedChildCategoryId;
	protected $_selectedSearchTab = "CATEGORY_TAB";
	protected $_selectedSearchPinTab = "FIRST_PIN";

	protected $attributeCode1_car = null;
	protected $attributeCode2_car = null;
	protected $attributeCode3_car = null;
	protected $attributeCode1_bike = null;
	protected $attributeCode2_bike = null;
	protected $attributeCode3_bike = null;

	protected $_objectManager = null;
	public $_store = null;

	protected $_attributeSet;

	protected $_params;


	protected $_template = "widget/search.phtml";



	public function __construct(

		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Checkout\Model\CompositeConfigProvider $configProvider,

		array $layoutProcessors = [],

		array $data = []

	) {

		parent::__construct($context, $data);

		$this->_params = $this->getRequest()->getParams();
		$this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$this->configProvider = $configProvider;
		$this->_layoutProcessors = $layoutProcessors;

	}
	protected function _prepareLayout()
	    {
				$urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
	      $currenturl=$urlInterface->getCurrentUrl();
				$currenturl_part=preg_split('#/#', $currenturl);
				if($currenturl_part[2]=='tyresnmore.com'){
					$Width= array("56"=>"135","57"=>"140","58"=>"145","59"=>"150","60"=>"155","61"=>"165","62"=>"175","63"=>"185","64"=>"195","65"=>"205","66"=>"215","67"=>"225",
					"68"=>"235","69"=>"245","70"=>"255","71"=>"265","72"=>"275","73"=>"285","74"=>"295","112"=>"2.75","113"=>"3","114"=>"3.25","170"=>"3.5","116"=>"80",
					"117"=>"90","118"=>"100","120"=>"120","121"=>"130","122"=>"140");

					$Profile= array("11" =>"70","9" =>"60","13" =>"80","10" =>"65","8" =>"55","14" =>"85","7" =>"50","5" =>"40","6" =>"45","4" =>"35","12" =>"75",
					"128"=>"None","102"=>"70","103"=>"80","104"=>"90","105"=>"100");

					$Rim=array("107"=>"17","108"=>"18","165"=>"10","107"=>"17","109"=>"19","166"=>"12","25"=>"12","30"=>"17","26"=>"13","27"=>"14","28"=>"15","29"=>"16",
					"31"=>"18","32"=>"19","33"=>"20");

				}
				else{
					$Width= array("123"=>"31","46"=>"135","126"=>"140","47"=>"145","48"=>"155","49"=>"165","50"=>"175","51"=>"185","52"=>"195","53"=>"205","54"=>"215",
					"55"=>"225","56"=>"235","57"=>"245","58"=>"255","59"=>"265","60"=>"275","61"=>"285","62"=>"295","63"=>"305","103"=>"100");

					$Profile= array("144"=>"None", "124"=>"10.5","3"=>"55","4"=>"60","5"=>"65","6"=>"70","8"=>"80","117"=>"45","118"=>"50","116"=>"40","7"=>"75",
					"127"=>"35","128"=>"30");

					$Rim=array("143"=>"23","20"=>"15","17"=>"12","22"=>"17","18"=>"13","19"=>"14","20"=>"15","21"=>"16","22"=>"17","23"=>"18","24"=>"19","25"=>"20","26"=>"21","27"=>"22");

				}

				$title_array=$this->_params;
				        if(array_key_exists("car_tyre_width",$title_array)){

				              if(!array_key_exists($title_array['car_tyre_width'], $Width)){
				                $Width[$title_array['car_tyre_width']]=$title_array['car_tyre_width'];
				              }
				              if(!array_key_exists($title_array['car_tyre_aspect'], $Profile)){
				                $Profile[$title_array['car_tyre_aspect']]=$title_array['car_tyre_aspect'];
				              }
				              if(!array_key_exists($title_array['car_tyre_rim'], $Rim)){
				                $Rim[$title_array['car_tyre_rim']]=$title_array['car_tyre_rim'];
				              }

				             $title='W'.$Width[$title_array['car_tyre_width']].' '.'P'.$Profile[$title_array['car_tyre_aspect']].' '.'R'.$Rim[$title_array['car_tyre_rim']].' - Buy Car Tyres and Bike Tyres Online in India for Best Price';

				               $this->pageConfig->getTitle()->set($title);
				        }
				        else if(array_key_exists("bike_tyre_width",$title_array)){

				            if(!array_key_exists($title_array['bike_tyre_width'], $Width)){
				                $Width[$title_array['bike_tyre_width']]=$title_array['bike_tyre_width'];
				              }
				              if(!array_key_exists($title_array['bike_tyre_aspect'], $Profile)){
				                $Profile[$title_array['bike_tyre_aspect']]=$title_array['bike_tyre_aspect'];
				              }
				              if(!array_key_exists($title_array['bike_tyre_rim'], $Rim)){
				                $Rim[$title_array['bike_tyre_rim']]=$title_array['bike_tyre_rim'];
				              }

				             $title='W'.$Width[$title_array['bike_tyre_width']].' '.'P'.$Profile[$title_array['bike_tyre_aspect']].' '.'R'.$Rim[$title_array['bike_tyre_rim']].' - Buy Car Tyres and Bike Tyres Online in India for Best Price';

				               $this->pageConfig->getTitle()->set($title);
				        }
 							return parent::_prepareLayout();
			}

	private function checkIfBikeAttributesArePresent($params)
	{

		return $params &&
			array_key_exists($this->attributeCode1_bike, $params) &&
			array_key_exists($this->attributeCode2_bike, $params) &&
			array_key_exists($this->attributeCode3_bike, $params);
	}

	private function checkIfCarAttributesArePresent($params)
	{


		return $params &&
			array_key_exists($this->attributeCode1_car, $params) &&
			array_key_exists($this->attributeCode2_car, $params) &&
			array_key_exists($this->attributeCode3_car, $params);
	}

	public function getCarAttribute1()
	{
		return $this->getData("car_attribute_1");
	}

	public function getCarAttribute2()
	{
		return $this->getData("car_attribute_2");
	}

	public function getCarAttribute3()
	{
		return $this->getData("car_attribute_3");
	}

	public function getAttribute1(){

		return $this->getAttributeValue($this->attributeCode1_car, $this->attributeCode1_bike);

	}

	public function getBikeAttribute1()
	{
		return $this->getData("bike_attribute_1");
	}

	public function getBikeAttribute2()
	{
		return $this->getData("bike_attribute_2");
	}

	public function getBikeAttribute3()
	{
		return $this->getData("bike_attribute_3");
	}

	public function getAttribute2(){

		return $this->getAttributeValue($this->attributeCode2_car, $this->attributeCode2_bike);

	}

	public function getAttribute3(){

		return $this->getAttributeValue($this->attributeCode3_car, $this->attributeCode3_bike);

	}

	public function getAttributeValue($attr1, $attr2){

		$params = $this->_params;
		$value1 = @$params[$attr1];
		$value2 = @$params[$attr2];

		if($value1!=null && !is_array($value1))
			return $value1;
		else if($value2!=null && !is_array($value2))
			return $value2;

		return "null";
	}



	public function getJsLayout()

	{

		foreach ($this->_layoutProcessors as $processor) {

			$this->jsLayout = $processor->process($this->jsLayout);

		}

		return parent::getJsLayout();

	}



	public function getChildCategories($categoryId)
	{

		$model = $this->_objectManager->get('\Navyuginfo\CascadeSearch\Model\Category');
		return $model->getChildCategories($categoryId);

	}


	public function getCarAttributeSet()
	{


		$attributeCodes = 	[ $this->attributeCode1_car, $this->attributeCode2_car, $this->attributeCode3_car];


		$attributeSetModel = $this->_objectManager->get('\Navyuginfo\CascadeSearch\Model\AttributeSet');
		$attributeSet = $attributeSetModel->getAttributeSet($attributeCodes);
		return $attributeSet;
	}


	public function getBikeAttributeSet()
	{

		$attributeCodes = 	[ $this->attributeCode1_bike, $this->attributeCode2_bike, $this->attributeCode3_bike];


		$attributeSetModel = $this->_objectManager->get('\Navyuginfo\CascadeSearch\Model\AttributeSet');
		$attributeSet = $attributeSetModel->getAttributeSet($attributeCodes);
		return $attributeSet;
	}




	public function getTabDetails()
	{

		$this->_selectedCategoryId = null;
		$this->_selectedChildCategoryId = null;
		$this->_selectedSearchTab = null;
		$this->_selectedSearchPinTab = null;

		$this->attributeCode1_bike = $this->getData("bike_attribute_1");
		$this->attributeCode2_bike = $this->getData("bike_attribute_2");
		$this->attributeCode3_bike = $this->getData("bike_attribute_3");
		$this->attributeCode1_car = $this->getData("car_attribute_1");
		$this->attributeCode2_car = $this->getData("car_attribute_2");
		$this->attributeCode3_car = $this->getData("car_attribute_3");

		//initializing
		$this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$category = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_category');
		$storeManager = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface');
		$this->_store = $storeManager->getStore();


		$categoryIds = [];

		if($category != null)
		{
			$this->_selectedSearchTab = "CATEGORY_TAB";

			foreach ($category->getParentCategories() as $parent) {
				array_push($categoryIds, $parent->getId());
			}

			$this->_selectedChildCategoryId = end($categoryIds);
			$this->_selectedCategoryId = prev($categoryIds);

			$parentCategoryId = prev($categoryIds);
			$firstCategoryId = (int)(explode("/", $this->getData("category_id_1"))[1]);
			$secondCategoryId = (int)(explode("/", $this->getData("category_id_2"))[1]);

			if($parentCategoryId!=$firstCategoryId && $parentCategoryId!=$secondCategoryId)
			{
				$this->_selectedCategoryId = "null";
				$this->_selectedChildCategoryId = "null";
			}



			if($categoryIds[0]==$secondCategoryId)
				$this->_selectedSearchPinTab = "SECOND_PIN";
			else
				$this->_selectedSearchPinTab = "FIRST_PIN";


		}else{

				if($this->checkIfBikeAttributesArePresent($this->_params)) {
					$this->_selectedSearchTab = "ATTRIBUTE_TAB";
					$this->_selectedSearchPinTab = "SECOND_PIN";
				}else if($this->checkIfCarAttributesArePresent($this->_params))
				{
					$this->_selectedSearchTab = "ATTRIBUTE_TAB";
					$this->_selectedSearchPinTab = "FIRST_PIN";
				}

		}

	}

	public function getSelectedCategoryId()
	{
		if ($this->_selectedCategoryId == null)
			return "null";

		return $this->_selectedCategoryId;

	}

	public function getSelectedChildCategoryId()
	{
		if ($this->_selectedChildCategoryId == null)
			return "null";

		return $this->_selectedChildCategoryId;

	}

	public function getSelectedSearchTab()
	{
		return $this->_selectedSearchTab;

	}

	public function getSelectedSearchPinTab()
	{
		return $this->_selectedSearchPinTab;

	}


}
