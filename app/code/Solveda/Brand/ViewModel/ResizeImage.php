<?php

namespace Solveda\Brand\ViewModel;

use Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ResizeImage extends AbstractHelper implements ArgumentInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var File
     */
    protected $fileDriver;

    /**
     * Resize image constructor
     *
     * @param Filesystem            $filesystem
     * @param AdapterFactory        $imageFactory
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface  $scopeConfig
     * @param LoggerInterface       $logger
     * @param File                  $fileDriver
     */
    public function __construct(
        Filesystem $filesystem,
        AdapterFactory $imageFactory,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        File $fileDriver
    ) {
        $this->filesystem = $filesystem;
        $this->imageFactory = $imageFactory;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->fileDriver = $fileDriver;
    }

    /**
     * Get Authorized Brand Icon
     *
     * @return string
     */
    public function getCertificateIcon()
    {
        $certificateDir = 'certificate/';
        $baseUrl = $this->getMediaBaseUrl();
        $icon = $this->getConfig('brands/general/authorized_certificate');
        $iconPath = $this->filesystem
            ->getDirectoryRead(DirectoryList::MEDIA)
            ->getAbsolutePath($certificateDir) . $icon;
        if (!empty($iconPath) && $this->fileDriver->isExists($iconPath)) {
            return $baseUrl . $certificateDir . $icon;
        }
        return false;
    }

    /**
     * Get Media base URL
     *
     * @return string
     */
    public function getMediaBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * Scope Configuration
     * @param string $name
     * @return string
     */
    public function getConfig($name)
    {
        return $this->scopeConfig->getValue($name);
    }

    /**
     * Return Small certificate image
     * @param string $image
     * @return string
     */
    public function getSmallCertificateImage($image)
    {
        if ($image) {
            $absolutePath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog/certificate/') . $image;
            if ($this->fileDriver->isExists($absolutePath)) {
                return $this->resize($image, 300, 300);
            }
        }
        return false;
    }

    /**
     * Return Authorized Dealer Certificate
     * @param string $image
     * @return string
     */
    public function getCertificateImage($image)
    {
        if ($image) {
            $absolutePath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog/certificate/') . $image;
            if ($this->fileDriver->isExists($absolutePath)) {
                $baseUrl = $this->getMediaBaseUrl();
                $directory = 'catalog/certificate/';
                return $baseUrl . $directory . $image;
            }
        }
        return false;
    }

    /**
     * Return Category banner image
     * @param string $image
     * @return string
     */
    public function getBannerImage($image)
    {
        if ($image) {
            $absolutePath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog/banner/') . $image;
            if ($this->fileDriver->isExists($absolutePath)) {
                $baseUrl = $this->getMediaBaseUrl();
                $directory = 'catalog/banner/';
                return $baseUrl . $directory . $image;
            }
        }
        return false;
    }

    /**
     * Resize image
     *
     * @param string  $image
     * @param integer $width
     * @param integer $height
     *
     * @return string
     * */
    public function resize($image, $width = null, $height = null)
    {
        try {

            $absolutePath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog/certificate/') . $image;

            $imageResized = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('resized/') . $image;

            $resizedURL = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'resized/' . $image;

            if (!empty($imageResized) && $this->fileDriver->isExists($imageResized)) {
                return $resizedURL;
            }

            //create image factory...
            $imageResize = $this->imageFactory->create();
            $imageResize->open($absolutePath);
            $imageResize->constrainOnly(true);
            $imageResize->keepTransparency(true);
            $imageResize->keepFrame(false);
            $imageResize->keepAspectRatio(true);
            $imageResize->resize($width, $height);
            //destination folder
            $destination = $imageResized;
            //save image
            $imageResize->save($destination);
        } catch (Exception $e) {
            $this->logger->error('Image not created', [$e->getMessage()]);
        }

        return $resizedURL;
    }
}
