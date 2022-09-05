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
namespace Webkul\CategoryMassUpload\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\UrlInterface;
use Magento\Framework\Xml\Parser;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    protected $mediaDirectory;

    /**
     * @var \Webkul\CategoryMassUpload\Model\Zip
     */
    protected $zip;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var File
     */
    protected $file;
/**
 * 
 */
protected $coreSession;
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\File\Csv $csvReader,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        Parser $parser,
        File $file,
        \Webkul\CategoryMassUpload\Model\Zip $zip,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\Filesystem\Io\File $fileio,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->request = $context->getRequest();
        $this->moduleManager = $context->getModuleManager();
        $this->storeManager = $storeManager;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->fileSystem = $fileSystem;
        $this->coreSession = $coreSession;
        $this->fileDriver = $fileDriver;
        $this->fileio = $fileio;
        $this->csvReader = $csvReader;
        $this->parser = $parser;
        $this->zip = $zip;
        $this->file = $file;
        $this->mediaDirectory = $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        parent::__construct($context);
    }

    /**
     * Get Sample CSV File Urls.
     *
     * @return string
     */
    public function getSampleCSV()
    {
        $url = $this->mediaDirectory . 'category/massupload/samples/';
        return $url . 'category.csv';
    }

    /**
     * Get Sample XLS File Urls.
     *
     * @return string
     */
    public function getSampleXLS()
    {
        $url = $this->mediaDirectory . 'category/massupload/samples/';
        return $url . 'category.xls';
    }

    /**
     * Get Sample XML File Urls.
     *
     * @return string
     */
    public function getSampleXML()
    {
        $url = $this->mediaDirectory . 'category/massupload/samples/';
        return $url . 'category.xml';
    }

    public function getCategoryPostData()
    {

        $uploader = $this->fileUploaderFactory->create(['fileId' => 'massupload_csv']);
        $uploader->setAllowedExtensions(['CSV', 'csv', 'XML', 'xml', 'XLS', 'xls']);
        $extension = $uploader->getFileExtension();
        $fileData = $uploader->validateFile();

        $fileData['extension'] = $extension;

        if ($fileData['extension'] == 'csv') {
            return $this->csvReader->getData($fileData['tmp_name']);
        } elseif ($fileData['extension'] == 'xls') {
            return $this->csvReader->getData($fileData['tmp_name']);
        } elseif ($fileData['extension'] == 'xml') {
            $data = $this->parser->load($fileData['tmp_name'])->xmlToArray();
            $categoryiesData = $data['node']['category'];
            $dataKeyProductArray = [];
            $dataValueArray = [];
            $count = count($data);
            $flag = 1;
            foreach ($categoryiesData as $key => $value) {
                if (is_array($value) && is_numeric($key)) {
                    $flag = 0;
                    $dataValueProductArray = [];
                    foreach ($value as $productkey => $productValue) {
                        // Start: Coverting uploaded file data attributes into magento attributes
                        if (!empty($attributeMappedArr[$productkey])) {
                            $productkey = $attributeMappedArr[$productkey];
                        }
                        // End: Coverting uploaded file data attributes into magento attributes
                        $dataKeyProductArray[$productkey] = $productkey;
                        $dataValueProductArray[$productkey] = $productValue;
                    }
                    $dataValueArray[] = $dataValueProductArray;
                } else {
                    $dataKeyProductArray[$key] = $key;
                    $dataValueArray[] = $value;
                }
            }
            $i = 0;
            $dataKeyArray = [];
            foreach ($dataKeyProductArray as $key => $value) {
                $dataKeyArray[$i] = $value;
                if (!$flag) {
                    foreach ($dataValueArray as $productkey => $productvalue) {
                        if (empty($dataValueArray[$productkey][$value])) {
                            $dataValueArray[$productkey][$i] = '';
                            unset($dataValueArray[$productkey][$value]);
                        } else {
                            $dataValueArray[$productkey][$i] = $dataValueArray[$productkey][$value];
                            unset($dataValueArray[$productkey][$value]);
                        }
                    }
                }
                $i++;
            }
            $dataCreated[0] = $dataKeyArray;
            if (!$flag) {
                $i = 1;
                foreach ($dataValueArray as $key => $value) {
                    $dataCreated[$i] = $value;
                    $i++;
                }
            } else {
                $dataCreated[1] = $dataValueArray;
            }

            return $dataCreated;
        }
    }

    public function getImagePostData()
    {

        if ($this->request->getFiles('massupload_images')['error'] == 0) {
            $zipModel = $this->zip;
            $basePath = $this->getBasePath();
            $imageUploadPath = $basePath . 'zip/';
            $imageUploader = $this->fileUploaderFactory->create(['fileId' => 'massupload_images']);
            $validateData = $imageUploader->validateFile();
            $imageUploader->setAllowedExtensions(['zip']);
            $imageUploader->setAllowRenameFiles(true);
            $imageUploader->setFilesDispersion(false);
            $imageUploader->save($imageUploadPath);
            $fileName = $imageUploader->getUploadedFileName();
            $source = $imageUploadPath . $fileName;
            $destination = $this->getMediaPath() . 'catalog/category/';
            $zipModel->unzipImages($source, $destination);
        }
    }

    public function getAllStoresNames()
    {
        $stores = [];
        $storesData = $this->storeManager->getStores();
        foreach ($storesData as $key => $store) {
            $stores[$store->getId()] = $store->getName();
        }
        return $stores;
    }

    public function getAllStoresCodes()
    {
        $stores = [];
        $storesData = $this->storeManager->getStores();
        foreach ($storesData as $key => $store) {
            $stores[$store->getId()] = $store->getCode();
        }
        return $stores;
    }

    /**
     * Get Base Path
     *
     * @return string
     */
    public function getBasePath()
    {
        $mediaPath = $this->getMediaPath();
        $basePath = $mediaPath . 'categoryfiles/images/';
        return $basePath;
    }

    /**
     * Get Media Path
     *
     * @return string
     */
    public function getMediaPath()
    {
        return $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
    }
    /**
     *Set all the special character
     */
    public function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
    /**
     * @return session Object
     */
    public function getSession(){
        return $this->coreSession;
    }
}
