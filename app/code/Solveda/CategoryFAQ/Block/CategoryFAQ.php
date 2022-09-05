<?php

namespace Solveda\CategoryFAQ\Block;

use Exception;
use Magento\Framework\View\Element\Template;
use Magento\Cms\Model\Template\FilterProvider;
use Solveda\CategoryFAQ\Model\CategoryFAQFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Solveda\CategoryFAQ\Helper\CategoryFAQData as CategoryFAQHelper;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class CategoryFAQ
 * @package Solveda\CategoryFAQ\Block
 */
class CategoryFAQ extends Template
{
    /**
     * @type CategoryFAQHelper
     */
    public $categoryFAQHelper;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var FilterProvider
     */
    public $filterProvider;

    /**
     * @var CategoryFAQFactory
     */
    public $categoryFAQFactory;

    /**
     * @var CollectionFactory
     */
    protected $collecionFactory;

    /**
     * @param \Magento\Framework\Registry $registry
     */

    protected $_registry;
    /**
     * @param Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;

    /**
     * @param \Magento\Catalog\Model\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

    private $categoryAttributes;

    private $manufacturerUrl;

    private $highestPriceProduct;

    private $lowestPriceProduct;

    /**
     * Slider constructor.
     *
     * @param Template\Context $context
     * @param CategoryFAQHelper $categoryFAQHelper
     * @param CustomerRepositoryInterface $customerRepository
     * @param FilterProvider $filterProvider
     * @param CategoryFAQFactory $categoryFAQFactory
     * @param CollectionFactory $collecionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        categoryFAQHelper $categoryFAQHelper,
        CustomerRepositoryInterface $customerRepository,
        FilterProvider $filterProvider,
        CategoryFAQFactory $categoryFAQFactory,
        CollectionFactory $collecionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Psr\Log\LoggerInterface $logger,
        array $data = []
    ) {
        $this->categoryFAQHelper = $categoryFAQHelper;
        $this->customerRepository = $customerRepository;
        $this->store = $context->getStoreManager();
        $this->filterProvider = $filterProvider;
        $this->categoryFAQFactory = $categoryFAQFactory;
        $this->collecionFactory = $collecionFactory;
        $this->_registry = $registry;
        $this->priceHelper = $priceHelper;
        $this->categoryRepository = $categoryRepository;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * Get current categroy
     * @return object
     */
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * Get parent categroy
     * @return array
     */
    public function getParentCategory($categoryId)
    {
        $collection = $this->collecionFactory
            ->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', ['eq' => $categoryId])
            ->setPageSize(1);

        return $collection->getFirstItem()->getData();
    }

    /**
     * Filter question
     * @return string
     */
    public function filterQuestion($string)
    {
        $carTyreCategoryId = 46;
        $bikeTyreCategoryId = 42;
		$batCategoryId = 3405;
        $alloyCategoryId = 4766;
        $category = $this->getCurrentCategory();
        $path =  $category->getPath();
        $catIds = explode('/', $path);
        array_pop($catIds);

        if (in_array($carTyreCategoryId, $catIds)) {
            $string = str_replace('{type}', 'Tyres', $string);
        }
        if (in_array($bikeTyreCategoryId, $catIds)) {
            $string = str_replace('{type}', 'bike tyre', $string);
        }
		 if (in_array($batCategoryId, $catIds)) {
            $string = str_replace('{type}',  'battery', $string);
        }
         if (in_array($alloyCategoryId, $catIds)) {
            $string = str_replace('{type}',  'alloy wheel', $string);
        }

        $categoryLevel = $category->getLevel();
        $categoryName = $category->getName();

          if ($categoryLevel == 3) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            // replace brand
            //$string = str_replace('{brand}', $parentCategory['name'], $string);
            // replace model
            $string = str_replace('{model}', $categoryName, $string);
        }

        if ($categoryLevel == 4) {
            // replace brand
            $string = str_replace('{brand}', $categoryName, $string);
        }

