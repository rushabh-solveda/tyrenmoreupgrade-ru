<?php
/**
 * @category   Clarksfield
 * @package    Clarksfield_Customersspeak
 * @author     nitish.bluethink@gmail.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Clarksfield\Customersspeak\Controller\Index;

use Magento\Framework\App\Action\Context;
use Clarksfield\Customersspeak\Model\CustomersspeakFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Customersspeak
     */
    protected $_customersspeak;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;

    public function __construct(
		Context $context,
        CustomersspeakFactory $customersspeak,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem
    ) {
        $this->_customersspeak = $customersspeak;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }
	public function execute()
    {
        $data = $this->getRequest()->getParams();
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            try{
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $imageAdapter = $this->adapterFactory->create();
                $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('clarksfield/customersspeak');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                
                $imagePath = 'clarksfield/customersspeak'.$result['file'];
                $data['image'] = $imagePath;
            } catch (\Exception $e) {
            }
        }
    	$customersspeak = $this->_customersspeak->create();
        $customersspeak->setData($data);
        if($customersspeak->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('customersspeak');
        return $resultRedirect;
    }
}
