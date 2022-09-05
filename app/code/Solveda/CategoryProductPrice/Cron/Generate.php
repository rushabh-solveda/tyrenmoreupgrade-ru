<?php

namespace Solveda\CategoryProductPrice\Cron;

use DateTimeZone;
use Exception;
use Magento\Cron\Model\Config\Source\Frequency;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

use Psr\Log\LoggerInterface;

/**
 * Class Generate
 * @package Mageplaza\ProductFeed\Cron
 */
class Generate
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * @var DateTime
     */
    protected $dateTime;
    
    protected $productBlock;
    
    protected $categoryFactory;
    
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $collectionFactory;
    
     /**
     * @param Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;

    /**
     * Generate constructor.
     *
     * @param TimezoneInterface $timezone
     * @param LoggerInterface $logger
     * @param DateTime $dateTime
     */
    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        \Magento\Catalog\Block\Product\AbstractProduct $productBlock,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        TimezoneInterface $timezone,
        LoggerInterface $logger,
        DateTime $dateTime
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->productBlock = $productBlock;
        $this->priceHelper = $priceHelper;
        $this->collectionFactory = $collectionFactory;
        $this->logger            = $logger;
        $this->timezone          = $timezone;
        $this->dateTime          = $dateTime;
    }

    /**
     * Send Mail
     *
     * @return void
     */
    public function execute()
    {
        
        $collection = $this->categoryFactory->create()->getCollection()->addAttributeToSort('entity_id', 'asc');
        foreach ($collection as $cat) {
            if ($cat->getId() >= 2) {
                $categoryitem = $this->categoryFactory->create()->load($cat->getId());
                
                $categoryitem->setLowestPriceHtml($this->getLowestHtml($categoryitem));
                $categoryitem->setFaqHighestPrice($this->getLowestProduct($categoryitem));
                $categoryitem->setFaqCheapestPrice($this->getHighestProduct($categoryitem));
                $categoryitem->save();
            }
        }
    }
    
    public function getLowestProduct($categoryitem){
        $product = $categoryitem->getProductCollection()
            ->addAttributeToSelect('*')
            ->setOrder('price', 'ASC')
            ->getFirstItem();
        $url = $product->getProductUrl();
            $name = $product->getName();
            $price = $this->priceHelper->currency($product->getFinalPrice());
            $data = '<a href="'.$url.'">'.$name.'</a>';
            return $data;
    }
    
	public function getLowestProductPrice($categoryitem){
        $product = $categoryitem->getProductCollection()
            ->addAttributeToSelect('*')
            ->setOrder('price', 'ASC')
            ->getFirstItem();
        
		$price = $this->priceHelper->currency($product->getFinalPrice());
        return $price;
    }
	
	
    public function getHighestProduct($categoryitem){
        $product = $categoryitem->getProductCollection()
            ->addAttributeToSelect('*')
            ->setOrder('price', 'DESC')
            ->getFirstItem();
        $url = $product->getProductUrl();
            $name = $product->getName();
            $price = $this->priceHelper->currency($product->getFinalPrice());
            $data = '<a href="'.$url.'">'.$name.'</a>';
            return $data;
    }
    
	public function getHighestProductPrice($categoryitem){
        $product = $categoryitem->getProductCollection()
            ->addAttributeToSelect('*')
            ->setOrder('price', 'DESC')
            ->getFirstItem();
        $price = $this->priceHelper->currency($product->getFinalPrice());
        return $price;
    }
	
    public function getLowestHtml($categoryitem){
        $products = $categoryitem->getProductCollection()
            ->addAttributeToSelect('*')
            ->setOrder('price', 'ASC')
            ->setPageSize(6);
           
/* Price list */

 $html = '';
        
        $pricetophtml = '<div class="row"><div class="col-md-12"><p>The price of '.$this->getCategoryType($categoryitem).' available for your '.$this->getCategoryName($categoryitem).' ranges from '.$this->getLowestProductPrice($categoryitem).' to  '.$this->getHighestProductPrice($categoryitem).'. Get '.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' Changed At Home - CONVENIENCE at your DOORSTEP.</p></div></div>';


	$pricehtml = '<div class="custom-accordian col-md-12"><div class="inner-accordian"><div data-toggle="collapse" data-target="#product-price-table"><h2  style="margin: 5px 0px;">'.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' price list</h2></div><div id="product-price-table" class="collapse" style="margin-bottom: 5px;"><table  class="table table-responsive table-striped table-border"><thead><tr><th>List of '.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' </th><th style="text-align:right;">Price <small>(Updated on '.date("j-M-Y").')<small></th></tr></thead><tbody>';
        
		foreach ($products as $product) {
	            $pricehtml .= '<tr><td>'.$product->getName().'</td><td>';
	            $pricehtml .= $this->priceHelper->currency($product->getFinalPrice());
	            $pricehtml .='</td></tr>';
	        }
        
	$pricehtml .= '</tbody></table></div></div></div>';





/*  Tyre Size List  */

        $sizetophtml = '';
        $sizehtml = '';
       $sizearray  = array();
    

		$categoryLevel = $categoryitem->getLevel();		
		$path = $categoryitem->getPath();
        	if (($categoryLevel == 5  ||  $categoryLevel == 6) && ($categoryitem->hasChildren()) && (strpos($path, '/46/') !== false))  {
			$subcategoryitem = $categoryitem->getChildrenCategories();	
			$sizehtml .= '<div class="custom-accordian col-md-12"><div class="inner-accordian"><div data-toggle="collapse" data-target="#product-size-table"><h2  style="margin: 5px 0px;">'.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' size list</h2></div><div id="product-size-table" class="collapse" style="margin-bottom: 5px;"><table  class="table table-responsive table-striped table-border"><thead><tr><th>List of '.$this->getCategoryName($categoryitem).' Models  </th><th style="text-align:right;">Tyre Size</th></tr></thead><tbody>';
			
			if($categoryLevel == 5)
			{
				foreach ($subcategoryitem as $subcategory) {
		                      $subcatitem = $this->categoryFactory->create()->load($subcategory->getId());
					$sizehtml .= '<tr><td>'.$subcategory->getName().'</td><td align="right">';
					$sizehtml .= $subcatitem->getFaqTyreSize();
					$sizehtml .='</td></tr>';

					if(!in_array($subcatitem->getFaqTyreSize(), $sizearray)){
						array_push($sizearray,$subcatitem->getFaqTyreSize());
					}	
				}
			}else{
				array_push($sizearray, $categoryitem->getFaqTyreSize());
					
			}
			$sizehtml .= '</tbody></table></div></div></div>';

			$sizetophtml .= '<div class="row"><div class="col-md-12"> <h2>'.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' Size </h2></div></div>';

		   	if(count($sizearray)>0){
			 	$sizetophtml .= '<div class="row"><div class="col-md-12"><p>'.$this->getCategoryName($categoryitem).' '.$this->getCategoryType($categoryitem).' size is '.implode(",",$sizearray).'</p></div></div>';

			}	
		}
        
        $html = $pricetophtml.$sizetophtml.$pricehtml.$sizehtml;


	return $html;
    }
    
    
    public function getCategoryName($category)
    {
        $categoryLevel = $category->getLevel();

        $categoryName = $category->getName();

        if ($categoryLevel == 5) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            $categoryName = $parentCategory['name'] . ' ' . $categoryName;
        }

        if ($categoryLevel == 6) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            $name = $parentCategory['name'];

            $parentCategory = $this->getParentCategory($parentCategory['parent_id']);

            $name = $parentCategory['name'] . ' ' . $name;

            $categoryName = $name . ' ' . $categoryName;
        }
        return $categoryName;
    }

    public function getCategoryType($currentCategory)
    {
        $text = 'Tyres';
        $path = $currentCategory->getPath();
        if (strpos($path, '/3404/') !== false) {
            $text = 'battery';
        }

        elseif(strpos($path, '/4766/') !== false) {
             $text = 'alloy wheels';
        }
        return $text;
    }
    
    /**
     * Get parent categroy
     * @return array
     */
    public function getParentCategory($categoryId)
    {
        $collection = $this->collectionFactory
            ->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', ['eq' => $categoryId])
            ->setPageSize(1);

        return $collection->getFirstItem()->getData();
    }

}

