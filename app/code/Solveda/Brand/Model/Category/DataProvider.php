<?php

namespace Solveda\Brand\Model\Category;

use Exception;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
    protected function getFieldsMap()
    {
        $fields = parent::getFieldsMap();
        // $fields['content'][] = 'certificate_image';

        return $fields;
    }

    public function getData()
    {
        $fields = parent::getData();
        $storeManager = ObjectManager::getInstance()->get(StoreManagerInterface::class);
        $baseUrl = $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $filesystem = ObjectManager::getInstance()->get(Filesystem::class);
        $basePath = $filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog/certificate/');
        foreach ($fields as $key => $field) {
            if (isset($field['certificate_image'])) {
                $baseUrl .= 'catalog/certificate/';
                $certificate = $baseUrl . $field['certificate_image'];
                $certificatePath = $basePath . $field['certificate_image'];

                $img[0]['name'] = $field['certificate_image'];
                $img[0]['image'] = $field['certificate_image'];
                $img[0]['url'] = $certificate;
                $img[0]['type'] = 'image/png';
                try {
                    $img[0]['size'] = filesize($certificatePath);
                } catch (Exception $e) {
                }

                $fields[$key]['certificate_image'] = $img;
            }
            
            if (isset($field['category_banner'])) {
                $baseUrl .= 'catalog/banner/';
                $certificate = $baseUrl . $field['category_banner'];
                $certificatePath = $basePath . $field['category_banner'];

                $img[0]['name'] = $field['category_banner'];
                $img[0]['image'] = $field['category_banner'];
                $img[0]['url'] = $certificate;
                $img[0]['type'] = 'image/png';
                try {
                    $img[0]['size'] = filesize($certificatePath);
                } catch (Exception $e) {
                }

                $fields[$key]['category_banner'] = $img;
            }
        }
        return $fields;
    }
}
