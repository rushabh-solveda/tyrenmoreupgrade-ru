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
namespace Webkul\CategoryMassUpload\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->moveDirToMediaDir();
    }

    private function moveDirToMediaDir()
    {
        try {
            $objManager = \Magento\Framework\App\ObjectManager::getInstance();
            $reader = $objManager->get('Magento\Framework\Module\Dir\Reader');
            $filesystem = $objManager->get('Magento\Framework\Filesystem');
            $fileDriver = $objManager->get('Magento\Framework\Filesystem\Driver\File');
            $type = \Magento\Framework\App\Filesystem\DirectoryList::MEDIA;
            $smpleFilePath = $filesystem->getDirectoryRead($type)
                                        ->getAbsolutePath().'category/massupload/samples/';
            $files = ['category.csv', 'category.xls', 'category.xml'];
            if ($fileDriver->isExists($smpleFilePath)) {
                $fileDriver->deleteDirectory($smpleFilePath);
            }
            if (!$fileDriver->isExists($smpleFilePath)) {
                $fileDriver->createDirectory($smpleFilePath, 0777);
            }
            foreach ($files as $file) {
                $filePath = $smpleFilePath.$file;
                if (!$fileDriver->isExists($filePath)) {
                    $path = '/pub/media/category/massupload/samples/'.$file;
                    $mediaFile = $reader->getModuleDir('', 'Webkul_CategoryMassUpload').$path;
                    if ($fileDriver->isExists($mediaFile)) {
                        $fileDriver->copy($mediaFile, $filePath);
                    }
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
