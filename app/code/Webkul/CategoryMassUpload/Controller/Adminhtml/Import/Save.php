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

namespace Webkul\CategoryMassUpload\Controller\Adminhtml\Import;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Xml\Parser;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Backend session
     *
     * @var \Magento\Backend\Model\Session
     */
    protected $session;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;
    /**
     * @var \Magento\Framework\Registry
     */

    protected $registry;
    /**
     *
     */
    protected $logger;
    /**
     *
     */
    protected $helper;

    /**
     * constructor
     *
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\File\Csv $csvReader,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Filesystem\Io\File $fileio,
        Parser $parser,
        \Webkul\CategoryMassUpload\Helper\Data $helper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->session = $context->getSession();
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->filesystem = $fileSystem;
        $this->moduleReader = $moduleReader;
        $this->csvReader = $csvReader;
        $this->storeManager = $storeManagerInterface;
        $this->categoryFactory = $categoryFactory;
        $this->registry = $registry;
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
        $this->helper = $helper;
        $this->parser = $parser;
        $this->fileio = $fileio;
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $nocategoryfound = true;
        $i = 0;
        $uplloadFileSize = ini_get("upload_max_filesize");
        $uplloadFileSizeVal = explode('M', $uplloadFileSize);
        $count = $this->getRequest()->getParam('count');
        $fileImageSize = $this->getRequest()->getParam('fileImageSize');
        $data = $this->helper->getSession()->getCSVData();
        $result['error'] = 0;
        $result['msg'] = '';
        if ($fileImageSize > $uplloadFileSizeVal[0]) {
            $result['error'] = 2;
            $this->session->setFileSize($fileImageSize);
        }
        if ($this->session->getFileSize($fileImageSize) > 0) {
            $fileImageSize = $this->session->setFileSize($fileImageSize);
            $result['error'] = 2;
        }
        $categoryImportData = [];
        $errorTag = [];
        try {
            if (isset($data[0]) && !empty($data[0]) && $result['error'] < 1) {
                $tags = $data[0];
                $categoriesKey = array_search('categories', $tags);
                $categoryidkey = array_search('category_id', $tags);
                $storedata = array_search('store', $tags);
                $storeKey = array_search('store_id', $tags);

                $store = [];
                $website = [];
                $singlestoremode = $this->storeManager->isSingleStoreMode();
                $websites = $this->storeManager->getWebsites();
                foreach ($websites as $websiteColl) {
                    array_push($website,$websiteColl->getStores());
                }
                $_stores = [];
                if (!$singlestoremode) {
                    foreach ($website as $stores) {
                        foreach ($stores as $key => $storeColl) {
                            $_stores[$storeColl->getCode()] = $storeColl->getId();
                            if ($storeColl->getCode() == $data[1][$storedata] || $storeColl->getId() == $data[1][$storeKey]) {
                                $store = $storeColl;
                            }
                        }
                    }
                }
                $storeId = $store->getStoreId();
                $rootCategoryId = $store->getRootCategoryId();
                $rootCategory = $this->categoryFactory->create();
                $catInfo = $rootCategory->load($rootCategoryId);

                $alreadyexist = [];
                $categoryCollection = $this->categoryFactory->create()->getCollection()->addAttributeToSelect('name');

                $categoriesNamePresent = [];
                $categoriesPathPresent = [];
                $categoriesPathnamePresent = [];
                foreach ($categoryCollection as $key => $value) {
                    $categoriesNamePresent[$value->getId()] = $value->getName();
                    $categoriesPathPresent[$value->getId()] = $value->getPath();
                    $checkCat = $this->categoryFactory->create();
                    $categoryObj = $checkCat->load($value->getId());
                    $parentCatNames = [];
                    $parentId = '';
                    foreach ($this->getparentCategories($categoryObj) as $key => $parentCate) {
                        $parentCatNames[] = $parentCate->getName();
                        $parentId = $parentCate->getId();
                    }
                    $parentCategories = implode('/', $parentCatNames);
                    if ($parentCategories && $parentId) {
                        $categoriesPathnamePresent[$parentId] = $parentCategories;
                    }
                }

                foreach ($data as $key => $categoryItem) {
                    if ($key != 0 && $key == $count) {
                        if ($storeKey) {
                            if ($data[$key][$storeKey] != $data[1][$storeKey]) {
                                $nocategoryfound = false;
                                $result['error'] = 1;
                                break;
                            }
                        } elseif ($storedata) {
                            if ($data[$key][$storedata] != $data[1][$storedata]) {
                                $nocategoryfound = false;
                                $result['error'] = 1;
                                break;
                            }
                        }
                        $cat_data = $this->getKeyValue($categoryItem, $tags);
                        if (isset($cat_data['category_id'])) {
                            unset($cat_data['category_id']);
                        }
                        if (isset($categoriesKey) && ($categoriesKey != '' || $categoriesKey === 0) && $storeKey != '') {
                            $arrayKey = array_search($categoryItem[$categoriesKey], $categoriesPathnamePresent);
                            if ($arrayKey) {
                                $alreadyexist[] = $categoryItem[$categoriesKey];
                            } else {
                                $strmark = strrpos($categoryItem[$categoriesKey], '/');
                                $_parentid = '';
                                $newcategory = '';
                                if ($strmark != false) {
                                    $parentpath = substr($categoryItem[$categoriesKey], 0, ($strmark));
                                    $newcategory = substr($categoryItem[$categoriesKey], ($strmark) + 1);
                                    $_parentid = array_search($parentpath, $categoriesPathnamePresent);
                                } else {
                                    $newcategory = $categoryItem[$categoriesKey];
                                    $_parentid = $catInfo->getId();
                                }
                                if ($_parentid != '' && $newcategory != '') {
                                    $cateitem = $this->categoryFactory->create();
                                    $cateitem->setData($cat_data);
                                    $parentcategory = $this->categoryFactory->create();
                                    $parentcategory->load($_parentid);
                                    if ($parentcategory->getId()) {
                                        $cateitem->setParentId($_parentid);
                                        $cateitem->setPath($parentcategory->getPath());
                                    }
                                    $cateitem->setAttributeSetId($cateitem->getDefaultAttributeSetId());
                                    $cateitem->setName($newcategory);
                                    $_url_key = str_replace(' ', '-', strtolower($newcategory));
                                    if (in_array($newcategory, $categoriesNamePresent)) {
                                        $_url_key .= '-' . mt_rand(10, 99);
                                    }

                                    $cateitem->setUrlKey($_url_key);
                                    $cateitem->setStoreId($cat_data['store_id']);

                                    $cateitem->save();

                                    if ($cateitem->getId()) {
                                        $categoriesNamePresent[$cateitem->getId()] = $cateitem->getName();
                                        $categoriesPathPresent[$cateitem->getId()] = $cateitem->getPath();
                                        $categoriesPathnamePresent[$cateitem->getId()] = $categoryItem[$categoriesKey];
                                    }
                                }
                            }
                        } elseif (isset($categoryidkey) && ($categoryidkey != '' || $categoryidkey === 0) && $storedata != '') {
                            $catemodel = $this->categoryFactory->create();
                            $getAllCategoryData = $catemodel->getCollection()->getData();

                            if (!$singlestoremode && isset($_stores[$categoryItem[$storedata]])) {
                                $catemodel->setStoreId($_stores[$categoryItem[$storedata]]);
                            } else {
                                $catemodel->setStoreId($storeId);
                            }
                            $cateitem = $catemodel->load($categoryItem[$categoryidkey]);

                            if ($cateitem->getId()) {
                                $nocategoryfound = false;
                                $attributesetid = $cateitem->getAttributeSetId();
                                $_parentid = $cateitem->getParentId();
                                foreach ($cat_data as $key => $value) {
                                    if (!in_array($key, ['category_id', 'url_path', 'path', 'level', 'children_count', 'full_path'])) {
                                        $cateitem->setData($key, $value);
                                    }
                                }
                                $parentid = $cateitem->getParentId();
                                if ($parentid != $_parentid && $cateitem->getId() > 2) {
                                    $_catemodel = $this->categoryFactory->create();
                                    $parentcat = $_catemodel->load($parentid);
                                    if ($parentcat->getId()) {
                                        $cateitem->setPath($parentcat->getPath() . '/' . $cateitem->getId());
                                    } else {
                                        $result['error'] = 1;
                                        $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Parent category not Found') . '</div>';
                                    }
                                    $cateitem->move($parentid, false);
                                }
                                if ($cateitem->getId() <= 2) {
                                    $cateitem->unsetData('posted_products');
                                }
                                $cateitem->save();
                            } else {
                                $patharray = explode("/", $cat_data["path"]);
                                $previousId = $patharray[count($patharray) - 1];
                                $checkParent = $patharray[count($patharray) - 2];
                                array_pop($patharray);
                                $cat_data["path"] = implode("/", $patharray);
                                $newCategoryCreate = $this->categoryFactory->create();
                                if (isset($categoriesPathPresent[$checkParent])) {
                                    $newCategoryCreate->setData($cat_data);
                                    $newCategoryCreate->setParentId($cat_data["parent_id"]);
                                    $newCategoryCreate->setIsActive(true);
                                    $newCategoryCreate->setPath($cat_data["path"]);
                                    $newCategoryCreate->setAttributeSetId($cateitem->getDefaultAttributeSetId());
                                    $newCategoryCreate->setName($cat_data["name"]);
                                    $newCategoryCreate->setUrlKey($cat_data["name"] . '-' . mt_rand(10, 999));
                                    $newCategoryCreate->save();
                                    $nocategoryfound = false;
                                    $newOldMapping = [];
                                    if ($count <= 2) {
                                        $this->session->unsNewOldMapping();
                                    }
                                    if (count($this->session->getNewOldMapping()) > 0) {
                                        $newOldMapping = $this->session->getNewOldMapping();
                                        $newOldMapping[$categoryItem[$categoryidkey]] = $newCategoryCreate->getId();
                                        $this->session->setNewOldMapping($newOldMapping);
                                    } else {
                                        $newOldMapping[$categoryItem[$categoryidkey]] = $newCategoryCreate->getId();
                                        $this->session->setNewOldMapping($newOldMapping);
                                    }
                                } else {
                                        $newCategoryCreate->setData($cat_data);
                                        $newOldMapping = $this->session->getNewOldMapping();

                                        $parentCategoryCreate = $this->categoryFactory->create();

                                        $array = $parentCategoryCreate->getCollection()->getData();
                                        $changeParent = "";
                                    if (isset($newOldMapping[$cat_data["parent_id"]])) {
                                        $changeParent = $newOldMapping[$cat_data["parent_id"]];
                                    }
                                        $patharray = explode("/", $cat_data["path"]);
                                    for ($key = 0; $key < count($patharray); $key++) {
                                        if (isset($newOldMapping[$patharray[$key]])) {
                                            $patharray[$key] = $newOldMapping[$patharray[$key]];
                                        }
                                    }
                                        $cat_data["path"] = implode("/", $patharray);
                                        $newCategoryCreate->setParentId($changeParent);
                                        $newCategoryCreate->setIsActive(true);
                                        $newCategoryCreate->setPath($cat_data["path"]);
                                        $newCategoryCreate->setAttributeSetId($cateitem->getDefaultAttributeSetId());
                                        $newCategoryCreate->setName($cat_data["name"]);
                                        $newCategoryCreate->setUrlKey($cat_data["name"] . $cat_data["parent_id"] . '-' . mt_rand(10, 999));
                                        $newCategoryCreate->save();
                                        $nocategoryfound = false;
                                    if (count($this->session->getNewOldMapping()) > 0) {
                                        $newOldMapping = $this->session->getNewOldMapping();
                                        $newOldMapping[$categoryItem[$categoryidkey]] = $newCategoryCreate->getId();
                                        $this->session->setNewOldMapping($newOldMapping);
                                    } else {
                                        $newOldMapping[$categoryItem[$categoryidkey]] = $newCategoryCreate->getId();
                                        $this->session->setNewOldMapping($newOldMapping);
                                    }
                                }
                            }
                            if ($count == count($data)) {
                                $this->session->unsNewOldMapping();
                                $this->helper->getSession()->unsCSVData();
                            }
                        } else {
                            $result['error'] = 1;
                            $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Data Not Found') . '</div>';
                        }
                    }
                }
                if (isset($alreadyexist) && !empty($alreadyexist)) {
                    $result['error'] = 1;
                    $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('This category already exists: ') . implode(', ', $alreadyexist) . '</div>';
                } elseif (isset($categoryidkey) && $categoryidkey === 0) {
                    if ($nocategoryfound) {
                        $result['error'] = 1;
                        $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('No Category Found.') . '</div>';
                    } elseif ($result['error'] == 1) {
                        $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Please upadte/create categories for one store at a time') . '</div>';
                    } else {
                        $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Successfully imported category ' . $count . ".") . '</div>';
                    }
                } else {
                    $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Successfully imported category ' . $count . ".") . '</div>';
                }
            } elseif ($result['error'] > 1) {
                $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Image file size is not compatible with the size of the files required to upload. Please update the upload_max_filesize variable value in PHP_INI file. Max size of the file to upload is ' . $uplloadFileSizeVal[0] . "MB") . '</div>';
                if ($count == count($data)) {
                    $this->session->unsFileSize();
                }
            } else {
                $result['error'] = 1;
                $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Data Not Found') . '</div>';
            }
            if ($result['error']) {
                $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . $result['msg'] . '</div>';
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result['error'] = 1;
            $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Something went wrong') . '</div>';
            $this->logger->debug($e->getMessage());
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $result['error'] = 1;
            $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Something went wrong') . '</div>';
            $this->logger->debug($e->getMessage());
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $result['error'] = 1;
            $result['msg'] = '<div class="wk-mu-error wk-mu-box">' . __('Something went wrong') . '</div>';
            $this->logger->debug($e->getMessage());
            $this->messageManager->addException($e, $e->getMessage());
        }
        $result = $this->jsonHelper->jsonEncode($result);
        $this->getResponse()->representJson($result);
    }

    protected function getKeyValue($row, $tagsArray)
    {
        $temp = [];
        foreach ($tagsArray as $key => $value) {
            if ($value == 'image') {
                $temp[$value] = $this->getImagePath($row[$key]);
            } elseif ($value == 'products' && $row[$key] != '') {
                $productsIds = explode(',', $row[$key]);
                $products = $this->productFactory->create()->getCollection()->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['in' => $productsIds]);
                $collectionProductIds = $products->getAllIds();

                $temp['posted_products'] = array_flip(array_intersect($productsIds, $collectionProductIds));
            } else {
                $temp[$value] = $row[$key];
            }
        }
        return $temp;
    }

    protected function getImagePath($categoryimage)
    {
        $weburl = strpos($categoryimage, 'http://');
        if ($weburl !== false) {
            $imagepath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('catalog/category');
            $this->fileio->mkdir($imagepath, '0777', true);
            $file = file_get_contents($categoryimage);
            if ($file != '') {
                $allowed = ['gif', 'png', 'jpg', 'jpeg'];
                $ext = strtolower(pathinfo($categoryimage, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed)) {
                    $imagename = pathinfo($categoryimage, PATHINFO_BASENAME);
                    if (!is_dir($imagepath)) {
                        $this->fileio->mkdir($imagepath, '0777', true);
                    }
                    $imagepath = $imagepath . '/' . $imagename;
                    $result = file_put_contents($imagepath, $file);
                    if ($result) {
                        return $imagename;
                    }
                }
            }
        } else {
            $imagepath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('catalog/category');
            $imagepath = $imagepath . '/' . $categoryimage;
            if (file_exists($imagepath)) {
                return $categoryimage;
            } else {
                return '';
            }
        }
    }

    protected function getparentCategories($category)
    {
        $pathIds = array_reverse(explode(',', $category->getPathInStore()));
        /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $categories */
        $categories = $this->categoryFactory->create()->getCollection();
        return $categories->setStore(
            $this->storeManager->getStore()
        )->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'url_key'
        )->addFieldToFilter(
            'entity_id',
            ['in' => $pathIds]
        )->load()->getItems();
    }

    /**
     * Check for is allowed.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_CategoryMassUpload::import');
    }
}
