<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_CategoryMassUpload
 * @author    Webkul Software Private Limited
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\CategoryMassUpload\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportExport\Model\Export\Adapter\Csv as AdapterCsv;

class Export extends \Magento\Backend\App\Action
{
    /**
     * Redirect result factory
     *
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var AdapterCsv
     */
    protected $writer;

    /**
     * constructor
     *
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $prodcollection,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Webkul\CategoryMassUpload\Helper\Data $massUploadHelper,
        AdapterCsv $writer,
        \Magento\Backend\App\Action\Context $context
    ) {
    
        $this->resultForwardFactory = $resultForwardFactory;
        $this->storeManager = $storeManagerInterface;
        $this->categoryFactory = $categoryFactory;
        $this->productcollection = $prodcollection;
        $this->resultRawFactory = $resultRawFactory;
        $this->fileFactory  = $fileFactory;
        $this->writer = $writer;

        $this->massUploadHelper = $massUploadHelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $store_id = $this->getRequest()->getPost('store_id');
        $stores = $this->massUploadHelper->getAllStoresCodes();
        
        $fileName = 'categories.csv';
        $categoryRow = [];
        $categoryRow[0] = $this->prepareFileColumnRow();
        
        $collection = $this->categoryFactory->create()->getCollection()->addAttributeToSort('entity_id', 'asc');
        $categoryDataRow = [];
        foreach ($collection as $key => $cat) {
            $categoryitem = $this->categoryFactory->create();
            if ($cat->getId()>=2) {
                $categoryitem->setStoreId($store_id);
                $categoryitem->load($cat->getId());
                if ($categoryitem->getId()) {
                    $products = '';
                    $allProductId = $this->productcollection->addCategoryFilter($categoryitem)->getAllIds();
                    if (isset($allProductId) && !empty($allProductId)) {
                        $products = implode(',', $allProductId);
                    }
                    $wholeData['category_id'] = $categoryitem->getId();
                    $wholeData['parent_id'] = $categoryitem->getParentId();
                    $wholeData['store'] = $stores[$categoryitem->getStoreId()];
                    $wholeData['name'] = $categoryitem->getName();
                    $wholeData['path'] = $categoryitem->getPath();
                    $wholeData['image'] = $categoryitem->getImage();
                    $wholeData['is_active'] = $categoryitem->getIsActive();
                    $wholeData['is_anchor'] = $categoryitem->getIsAnchor();
                    $wholeData['include_in_menu'] = $categoryitem->getIncludeInMenu();
                    $wholeData['meta_title'] = $categoryitem->getMetaTitle();
                    $wholeData['meta_keywords'] = $categoryitem->getMetaKeyword();
                    $wholeData['meta_description'] = $categoryitem->getMetaDescription();
                    $wholeData['description'] = $categoryitem->getDescription();
                    $wholeData['url_key'] = $categoryitem->getUrlKey();
		    $wholeData['custom_layout_update'] = $categoryitem->getCustomLayoutUpdate();
                    $wholeData['products'] = $products;
                    $categoryDataRow[] = $wholeData;
                }
            }
        }
        $categoryRow[1] = $categoryDataRow;
        $this->downloadFile($fileName, $categoryRow);
    }

    public function downloadFile($fileName, $categoryRow)
    {
        if (count($categoryRow)) {
            $writer = $this->writer;
            $writer->setHeaderCols($categoryRow[0]);
            foreach ($categoryRow[1] as $dataRow) {
                if (!empty($dataRow)) {
                    $writer->writeRow($dataRow);
                }
            }
            $categoryRow = $writer->getContents();

            return $this->fileFactory->create(
                $fileName,
                $categoryRow,
                DirectoryList::VAR_DIR,
                'text/csv'
            );
        }
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw;
    }

    public function prepareFileColumnRow()
    {
        $wholeData[] = 'category_id';
        $wholeData[] = 'parent_id';
        $wholeData[] = 'store';
        $wholeData[] = 'name';
        $wholeData[] = 'path';
        $wholeData[] = 'image';
        $wholeData[] = 'is_active';
        $wholeData[] = 'is_anchor';
        $wholeData[] = 'include_in_menu';
        $wholeData[] = 'meta_title';
        $wholeData[] = 'meta_keywords';
        $wholeData[] = 'meta_description';
        $wholeData[] = 'description';
        $wholeData[] = 'url_key';
	$wholeData[] = 'custom_layout_update';
        $wholeData[] = 'products';
        return $wholeData;
    }
}
