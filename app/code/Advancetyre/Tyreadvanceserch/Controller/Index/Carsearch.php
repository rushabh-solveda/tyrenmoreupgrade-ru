<?php 
namespace Advancetyre\Tyreadvanceserch\Controller\Index;
ob_start();
class Carsearch extends \Magento\Framework\App\Action\Action
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
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$atrributesRepository  = $objectManager->create('\Magento\Catalog\Model\Product\Attribute\Repository');
		$selectcarwith = $atrributesRepository->get('car_tyre_width')->getOptions();
		$selectcarprofile = $atrributesRepository->get('car_tyre_aspect')->getOptions();
		$selectcarrim = $atrributesRepository->get('car_tyre_rim')->getOptions();
		/*Width:
		Array ( [label] => [value] => ) Array ( [value] => 5725 [label] => 135 ) Array ( [value] => 5726 [label] => 140 ) Array ( [value] => 5727 [label] => 145 ) Array ( [value] => 5728 [label] => 150 ) Array ( [value] => 5729 [label] => 155 ) Array ( [value] => 5730 [label] => 165 ) Array ( [value] => 5731 [label] => 175 ) Array ( [value] => 5732 [label] => 185 ) Array ( [value] => 5733 [label] => 195 ) Array ( [value] => 5734 [label] => 205 ) Array ( [value] => 5735 [label] => 215 ) Array ( [value] => 5736 [label] => 225 ) Array ( [value] => 5737 [label] => 235 ) Array ( [value] => 5738 [label] => 245 ) Array ( [value] => 5739 [label] => 255 ) Array ( [value] => 5740 [label] => 265 ) Array ( [value] => 5741 [label] => 275 ) Array ( [value] => 5742 [label] => 285 ) Array ( [value] => 5743 [label] => 295 ) Array ( [value] => 5744 [label] => 305 ) Array ( [value] => 5745 [label] => 310 ) Array ( [value] => 5746 [label] => 315 ) Array ( [value] => 5747 [label] => 335 ) Array ( [value] => 5748 [label] => 375 ) Array ( [value] => 5749 [label] => 31 )*/
		/*profile:
		Array ( [label] => [value] => ) Array ( [value] => 5672 [label] => 30 ) Array ( [value] => 5673 [label] => 35 ) Array ( [value] => 5674 [label] => 40 ) Array ( [value] => 5675 [label] => 45 ) Array ( [value] => 5676 [label] => 50 ) Array ( [value] => 5677 [label] => 55 ) Array ( [value] => 5678 [label] => 60 ) Array ( [value] => 5679 [label] => 65 ) Array ( [value] => 5680 [label] => 70 ) Array ( [value] => 5681 [label] => 75 ) Array ( [value] => 5682 [label] => 80 ) Array ( [value] => 5683 [label] => 85 ) Array ( [value] => 5684 [label] => 90 ) Array ( [value] => 5685 [label] => 95 ) Array ( [value] => 5686 [label] => 100 ) Array ( [value] => 5687 [label] => 10.5 )
		*/
		/*rim:
		Array ( [label] => [value] => ) Array ( [value] => 5692 [label] => 10 ) Array ( [value] => 5693 [label] => 11 ) Array ( [value] => 

		 [label] => 12 ) Array ( [value] => 5695 [label] => 13 ) Array ( [value] => 5696 [label] => 14 ) Array ( [value] => 5697 [label] => 15 ) Array ( [value] => 5698 [label] => 16 ) Array ( [value] => 5699 [label] => 17 ) Array ( [value] => 5700 [label] => 18 ) Array ( [value] => 5701 [label] => 19 ) Array ( [value] => 5702 [label] => 20 ) Array ( [value] => 5703 [label] => 21 ) Array ( [value] => 5704 [label] => 22 )
		*/
			$url="https://tyresnmore.com/catalogsearch/advanced/result/?";
		$data=
		Array
		(
		    Array
		    (
			    "carid"=>'5725',"label"=>"135", "value"=>"5725",
				Array
				("carid"=>'5725',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5725&car_tyre_aspect=5680",
					Array
					("profileid"=>"5680","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5725&car_tyre_aspect=5680&car_tyre_rim=5694"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5725&car_tyre_aspect=5680&car_tyre_rim=5699"
				    )
			    )
		    ),
		   /* Array
		    (
			    "carid"=>'5726',"label"=>"140", "value"=>"5726",
			    Array
				("carid"=>'5726',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5726&car_tyre_aspect=5678",
				    Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5726&car_tyre_aspect=5678&car_tyre_rim=5699"
				    )
			    ),
				Array
				("carid"=>'5726',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5726&car_tyre_aspect=5680",
				    Array
					("profileid"=>"5680","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5726&car_tyre_aspect=5680&car_tyre_rim=5699"
				    )
			    )
		    ),*/
		      Array
		    (
			    "carid"=>'5727',"label"=>"145", "value"=>"5727",
				Array
				("carid"=>'5727',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5680",
				    Array
					("profileid"=>"5680","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5680&car_tyre_rim=5694"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5680&car_tyre_rim=5695"
				    )
			    ),
			    Array
				("carid"=>'5727',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5682",
				    Array
					("profileid"=>"5682","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5682&car_tyre_rim=5694"
				    ),
				    Array
					("profileid"=>"5682","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5727&car_tyre_aspect=5682&car_tyre_rim=5695"
				    )
			    )
		    ),
		      Array
		    (
			    "carid"=>'5729',"label"=>"155", "value"=>"5729",
				Array
				("carid"=>'5729',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5679",
				    Array
					("profileid"=>"5679","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5679&car_tyre_rim=5694"
				    ),
				    Array
					("profileid"=>"5679","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5679&car_tyre_rim=5695"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5679&car_tyre_rim=5696"
				    )
			    ),
			    Array
				("carid"=>'5729',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5680",
				    Array
					("profileid"=>"5680","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5680&car_tyre_rim=5694"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5680&car_tyre_rim=5695"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5680&car_tyre_rim=5696"
				    )
			    ),
			    Array
				("carid"=>'5729',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5682",
				    Array
					("profileid"=>"5682","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5729&car_tyre_aspect=5682&car_tyre_rim=5695"
				    )
			    )
		    ),
	    
         Array
		    (
			    "carid"=>'5730',"label"=>"165", "value"=>"5730",
				Array
				("carid"=>'5730',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5678",
				    Array
					("profileid"=>"5678","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5678&car_tyre_rim=5694"
				    ),    
			    ),
			    Array
				("carid"=>'5730',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5679",
				    
				    Array
					("profileid"=>"5679","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5679&car_tyre_rim=5695"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5679&car_tyre_rim=5696"
				    ) 
				     
			    ),
			    Array
				("carid"=>'5730',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5680",
				    
				     Array
					("profileid"=>"5680","rimid"=>"5694","label"=>"12", "value"=>"5694",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5680&car_tyre_rim=5694"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5680&car_tyre_rim=5696"
				    )
				     
			    ),
			    Array
			    ("carid"=>'5730',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5682",
				    
				   
				     Array
					("profileid"=>"5682","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5682&car_tyre_rim=5696"
				    ),
				    Array
					("profileid"=>"5682","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5730&car_tyre_aspect=5682&car_tyre_rim=5697"
				    )
			    )
			
		),
        Array
		    (
			    "carid"=>'5731',"label"=>"175", "value"=>"5731",
				Array
				("carid"=>'5731',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5678",
				    
				    Array
					("profileid"=>"5678","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5678&car_tyre_rim=5695"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5678&car_tyre_rim=5697"
				    )
			    ),
			     Array  
				    ("carid"=>'5731',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5731&car_tyre_aspect=5679",
				    
				   
				     Array
					("profileid"=>"5679","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5679&car_tyre_rim=5696"
				    ),
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5679&car_tyre_rim=5697"
				    )
				),
				      Array

				  ("carid"=>'5731',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5680",
				    
				     Array
					("profileid"=>"5680","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5680&car_tyre_rim=5695"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5680&car_tyre_rim=5696"
				    )
				     
			    ),
				   Array
			    ("carid"=>'5731',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5682",
				    
				    Array
					("profileid"=>"5682","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5731&car_tyre_aspect=5682&car_tyre_rim=5695"
				    ),
				   
			    )
            ),
				     
			    
          Array
		    (
			    "carid"=>'5732',"label"=>"185", "value"=>"5732",
				Array
				("carid"=>'5732',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5677",
				    
				    Array
					("profileid"=>"5677","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5677&car_tyre_rim=5696"
				    ),
				      Array
					("profileid"=>"5677","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5677&car_tyre_rim=5698"
				    )
				),
				Array
				("carid"=>'5732',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5678",
				    
				    Array
					("profileid"=>"5678","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5678&car_tyre_rim=5695"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5678&car_tyre_rim=5696"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5678&car_tyre_rim=5697"
					),
				    Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5678&car_tyre_rim=5698"
				    )
			    ),
			    Array  
				    ("carid"=>'5732',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5732&car_tyre_aspect=5679",
				    
				   
				     Array
					("profileid"=>"5679","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5679&car_tyre_rim=5696"
				    ),
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5679&car_tyre_rim=5697"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5679&car_tyre_rim=5698"
				    )
				),

				      Array

				  ("carid"=>'5732',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5680",
				    
				     Array
					("profileid"=>"5680","rimid"=>"5695","label"=>"13", "value"=>"5695",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5680&car_tyre_rim=5695"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5680&car_tyre_rim=5696"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5680&car_tyre_rim=5699"
				    )
				     
			    ),
				   Array

				  ("carid"=>'5732',"profileid"=>"5683","label"=>"85", "value"=>"5683",
				"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5683",
				    
				     Array
					("profileid"=>"5683","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5732&car_tyre_aspect=5683&car_tyre_rim=5698"
				    )
			    )
			),

          Array
		    (
			    "carid"=>'5733',"label"=>"195", "value"=>"5733",


				Array
				("carid"=>'5733',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5676",
				    
				    Array
					("profileid"=>"5676","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5676&car_tyre_rim=5697"
					),
					Array
					("profileid"=>"5676","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5676&car_tyre_rim=5699"
				    )
				),
				 Array
				("carid"=>'5733',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5677",
				    
				    Array
					("profileid"=>"5677","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5677&car_tyre_rim=5697"
				    ),
				      Array
					("profileid"=>"5677","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5677&car_tyre_rim=5698"
				    )
				),
				    Array
				("carid"=>'5733',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5678",
				    
				   
				      Array
					("profileid"=>"5678","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5678&car_tyre_rim=5696"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5678&car_tyre_rim=5697"
				    ),
				       Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5678&car_tyre_rim=5698"
				    )
			    ),


			     Array  
				    ("carid"=>'5733',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5733&car_tyre_aspect=5679",
				    
				   
				     Array
					("profileid"=>"5679","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5679&car_tyre_rim=5696"
				    ),
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5679&car_tyre_rim=5697"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5679&car_tyre_rim=5698"
				    )
				),
				       Array

				  ("carid"=>'5733',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5680",
				    
				     Array
					("profileid"=>"5680","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5680&car_tyre_rim=5696"
				    ),
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5680&car_tyre_rim=5697"
				    )
				     
			    ),
				  Array
				("carid"=>'5733',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5682",
				   
			    
			    Array
					("profileid"=>"5682","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5733&car_tyre_aspect=5682&car_tyre_rim=5697"
				    )
		    )



				),
		    Array
		    (
			    "carid"=>'5734',"label"=>"205", "value"=>"5734",


				Array
				("carid"=>'5734',"profileid"=>"5674","label"=>"40", "value"=>"5674",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5676",
				    
				   
				    Array
					("profileid"=>"5674","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5674&car_tyre_rim=5699"
				    )
				),
				Array
				("carid"=>'5734',"profileid"=>"5675","label"=>"45", "value"=>"5676",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5675",
				    
				   
				    Array
					("profileid"=>"5675","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5675&car_tyre_rim=5699"
				    )
				),
				Array
				("carid"=>'5734',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5676",
				    
				    Array
					("profileid"=>"5676","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5676&car_tyre_rim=5697"
				    ),
				      Array
					("profileid"=>"5676","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5676&car_tyre_rim=5698"
				    ),
				     Array
					("profileid"=>"5676","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5676&car_tyre_rim=5699"
				    )

				),
				 Array
				("carid"=>'5734',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5677",
				    
				    Array
					("profileid"=>"5677","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5677&car_tyre_rim=5697"
				    ),
				      Array
					("profileid"=>"5677","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5677&car_tyre_rim=5698"
				    ),
				       Array
					("profileid"=>"5677","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5677&car_tyre_rim=5699"
				    )
				),
				    Array
				("carid"=>'5734',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5678",
				    
				  
				   Array
					("profileid"=>"5678","rimid"=>" 5695","label"=>"13", "value"=>" 5695",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5678&car_tyre_rim=5695"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5678&car_tyre_rim=5696"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5678&car_tyre_rim=5697"
				    ),
				       Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5678&car_tyre_rim=5698"
				    )
			    ),


			     Array  
				    ("carid"=>'5734',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5734&car_tyre_aspect=5679",
				    
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5679&car_tyre_rim=5697"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5679&car_tyre_rim=5698"
				    )
				),
				       Array

				  ("carid"=>'5734',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5680",
				    
				  
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5680&car_tyre_rim=5697"
				    )
				     
			    ),
				  Array
				("carid"=>'5733',"profileid"=>"5682","label"=>"80", "value"=>"5682",
				"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5682",
				   
			    
			    Array
					("profileid"=>"5682","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5734&car_tyre_aspect=5682&car_tyre_rim=5698"
				    )
		    )

         ),

              Array
		    (
			    "carid"=>'5735',"label"=>"215", "value"=>"5735",
				Array
				("carid"=>'5735',"profileid"=>"5674","label"=>"40", "value"=>"5735",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5676",
				    
				   
				    Array
					("profileid"=>"5674","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5674&car_tyre_rim=5699"
				    ),
				    Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5674&car_tyre_rim=5700"
				    )
				),
				Array
				("carid"=>'5734',"profileid"=>"5675","label"=>"45", "value"=>"5676",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5675",
				    
				   
				    Array
					("profileid"=>"5675","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5675&car_tyre_rim=5699"
				    )
				),
				Array
				("carid"=>'5734',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5676",
				    
				   
				    Array
					("profileid"=>"5676","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5676&car_tyre_rim=5699"
				    )
				),
				 Array
				("carid"=>'5735',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5677",
				    
				    Array
					("profileid"=>"5677","rimid"=>"5696","label"=>"14", "value"=>"5696",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5677&car_tyre_rim=5696"
				    ),
				      Array
					("profileid"=>"5677","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5677&car_tyre_rim=5698"
				    ),
				     Array
					("profileid"=>"5677","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5677&car_tyre_rim=5699"
				    ),
                    Array
					("profileid"=>"5677","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5677&car_tyre_rim=5700"
				    )
				),
				    Array
				("carid"=>'5735',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5678",
				       Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5678&car_tyre_rim=5698"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5678&car_tyre_rim=5699"
				    )
				    ),
			     Array  
				    ("carid"=>'5735',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5735&car_tyre_aspect=5679",
				    
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5679&car_tyre_rim=5697"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5679&car_tyre_rim=5698"
				    ),
					Array
				   ("profileid"=>"5679","rimid"=>"5699","label"=>"17", "value"=>"5699",
				   "url"=>$url."car_tyre_width=5735&car_tyre_aspect=5679&car_tyre_rim=5699"
				   )
				),
				       Array

				  ("carid"=>'5735',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5680",
				    
				  
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5680&car_tyre_rim=5697"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5680&car_tyre_rim=5698"
				    )
				     
			    ),
				  Array
				("carid"=>'5735',"profileid"=>"5681","label"=>"75", "value"=>"5681",
				"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5681",
				   
			    
			    Array
					("profileid"=>"5681","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5681&car_tyre_rim=5697"
				    ),
				    Array
					("profileid"=>"5681","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5735&car_tyre_aspect=5681&car_tyre_rim=5698"
				    )
		    )

         ),
		      Array
		    (
			    "carid"=>'5736',"label"=>"225", "value"=>"5736",

                Array
				("carid"=>'5736',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5673",
				    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5673&car_tyre_rim=5701"
				    )
				),
				Array
				("carid"=>'5736',"profileid"=>"5674","label"=>"40", "value"=>"5736",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5674",
				    Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5674&car_tyre_rim=5700"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5674&car_tyre_rim=5701"
				    )
				),
				Array
				("carid"=>'5736',"profileid"=>"5675","label"=>"45", "value"=>"5676",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5675",
				    
				   
				    Array
					("profileid"=>"5675","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5675&car_tyre_rim=5699"
				    ),
				    Array
					("profileid"=>"5675","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5675&car_tyre_rim=5700"
				    )
				),
				Array
				("carid"=>'5736',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5676",
				    
				   
				      Array
					("profileid"=>"5676","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5676&car_tyre_rim=5698"
				    ),
				     Array
					("profileid"=>"5676","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5676&car_tyre_rim=5699"
				    ),
                     Array
					("profileid"=>"5676","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5676&car_tyre_rim=5700"
				    )

				),
				
				 Array
				("carid"=>'5736',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5677",
				    
					Array
					("profileid"=>"5677","rimid"=>"5697","label"=>"15", "value"=>"5698",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5677&car_tyre_rim=5697"
					),
				    Array
					("profileid"=>"5677","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5677&car_tyre_rim=5698"
				    ),
				     Array
					("profileid"=>"5677","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5677&car_tyre_rim=5699"
				    ),
				     Array
					("profileid"=>"5677","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5677&car_tyre_rim=5700"
				    )
				),
				    Array
				("carid"=>'5736',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5678",
				       Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5678&car_tyre_rim=5697"
				    ),
				    	Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5678&car_tyre_rim=5698"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5678&car_tyre_rim=5699"
				    )
				    ),
			     Array  
				    ("carid"=>'5736',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5736&car_tyre_aspect=5679",
				    
				    Array
					("profileid"=>"5679","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5679&car_tyre_rim=5699"
				    )
				),
				       Array

				  ("carid"=>'5736',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5680",
				    
				  
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5680&car_tyre_rim=5697"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5736&car_tyre_aspect=5680&car_tyre_rim=5698"
				    )
				     
			    )
         ),
		    Array
		    (
			    "carid"=>'5737',"label"=>"235", "value"=>"5737",
               Array
				("carid"=>'5737',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5673",
				    
				   
				    Array
					("profileid"=>"5673","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5673&car_tyre_rim=5701"
				    )
				),

				Array
				("carid"=>'5737',"profileid"=>"5674","label"=>"40", "value"=>"5674",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5676",
				    
				   
				    Array
					("profileid"=>"5674","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5674&car_tyre_rim=5699"
				    ),
				     Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5674&car_tyre_rim=5700"
				    )
				),
		/*		Array
				("carid"=>'5737',"profileid"=>"5675","label"=>"45", "value"=>"5675",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5676",

                    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5674&car_tyre_rim=5701"
				    )
				),*/

			    Array
				("carid"=>'5737',"profileid"=>"5676","label"=>"45", "value"=>"5675",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5675",
				    
				  Array
					("profileid"=>"5676","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5675&car_tyre_rim=5700"
				    ),
                 Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5675&car_tyre_rim=5701"
				    )

				),
				Array
				("carid"=>'5737',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5676",
				    
				  Array
					("profileid"=>"5676","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5676&car_tyre_rim=5700"
				    ),
                 Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5676&car_tyre_rim=5701"
				    )

				),
				 Array
				("carid"=>'5737',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5677",
				    Array
					("profileid"=>"5677","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5677&car_tyre_rim=5699"
				    ),
                    Array
					("profileid"=>"5677","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5677&car_tyre_rim=5700"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5677&car_tyre_rim=5701"
				    )
				),
				    Array
				("carid"=>'5737',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5678",
				       Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5678&car_tyre_rim=5698"
				    ),
				    Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5678&car_tyre_rim=5699"
				    ),
				     Array
					("profileid"=>"5678","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5678&car_tyre_rim=5700"
				    )

			    ),
			     Array  
				    ("carid"=>'5737',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5737&car_tyre_aspect=5679",
				    
				    Array
					("profileid"=>"5679","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5679&car_tyre_rim=5697"
				    ),
				    Array
					("profileid"=>"5679","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5679&car_tyre_rim=5699"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5679&car_tyre_rim=5701"
				    )
				     
				),
				       Array

				  ("carid"=>'5737',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5680",
				    
				  
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5680&car_tyre_rim=5697"
				    ),
				      Array
					("profileid"=>"5680","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5680&car_tyre_rim=5698"
				    ),
				     
			    ),
				   Array
				("carid"=>'5737',"profileid"=>"5681","label"=>"75", "value"=>"5681",
				"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5681",
				   
			    
			    Array
					("profileid"=>"5681","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5737&car_tyre_aspect=5681&car_tyre_rim=5697"
				    )
				  
		    )

         ),
           Array
		    (
			    "carid"=>'5738',"label"=>"245", "value"=>"5738",

                 Array
				("carid"=>'5738',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5673",
				   
			    
			    Array
					("profileid"=>"5673","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5673&car_tyre_rim=5702"
				    ),
                Array
					("profileid"=>"5673","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5673&car_tyre_rim=5703"
				    )
				  
		    ),
				Array
				("carid"=>'5738',"profileid"=>"5674","label"=>"40", "value"=>"5736",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5676",
					Array
					("profileid"=>"5674","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5674&car_tyre_rim=5699"
					),
					Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5674&car_tyre_rim=5700"
				    ),
				     Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5674&car_tyre_rim=5701"
				    ),
                     Array
                    ("profileid"=>"5674","rimid"=>"5702","label"=>"20", "value"=>"5702",
                    "url"=>$url."car_tyre_width=5738&car_tyre_aspect=5674&car_tyre_rim=5702"
                    ),
                    Array
					("profileid"=>"5674","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5674&car_tyre_rim=5703"
				    )
				),
				Array
				("carid"=>'5738',"profileid"=>"5675","label"=>"45", "value"=>"5676",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5675",
				    
				   
				    Array
					("profileid"=>"5675","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5675&car_tyre_rim=5699"
				    ),
				    Array
					("profileid"=>"5675","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5675&car_tyre_rim=5700"
				    ),
				     Array
					("profileid"=>"5675","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5675&car_tyre_rim=5701"
				    ),
                    Array
                    ("profileid"=>"5675","rimid"=>"5702","label"=>"20", "value"=>"5702",
                    "url"=>$url."car_tyre_width=5738&car_tyre_aspect=5675&car_tyre_rim=5702"
                    )
				),
				Array
				("carid"=>'5738',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5676",
				    
				   
                   Array
					("profileid"=>"5676","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5676&car_tyre_rim=5700"
				    ),
                   Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5676&car_tyre_rim=5701"
				    )
				),
				
				 
				       Array

				  ("carid"=>'5738',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5680",
				    Array
					("profileid"=>"5680","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5680&car_tyre_rim=5698"
				    )
				     
			    ),
				  Array
				("carid"=>'5738',"profileid"=>"5681","label"=>"75", "value"=>"5681",
				"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5681",
				   
			    
			    Array
					("profileid"=>"5681","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5738&car_tyre_aspect=5681&car_tyre_rim=5698"
				    )
				  
		    )


         ),
		      Array
		    (
			    "carid"=>'5739',"label"=>"255", "value"=>"5739",
                Array
				("carid"=>'5739',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5673",

                 Array
					("profileid"=>"5675","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5673&car_tyre_rim=5700"
				    ),
                 Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5673&car_tyre_rim=5701"
				    ),
                 Array
                    ("profileid"=>"5679","rimid"=>"5702","label"=>"20", "value"=>"5702",
                    "url"=>$url."car_tyre_width=5739&car_tyre_aspect=5673&car_tyre_rim=5702"
                    )
				),
                Array
				("carid"=>'5739',"profileid"=>"5674","label"=>"40", "value"=>"5674",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5674",

                 Array
					("profileid"=>"5675","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5674&car_tyre_rim=5700"
				    ),
                 Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5674&car_tyre_rim=5701"
				    )
				),
				Array
				("carid"=>'5739',"profileid"=>"5675","label"=>"45", "value"=>"5675",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5675",
				    
				   
				    Array
					("profileid"=>"5675","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5675&car_tyre_rim=5702"
				    ),
                 Array
					("profileid"=>"5675","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5675&car_tyre_rim=5700"
				    )
				),
				Array
				("carid"=>'5739',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5676",
				    
				   
                   Array
					("profileid"=>"5676","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5676&car_tyre_rim=5701"
				    ),
                   Array
					("profileid"=>"5676","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5676&car_tyre_rim=5702"
				    ),
                  Array
					("profileid"=>"5676","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5676&car_tyre_rim=5703"
				    )
				),
				
				 Array
				("carid"=>'5739',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5677",
				    
				    Array
					("profileid"=>"5677","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5677&car_tyre_rim=5700"
				    ),
				      Array
					("profileid"=>"5677","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5677&car_tyre_rim=5701"
				    ),
                     Array
                    ("profileid"=>"5677","rimid"=>"5702","label"=>"20", "value"=>"5702",
                    "url"=>$url."car_tyre_width=5739&car_tyre_aspect=5677&car_tyre_rim=5702"
                    )
				),
				    Array
				("carid"=>'5739',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5678",
				       Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5678&car_tyre_rim=5697"
				    ),
				      Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5678&car_tyre_rim=5699"
				    ),
                      Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5678&car_tyre_rim=5701"
				    )
				),
			     Array  
				    ("carid"=>'5739',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				    "url"=>$url."car_tyre_width=5739&car_tyre_aspect=5679",
				    
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5679&car_tyre_rim=5698"
				    ),
				      Array
					("profileid"=>"5679","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5679&car_tyre_rim=5699"
				    ),

				     Array
					("profileid"=>"5679","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5679&car_tyre_rim=5702"
				    )
				),
				       Array

				  ("carid"=>'5739',"profileid"=>"5680","label"=>"70", "value"=>"5680", 
				"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5680",
				    
				    Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5739&car_tyre_aspect=5680&car_tyre_rim=5697"
				    )
			    )
				  

         ),
          Array
		    (
			    "carid"=>'5740',"label"=>"265", "value"=>"5740",
                
			    	 Array
                                    ("carid"=>'5740',"profileid"=>"5673","label"=>"35", "value"=>"5673",
                                    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5673",


                                     Array
                                        ("profileid"=>"5679","rimid"=>"5702","label"=>"20", "value"=>"5702",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5702&car_tyre_rim=5702"
                                    )

                                ),

                Array
                                    ("carid"=>'5740',"profileid"=>"5674","label"=>"40", "value"=>"5674",
                                    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5674",


                                     Array
                                        ("profileid"=>"5679","rimid"=>"5703","label"=>"21", "value"=>"5703",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5674&car_tyre_rim=5703"
                                    )

                                ),
                Array
                                    ("carid"=>'5740',"profileid"=>"5675","label"=>"45", "value"=>"5675",
                                    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5674",


                                     Array
                                        ("profileid"=>"5679","rimid"=>"5702","label"=>"20", "value"=>"5702",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5675&car_tyre_rim=5702"
                                    )

                                ),
			      Array
                                    ("carid"=>'5740',"profileid"=>"5678","label"=>"60", "value"=>"5678",
                                    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5678",


                                     Array
                                        ("profileid"=>"5679","rimid"=>"5700","label"=>"18", "value"=>"5700",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5678&car_tyre_rim=5700"
                                    )

                                ),
                Array
                                    ("carid"=>'5740',"profileid"=>"5676","label"=>"50", "value"=>"5676",
                                    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5676",


                                     Array
                                        ("profileid"=>"5676","rimid"=>"5701","label"=>"19", "value"=>"5701",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5676&car_tyre_rim=5701"
                                    ),
                                     Array
                                        ("profileid"=>"5676","rimid"=>"5702","label"=>"20", "value"=>"5702",
                                        "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5676&car_tyre_rim=5702"
                                    )

                                ),
				
         Array  
				    ("carid"=>'5740',"profileid"=>"5679","label"=>"65", "value"=>"5740",
				    "url"=>$url."car_tyre_width=5740&car_tyre_aspect=5679",
				    
				   
				     Array
					("profileid"=>"5679","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5679&car_tyre_rim=5698"
				    ),
				     Array
					("profileid"=>"5679","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5679&car_tyre_rim=5699"
				    ),

				),
				       Array

				  ("carid"=>'5740',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5680",
				     Array
					("profileid"=>"5680","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5680&car_tyre_rim=5697"
				    ),
				     
				    Array
					("profileid"=>"5680","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5680&car_tyre_rim=5698"
				    ),
				    Array
					("profileid"=>"5680","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5740&car_tyre_aspect=5680&car_tyre_rim=5699"
				    ),
				     
			    )
				  
             ),
		      Array
		    (
			    "carid"=>'5741',"label"=>"275", "value"=>"5741",

                Array
				("carid"=>'5741',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5673",
				    
				   
				    Array
					("profileid"=>"5673","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5673&car_tyre_rim=5701"
				    ),
                   Array
					("profileid"=>"5673","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5673&car_tyre_rim=5702"
				    ),
                   Array
					("profileid"=>"5673","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5673&car_tyre_rim=5703"
				    ),
                  Array
					("profileid"=>"5673","rimid"=>"5704","label"=>"22", "value"=>"5704",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5673&car_tyre_rim=5704"
				    )
				),
				Array
				("carid"=>'5741',"profileid"=>"5674","label"=>"40", "value"=>"5741",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674",
				    
				    Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674&car_tyre_rim=5700"
				    ),

				    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674&car_tyre_rim=5701"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674&car_tyre_rim=5702"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674&car_tyre_rim=5703"
				    ),
                    Array
					("profileid"=>"5674","rimid"=>"5704","label"=>"22", "value"=>"5704",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5674&car_tyre_rim=5704"
				    )
				),
				Array
				("carid"=>'5741',"profileid"=>"5675","label"=>"45", "value"=>"5676",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5675",
				    Array
					("profileid"=>"5675","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5675&car_tyre_rim=5701"
				    ),
				   
				    Array
					("profileid"=>"5675","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5675&car_tyre_rim=5702"
				    ),
                    Array
					("profileid"=>"5675","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5675&car_tyre_rim=5703"
				    )
				),
                 Array
				("carid"=>'5741',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5676",

				  Array
					("profileid"=>"5676","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5676&car_tyre_rim=5701"
				    ),
				    
				    Array
					("profileid"=>"5676","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5676&car_tyre_rim=5702"
				    )
				),
				
				 Array
				("carid"=>'5741',"profileid"=>"5677","label"=>"55", "value"=>"5677",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5677",
				    
				    
					Array
					("profileid"=>"5677","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5677&car_tyre_rim=5699"
				    ),

				    Array
					("profileid"=>"5677","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5677&car_tyre_rim=5701"
				    )
				),
				    Array
				("carid"=>'5741',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5678",
				       Array
					("profileid"=>"5678","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5678&car_tyre_rim=5697"
				    ),
                     Array
					("profileid"=>"5678","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5678&car_tyre_rim=5700"
				    )
			     
         ),
                 Array
				("carid"=>'5741',"profileid"=>"5679","label"=>"65", "value"=>"5679",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5679",
				       Array
					("profileid"=>"5678","rimid"=>"5699","label"=>"17", "value"=>"5699",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5679&car_tyre_rim=5699"
				    )
			     
         ),
                 Array
				("carid"=>'5741',"profileid"=>"5680","label"=>"70", "value"=>"5680",
				"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5680",
				       Array
					("profileid"=>"5678","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5741&car_tyre_aspect=5680&car_tyre_rim=5698"
				    )
			     
         )
         ),
		     Array
		    (
			    "carid"=>'5742',"label"=>"285", "value"=>"5742",
                Array
				("carid"=>'5742',"profileid"=>"5672","label"=>"30", "value"=>"5672",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5672",
				    
				    
				    Array
					("profileid"=>"5672","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5672&car_tyre_rim=5701"
				    ),
                    Array
                    ("profileid"=>"5672","rimid"=>"5702","label"=>"20", "value"=>"5702",
                    "url"=>$url."car_tyre_width=5742&car_tyre_aspect=5672&car_tyre_rim=5702"
                    )
				),
                Array
				("carid"=>'5742',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5673",
				    
				    
				    Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5673&car_tyre_rim=5700"
				    )
				),
                Array
				("carid"=>'5742',"profileid"=>"5674","label"=>"40", "value"=>"5674",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5674",
				    
				    
				    Array
					("profileid"=>"5674","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5674&car_tyre_rim=5702"
				    ),
                   Array
					("profileid"=>"5674","rimid"=>"5704","label"=>"22", "value"=>"5704",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5674&car_tyre_rim=5704"
				    )
				),
                Array
				("carid"=>'5742',"profileid"=>"5675","label"=>"45", "value"=>"5675",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5675",
				    
				    
				    Array
					("profileid"=>"5675","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5675&car_tyre_rim=5701"
				    ),
                   Array
					("profileid"=>"5675","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5675&car_tyre_rim=5703"
				    )
				),
				 Array
				("carid"=>'5742',"profileid"=>"5676","label"=>"50", "value"=>"5676",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5676",
				    
				    
				    Array
					("profileid"=>"5675","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5676&car_tyre_rim=5702"
				    )
                
				),

                Array
				("carid"=>'5742',"profileid"=>"5678","label"=>"60", "value"=>"5678",
				"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5678",
				    
				    
				    Array
					("profileid"=>"5674","rimid"=>"5700","label"=>"18", "value"=>"5700",
					"url"=>$url."car_tyre_width=5742&car_tyre_aspect=5678&car_tyre_rim=5700"
				    )
				),

		),
		    Array
		    (
			    "carid"=>'5743',"label"=>"295", "value"=>"5743",
                Array
				("carid"=>'5743',"profileid"=>"5672","label"=>"30", "value"=>"5672",
				"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5672",
				    
				    
				    Array
					("profileid"=>"5674","rimid"=>"5701","label"=>"19", "value"=>"5701",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5672&car_tyre_rim=5701"
				    ),
				     Array
					("profileid"=>"5674","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5672&car_tyre_rim=5702"
				    )
				),
                Array
				("carid"=>'5742',"profileid"=>"5673","label"=>"35", "value"=>"5673",
				"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5673",
				    
				    
				    Array
					("profileid"=>"5673","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5673&car_tyre_rim=5702"
				    ),
                    Array
					("profileid"=>"5673","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5673&car_tyre_rim=5703"
				    )
                    
				),
                Array
                    ("carid"=>'5740',"profileid"=>"5674","label"=>"40", "value"=>"5674",
                    "url"=>$url."car_tyre_width=5743&car_tyre_aspect=5674",


                     Array
                        ("profileid"=>"5674","rimid"=>"5702","label"=>"20", "value"=>"5702",
                        "url"=>$url."car_tyre_width=5743&car_tyre_aspect=5674&car_tyre_rim=5702"
                    ),
                     Array
					("profileid"=>"5674","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5674&car_tyre_rim=5703"
				    ),
                     Array
					("profileid"=>"5674","rimid"=>"5704","label"=>"22", "value"=>"5704",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5674&car_tyre_rim=5704"
				    )

                ),
			     Array
				("carid"=>'5743',"profileid"=>"5676","label"=>"50", "value"=>"5741",
				"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5676",
				    
				    
				    Array
					("profileid"=>"5676","rimid"=>"5697","label"=>"15", "value"=>"5697",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5676&car_tyre_rim=5697"
				    ),
				    Array
					("profileid"=>"5676","rimid"=>"5698","label"=>"16", "value"=>"5698",
					"url"=>$url."car_tyre_width=5743&car_tyre_aspect=5676&car_tyre_rim=5698"
				    )
				)
			),
			Array
		    (
			    "carid"=>'5744',"label"=>"305", "value"=>"5744",
			        Array
				(
					"carid"=>'5744',"profileid"=>"5672","label"=>"30", "value"=>"5740",
					"url"=>$url."car_tyre_width=5744&car_tyre_aspect=5672",
				    Array
					("profileid"=>"5672","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5744&car_tyre_aspect=5672&car_tyre_rim=5702"
				    )
				),
			     Array
				(
					"carid"=>'5744',"profileid"=>"5673","label"=>"35", "value"=>"5741",
					"url"=>$url."car_tyre_width=5744&car_tyre_aspect=5673",
				    Array
					("profileid"=>"5673","rimid"=>"5702","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5744&car_tyre_aspect=5673&car_tyre_rim=5702"
				    )
				)
			),
			Array
		    (
			    "carid"=>'5746',"label"=>"315", "value"=>"5746",
			     Array
				(
					"carid"=>'5746',"profileid"=>"5673","label"=>"35", "value"=>"5673",
					"url"=>$url."car_tyre_width=5746&car_tyre_aspect=5673",
				    Array
					("profileid"=>"5674","rimid"=>"5703","label"=>"20", "value"=>"5702",
					"url"=>$url."car_tyre_width=5746&car_tyre_aspect=5673&car_tyre_rim=5702"
				    )
				),
				   Array
				(
					"carid"=>'5746',"profileid"=>"5674","label"=>"40", "value"=>"5674",
					"url"=>$url."car_tyre_width=5746&car_tyre_aspect=5674",
				    Array
					("profileid"=>"5674","rimid"=>"5703","label"=>"21", "value"=>"5703",
					"url"=>$url."car_tyre_width=5746&car_tyre_aspect=5674&car_tyre_rim=5703"
				    )
				)
			),
		);

			
		//echo "<pre>";
		//print_r($data);
		echo(json_encode($data));
	    /*print_r(json_encode($data));
		die();*/
	}

	
}
