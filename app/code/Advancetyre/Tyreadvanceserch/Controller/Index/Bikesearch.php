<?php 
namespace Advancetyre\Tyreadvanceserch\Controller\Index;
ob_start();

class Bikesearch extends \Magento\Framework\App\Action\Action
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
         /*rim:Array ( [label] => [value] => ) Array ( [value] => 5647 [label] => 17 ) Array ( [value] => 5648 [label] => 18 ) Array ( [value] => 5649 [label] => 19 ) Array ( [value] => 5650 [label] => 12 ) Array ( [value] => 5651 [label] => 10 ) Array ( [value] => 5652 [label] => 15 ) Array ( [value] => 5653 [label] => 21 ) Array ( [value] => 5654 [label] => 16 ) Array ( [value] => 5655 [label] => 14 )*/
		/*profile:Array ( [label] => [value] => ) Array ( [value] => 5640 [label] => None ) Array ( [value] => 5641 [label] => 70 ) Array ( [value] => 5642 [label] => 80 ) Array ( [value] => 5643 [label] => 90 ) Array ( [value] => 5644 [label] => 100 ) Array ( [value] => 5645 [label] => 60 )*/
		/*Width=$data =Array ( [label] => [value] => ) Array ( [value] => 5657 [label] => 2.50 ) Array ( [value] => 5658 [label] => 2.75 ) Array ( [value] => 5659 [label] => 3.00 ) Array ( [value] => 5660 [label] => 3.25 ) Array ( [value] => 5661 [label] => 70 ) Array ( [value] => 5662 [label] => 80 ) Array ( [value] => 5663 [label] => 90 ) Array ( [value] => 5664 [label] => 100 ) Array ( [value] => 5665 [label] => 110 ) Array ( [value] => 5666 [label] => 120 ) Array ( [value] => 5667 [label] => 130 ) Array ( [value] => 5668 [label] => 140 ) Array ( [value] => 5669 [label] => 3.50 ) Array ( [value] => 5670 [label] => 150 ) Array ( [value] => 5671 [label] => 170 );*/
		$url="https://tyresnmore.com/catalogsearch/advanced/result/?";
		$data=
				Array
		  (

		    Array(
		      "bikeid" => '5657', "label" => "2.50", "value" => "5657",
		      Array("bikeid" => '5657', "profileid" => "128", "label" => "None", "value" => "128",
		        "url" => $url.
		        "bike_tyre_width=5657&bike_tyre_aspect=128",
		        Array("profileid" => "128", "rimid" => "5654", "label" => "16", "value" => "5654",
		          "url" => $url.
		          "bike_tyre_width=5657&bike_tyre_aspect=128&bike_tyre_rim=5654"
		        ))
		    ),

		    Array(
		      "bikeid" => '5658', "label" => "2.75", "value" => "5658",
		      Array("bikeid" => '5658', "profileid" => "128", "label" => "None", "value" => "128",
		        "url" => $url.
		        "bike_tyre_width=5658&bike_tyre_aspect=128",
		        Array("profileid" => "128", "rimid" => "5648", "label" => "18", "value" => "5648",
		          "url" => $url.
		          "bike_tyre_width=5658&bike_tyre_aspect=128&bike_tyre_rim=5648"
		        ),
		        Array("profileid" => "128", "rimid" => "5647", "label" => "17", "value" => "5647",
		          "url" => $url.
		          "bike_tyre_width=5658&bike_tyre_aspect=128&bike_tyre_rim=5647")
		      )
		    ),
		    Array(
		      "bikeid" => '5659', "label" => "3.00", "value" => "5659",
		      Array("bikeid" => '5659', "profileid" => "128", "label" => "None", "value" => "128",
		        "url" => $url.
		        "bike_tyre_width=5659&bike_tyre_aspect=128",
		        Array("profileid" => "128", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5659&bike_tyre_aspect=128&bike_tyre_rim=5651"),
		        Array("profileid" => "128", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5659&bike_tyre_aspect=128&bike_tyre_rim=5647"),
		        Array("profileid" => "128", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5659&bike_tyre_aspect=128&bike_tyre_rim=5648")
		      )
		    ),

		    Array(
		      "bikeid" => '5660', "label" => "3.25", "value" => "5660",
		      Array("bikeid" => '5660', "profileid" => "128", "label" => "None", "value" => "128",
		        "url" => $url.
		        "bike_tyre_width=5660&bike_tyre_aspect=128",
		        Array("profileid" => "128", "rimid" => "5649", "label" => "19", "value" => "5649", "url" => $url.
		          "bike_tyre_width=5660&bike_tyre_aspect=128&bike_tyre_rim=5649")
		      )
		    ),

		    Array(
		      "bikeid" => '5669', "label" => "3.50", "value" => "5669",
		      Array("bikeid" => '5669', "profileid" => "128", "label" => "None", "value" => "128",
		        "url" => $url.
		        "bike_tyre_width=5669&bike_tyre_aspect=128",
		        Array("profileid" => "128", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5669&bike_tyre_aspect=128&bike_tyre_rim=5651"),
		        Array("profileid" => "128", "rimid" => "5649", "label" => "19", "value" => "5649", "url" => $url.
		          "bike_tyre_width=5669&bike_tyre_aspect=128&bike_tyre_rim=5649")
		      )
		    ),
		    Array(
		      "bikeid" => '5661', "label" => "70", "value" => "5661",
		      Array("bikeid" => '5661', "profileid" => "5644", "label" => "100", "value" => "5644",
		        "url" => $url.
		        "bike_tyre_width=5661&bike_tyre_aspect=5644",
		        Array("profileid" => "5644", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5661&bike_tyre_aspect=5644&bike_tyre_rim=5647")
		      )
		    ),

		    Array(
		      "bikeid" => '5662', "label" => "80", "value" => "5662",
		      Array("bikeid" => '5662', "profileid" => "5644", "label" => "100", "value" => "5644",
		        "url" => $url.
		        "bike_tyre_width=5662&bike_tyre_aspect=5644",
		        Array("profileid" => "5644", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5662&bike_tyre_aspect=5644&bike_tyre_rim=5647"),
		        Array("profileid" => "5644", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5662&bike_tyre_aspect=5644&bike_tyre_rim=5648")
		      )
		    ),
		    Array(
		      "bikeid" => '5663', "label" => "90", "value" => "5663",
		      Array("bikeid" => '5663', "profileid" => "5643", "label" => "90", "value" => "5643",
		        "url" => $url.
		        "bike_tyre_width=5663&bike_tyre_aspect=5643",
		        Array("profileid" => "5643", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5651"),
		        Array("profileid" => "5643", "rimid" => "5650", "label" => "12", "value" => "5650", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5650"),
		        Array("profileid" => "5643", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5647"),
		        Array("profileid" => "5643", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5648"),
		        Array("profileid" => "5643", "rimid" => "5649", "label" => "19", "value" => "5649", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5649"),
		        Array("profileid" => "5643", "rimid" => "5653", "label" => "21", "value" => "5653", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5643&bike_tyre_rim=5653")
		      ),
		      Array("bikeid" => '5663', "profileid" => "5644", "label" => "100", "value" => "5644",
		        "url" => $url.
		        "bike_tyre_width=5663&bike_tyre_aspect=5644",
		        Array("profileid" => "5644", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5663&bike_tyre_aspect=5644&bike_tyre_rim=5651")
		      )
		    ),
		    Array(
		      "bikeid" => '5664', "label" => "100", "value" => "5664",
		      Array("bikeid" => '5664', "profileid" => "5642", "label" => "80", "value" => "5642",
		        "url" => $url.
		        "bike_tyre_width=5663&bike_tyre_aspect=5642",
		        Array("profileid" => "5643", "rimid" => "5650", "label" => "12", "value" => "5650", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5642&bike_tyre_rim=5650"),
		        Array("profileid" => "5643", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5642&bike_tyre_rim=5647"),
		        Array("profileid" => "5643", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5642&bike_tyre_rim=5648")

		      ),
		      Array("bikeid" => '5664', "profileid" => "5643", "label" => "90", "value" => "5643",
		        "url" => $url.
		        "bike_tyre_width=5664&bike_tyre_aspect=5643",
		        Array("profileid" => "5643", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5643&bike_tyre_rim=5651"),
		        Array("profileid" => "5643", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5643&bike_tyre_rim=5647"),

		        Array("profileid" => "5643", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5664&bike_tyre_aspect=5643&bike_tyre_rim=5648")
		      )
		    ),
		    Array(
		      "bikeid" => '5665', "label" => "110", "value" => "5665",
		      Array("bikeid" => '5665', "profileid" => "5641", "label" => "70", "value" => "5641",
		        "url" => $url.
		        "bike_tyre_width=5665&bike_tyre_aspect=5641",
		        Array("profileid" => "5641", "rimid" => "5804", "label" => "11", "value" => "5804", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5641&bike_tyre_rim=5804"),
		        Array("profileid" => "5641", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5641&bike_tyre_rim=5647")

		      ),
		      Array("bikeid" => '5665', "profileid" => "5642", "label" => "80", "value" => "5642",
		        "url" => $url.
		        "bike_tyre_width=5663&bike_tyre_aspect=5642",

		        Array("profileid" => "5642", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5642&bike_tyre_rim=5647"),
		        Array("profileid" => "5642", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5642&bike_tyre_rim=5648"),
		        Array("profileid" => "5642", "rimid" => "5649", "label" => "19", "value" => "5649", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5642&bike_tyre_rim=5649")

		      ),
		      Array("bikeid" => '5665', "profileid" => "5643", "label" => "90", "value" => "5642",
		        "url" => $url.
		        "bike_tyre_width=5665&bike_tyre_aspect=5643",

		        Array("profileid" => "5643", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5643&bike_tyre_rim=5648"),
		        Array("profileid" => "5643", "rimid" => "5649", "label" => "19", "value" => "5649", "url" => $url.
		          "bike_tyre_width=5665&bike_tyre_aspect=5643&bike_tyre_rim=5649")
		      )
		    ),
		    Array(
		      "bikeid" => '5666', "label" => "120", "value" => "5666",
		      Array("bikeid" => '5666', "profileid" => "5641", "label" => "70", "value" => "5641",
		        "url" => $url.
		        "bike_tyre_width=5666&bike_tyre_aspect=5641",
		        Array("profileid" => "5641", "rimid" => "5651", "label" => "10", "value" => "5651", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5641&bike_tyre_rim=5651"),
		        Array("profileid" => "5641", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5641&bike_tyre_rim=5647")

		      ),
		      Array("bikeid" => '5666', "profileid" => "5642", "label" => "80", "value" => "5642",
		        "url" => $url.
		        "bike_tyre_width=5666&bike_tyre_aspect=5642",

		        Array("profileid" => "5642", "rimid" => "5654", "label" => "16", "value" => "5654", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5642&bike_tyre_rim=5654"),
		        Array("profileid" => "5642", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5642&bike_tyre_rim=5647"),
		        Array("profileid" => "5642", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5642&bike_tyre_rim=5648")

		      ),
		      Array("bikeid" => '5665', "profileid" => "5643", "label" => "90", "value" => "5643",
		        "url" => $url.
		        "bike_tyre_width=5665&bike_tyre_aspect=5643",

		        Array("profileid" => "5644", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5666&bike_tyre_aspect=5643&bike_tyre_rim=5647"),

		      )
		    ),
		    Array(
		      "bikeid" => '5667', "label" => "130", "value" => "5667",
		      Array("bikeid" => '5667', "profileid" => "5641", "label" => "70", "value" => "5641",
		        "url" => $url.
		        "bike_tyre_width=5667&bike_tyre_aspect=5641",

		        Array("profileid" => "5641", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5667&bike_tyre_aspect=5641&bike_tyre_rim=5647"),
		        Array("profileid" => "5641", "rimid" => "5648", "label" => "18", "value" => "5648", "url" => $url.
		          "bike_tyre_width=5667&bike_tyre_aspect=5641&bike_tyre_rim=5648")

		      ),

		      Array("bikeid" => '5667', "profileid" => "5643", "label" => "90", "value" => "5643",
		        "url" => $url.
		        "bike_tyre_width=5667&bike_tyre_aspect=5643",

		        Array("profileid" => "5643", "rimid" => "5652", "label" => "15", "value" => "5652", "url" => $url.
		          "bike_tyre_width=5667&bike_tyre_aspect=5643&bike_tyre_rim=5652"),

		      )
		    ),
		    Array(
		      "bikeid" => '5668', "label" => "140", "value" => "5668",
		      Array("bikeid" => '5668', "profileid" => "5645", "label" => "60", "value" => "5645",
		        "url" => $url.
		        "bike_tyre_width=5668&bike_tyre_aspect=5645",

		        Array("profileid" => "5645", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5668&bike_tyre_aspect=5645&bike_tyre_rim=5647")

		      ),
		      Array("bikeid" => '5668', "profileid" => "5641", "label" => "70", "value" => "5641",
		        "url" => $url.
		        "bike_tyre_width=5668&bike_tyre_aspect=5641",

		        Array("profileid" => "5641", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5668&bike_tyre_aspect=5641&bike_tyre_rim=5647")

		      )

		    ),
		    Array(
		      "bikeid" => '5670', "label" => "150", "value" => "5670",
		      Array("bikeid" => '5670', "profileid" => "5645", "label" => "60", "value" => "5645",
		        "url" => $url.
		        "bike_tyre_width=5670&bike_tyre_aspect=5645",

		        Array("profileid" => "5645", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5670&bike_tyre_aspect=5645&bike_tyre_rim=5647")

		      ),

		       Array("bikeid" => '5670', "profileid" => "5641", "label" => "70", "value" => "5641",
		        "url" => $url.
		        "bike_tyre_width=5670&bike_tyre_aspect=5641",

		        Array("profileid" => "5645", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5670&bike_tyre_aspect=5641&bike_tyre_rim=5647")

		      ),


		    ),

               /**/

                  Array(
		      "bikeid" => '5820', "label" => "160", "value" => "5820",
		      Array("bikeid" => '5820', "profileid" => "5645", "label" => "60", "value" => "5645",
		        "url" => $url.
		        "bike_tyre_width=5820&bike_tyre_aspect=5645",

		        Array("profileid" => "5645", "rimid" => "5820", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5820&bike_tyre_aspect=5645&bike_tyre_rim=5647")

		      )
		    ),
                         Array(
		      "bikeid" => '5671', "label" => "170", "value" => "5671",
		      Array("bikeid" => '5671', "profileid" => "5645", "label" => "60", "value" => "5645",
		        "url" => $url.
		        "bike_tyre_width=5671&bike_tyre_aspect=5645",

		        Array("profileid" => "5645", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5671&bike_tyre_aspect=5645&bike_tyre_rim=5647")

		      )
		    ),

                               Array(
		      "bikeid" => '5821', "label" => "180", "value" => "5821",
		      Array("bikeid" => '5821', "profileid" => "5822", "label" => "55", "value" => "5822",
		        "url" => $url.
		        "bike_tyre_width=5837&bike_tyre_aspect=5822",

		        Array("profileid" => "5822", "rimid" => "5647", "label" => "17", "value" => "5647", "url" => $url.
		          "bike_tyre_width=5821&bike_tyre_aspect=5822&bike_tyre_rim=5647")

		      )
		    ),

            /**/      



		    Array(
		      "bikeid" => '5806', "label" => "190", "value" => "5806",
		      Array(
		        "bikeid" => '5806',
		        "profileid" => "5794",
		        "label" => "50",
		        "value" => "5794",
		        "url" => $url.
		        "bike_tyre_width=5806&bike_tyre_aspect=5794",

		        Array(
		          "profileid" => "5645",
		          "rimid" => "5647",
		          "label" => "17",
		          "value" => "5647",
		          "url" => $url.
		          "bike_tyre_width=5806&bike_tyre_aspect=5794&bike_tyre_rim=5647"
		        )
		      ),
		            Array(
		        "bikeid" => '5806',
		        "profileid" => "5822",
		        "label" => "55",
		        "value" => "5822",
		        "url" => $url.
		        "bike_tyre_width=5806&bike_tyre_aspect=5822",

		        Array(
		          "profileid" => "5645",
		          "rimid" => "5647",
		          "label" => "17",
		          "value" => "5647",
		          "url" => $url.
		          "bike_tyre_width=5806&bike_tyre_aspect=5822&bike_tyre_rim=5647"
		        )
		      ),
		    ),

		  );
		/*echo "<pre>";
		print_r($data);*/
		echo(json_encode($data));
		//print_r(json_encode($data));
		//die();
	}
}
