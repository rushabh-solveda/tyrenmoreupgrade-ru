<?php

namespace Solveda\CategoryFAQ\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportExport\Model\Export\Adapter\Csv as AdapterCsv;
use Webkul\CategoryMassUpload\Controller\Adminhtml\Export\Export as MainExport;

class Export extends MainExport
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
            if ($cat->getId() >= 2) {
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
                    $wholeData['faq_tyre_size'] = $categoryitem->getFaqTyreSize();
                    $wholeData['faq_best_tyre'] = $categoryitem->getFaqBestTyre();
                    $wholeData['faq_air_pressure'] = $categoryitem->getFaqAirPressure();
                    $wholeData['faq_tyre_life'] = $categoryitem->getFaqTyreLife();
                    $wholeData['faq_tyre_fuel_savings'] = $categoryitem->getFaqTyreFuelSavings();
                    $wholeData['faq_tyre_grip'] = $categoryitem->getFaqTyreGrip();
                    $wholeData['faq_tyre_warranty'] = $categoryitem->getFaqTyreWarranty();
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
        $wholeData[] = 'faq_tyre_size';
        $wholeData[] = 'faq_best_tyre';
        $wholeData[] = 'faq_air_pressure';
        $wholeData[] = 'faq_tyre_life';
        $wholeData[] = 'faq_tyre_fuel_savings';
        $wholeData[] = 'faq_tyre_grip';
        $wholeData[] = 'faq_tyre_warranty';
        return $wholeData;
    }
}
