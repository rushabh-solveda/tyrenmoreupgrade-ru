<?php

namespace Solveda\CategoryFAQ\Helper;

use Exception;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;

use Solveda\CategoryFAQ\Model\CategoryFAQFactory;
use Solveda\CategoryFAQ\Model\ResourceModel\CategoryFAQ\Collection;

/**
 * Class Data
 * @package Solveda\CategoryFAQ\Helper
 */
class CategoryFAQData extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_MODULE_PATH = 'categoryfaq';


    /**
     * @var CategoryFAQFactory
     */
    public $categoryFAQFactory;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var HttpContext
     */
    protected $httpContext;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Data constructor.
     *
     * @param DateTime $date
     * @param Context $context
     * @param HttpContext $httpContext
     * @param CategoryFAQFactory $categoryFAQFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        DateTime $date,
        Context $context,
        HttpContext $httpContext,
        CategoryFAQFactory $categoryFAQFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->date = $date;
        $this->httpContext = $httpContext;
        $this->categoryFAQFactory = $categoryFAQFactory;
        $this->storeManager = $storeManager;
    }

    // /**
    //  * @param null $id
    //  *
    //  * @return Collection
    //  */
    // public function getCategoryFAQCollection($id = null)
    // {
    //     $collection = $this->categoryFAQFactory->create()->getCollection();
    //     $collection->addFieldToFilter('entity_id', ['eq' => $id]);
    //     $collection->addOrder('entity_id', 'ASC');

    //     return $collection;
    // }
}