        if ($categoryLevel == 5 ) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            // replace brand
            $string = str_replace('{brand}', $parentCategory['name'], $string);
            // replace model
            $string = str_replace('{model}', $categoryName, $string);
        }

     /*   if ($categoryLevel == 3) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            // replace brand
            $string = str_replace('{brand}', $parentCategory['name'], $string);
            // replace model
            $string = str_replace('{model}', $categoryName, $string);
        }*/

        if ($categoryLevel == 6) {
            $parentCategory = $this->getParentCategory($category->getData('parent_id'));
            // replace brand
            $string = str_replace('{model}', $parentCategory['name'], $string);

            $parentCategory = $this->getParentCategory($parentCategory['parent_id']);
            // replace model
            $string = str_replace('{brand}', $parentCategory['name'], $string);
            // replace submodel
            $string = str_replace('{submodel}', $categoryName, $string);
        }
        $pattern = '/{(\w+)}/i';
        return preg_replace($pattern, '', $string);
    }

    public function getCategoryAttributes()
    {
        if (!$this->categoryAttributes) {

            $catId = $this->getCurrentCategory()->getId();

            $category = $this->collecionFactory
                ->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', ['eq' => $catId])
                ->getFirstItem();

            $attributes = $category->getData();
            $this->categoryAttributes = $attributes;
        }
        return $this->categoryAttributes;
    }

    /**
     * Filter answer
     * @return string
     */
    public function filterAnswer($string)
    {
        $attributes = $this->getCategoryAttributes();
        foreach ($attributes as $key => $val) {
            if (substr($key, 0, 4) == 'faq_' && $val != '') {
                $string = str_replace('{' . $key . '}', $val, $string);
            }
        }
        /*
        $cheapestPrice = $this->getCheapestPriceProduct();
        $url = '<a href="{product_url}">{product_name}</a>';

        $productUrl = str_replace('{product_name}', $cheapestPrice['name'], $url);
        $productUrl = str_replace('{product_url}', $cheapestPrice['url'], $productUrl);

        $string = str_replace('{faq_cheapest_price}', $cheapestPrice['{faq_cheapest_price}'] . ' ' . $productUrl, $string);

        // replace highest price
        $highestPrice = $this->getHighestPriceProduct();

        $productUrl = str_replace('{product_name}', $highestPrice['name'], $url);
        $productUrl = str_replace('{product_url}', $highestPrice['url'], $productUrl);

        $string = str_replace('{faq_highest_price}', $highestPrice['{faq_highest_price}'] . ' ' . $productUrl, $string);

        $manufacturer = $this->getManufacturer();
        $string = str_replace('{faq_tyre_manufacturer}', $manufacturer, $string);
        */
        return $string;
    }

    /**
     * @return array|AbstractCollection
     */
    public function getCategoryFAQCollection()
    {
        $collection = $this->categoryFAQFactory->create()->getCollection();
        $collection->addFieldToFilter('status', ['eq' => 1]);
        $collection->addOrder('entity_id', 'ASC');
        return $collection;
    }

    public function getCheapestPriceProduct()
    {
        if (!$this->lowestPriceProduct) {
            $category = $this->getCurrentCategory();
            $product = $category->getProductCollection()
                ->addAttributeToSelect('*')
                ->setOrder('price', 'ASC')
                ->getFirstItem();

            $url = $product->getProductUrl();
            $name = $product->getName();
            $price = $this->priceHelper->currency($product->getFinalPrice());
            $data = [
                '{faq_cheapest_price}' => $price,
                'url' => $url,
                'name' => $name,
            ];
            $this->lowestPriceProduct = $data;
        }
        return $this->lowestPriceProduct;
    }

    public function getHighestPriceProduct()
    {
        if (!$this->highestPriceProduct) {
            $category = $this->getCurrentCategory();
            $product = $category->getProductCollection()
                ->addAttributeToSelect('*')
                ->setOrder('price', 'DESC')
                ->getFirstItem();

            $url = $product->getProductUrl();
            $name = $product->getName();
            $price = $this->priceHelper->currency($product->getFinalPrice());
            $data = [
                '{faq_highest_price}' => $price,
                'url' => $url,
                'name' => $name,
            ];
            $this->highestPriceProduct = $data;
        }
        return $this->highestPriceProduct;
    }

    public function getManufacturer()
    {
        if (!$this->manufacturerUrl) {
            $url = '';
            try {
                $currentCategory = $this->getCurrentCategory();
                $currentCategoryId = $currentCategory->getId();
                // tyre brand id -> 376
                $categoryId = 376;
                $collection  = $this->categoryRepository->get($categoryId);
                $brands = [];
                $childCategoryIds = explode(',', $collection->getChildren());
                foreach ($childCategoryIds as $catId) {

                    $products = $this->productCollectionFactory->create();
                    $products->addAttributeToSelect('*');
                    $products->addCategoriesFilter(['eq' => $currentCategoryId]);
                    $products->addCategoriesFilter(['eq' => $catId]);
                    if ($products->count()) {
                        $brands[] = $catId;
                    }
                }
                // $brands
                $collection = $this->collecionFactory
                    ->create()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['in' => $brands]);

                $list = [];
                $url = '';
                foreach ($collection as $cat) {
                    $list[] = [
                        'name' => $cat->getName(),
                        'url' => $cat->getUrl()
                    ];
                    $url .= '<a href="' . $cat->getUrl() . '">' . $cat->getName() . '<a> ';
                }
            } catch (Exception $e) {
                $this->logger->info('Error', [$e->getMessage()]);
            }
            $this->manufacturerUrl = $url;
        }
        return $this->manufacturerUrl;
    }

    public function isCarTyreCategory()
    {
        $carTyreCategoryId = 46;
         $bikeTyreCategoryId = 42;
		$batCategoryId = 3405;
        $alloyCategoryId = 4766;
        $category = $this->getCurrentCategory();
        $path =  $category->getPath();
        $catIds = explode('/', $path);
        array_pop($catIds);

        if (in_array($carTyreCategoryId, $catIds)) {
            return true;
        }
         if (in_array($bikeTyreCategoryId, $catIds)) {
            return true;
        }
		 if (in_array($batCategoryId, $catIds)) {
            return true;
        }

       if (in_array($alloyCategoryId, $catIds)) {
            return true;
        }
        return false;
    }
}