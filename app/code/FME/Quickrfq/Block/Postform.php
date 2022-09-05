<?php
namespace FME\Quickrfq\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Postform extends Template
{
        
        
        const CONFIG_CAPTCHA_PUBLIC_KEY = 'quickrfq/google_options/googlepublickey';
        const CONFIG_CAPTCHA_THEME = 'quickrfq/google_options/theme';
        const CONFIG_CAPTCHA_ENABLE = 'quickrfq/google_options/captchastatus';
        
        const CONFIG_FILE_EXT_UPLOAD = 'quickrfq/upload/allow';
        
    protected $scopeConfig;
    protected $productRepository;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                ProductRepositoryInterface $productRepository)
    {
        
        $this->scopeConfig = $context->getScopeConfig();
        $this->productRepository = $productRepository;

        parent::__construct($context);
        $this->_params = $this->getRequest()->getParams();

        if(array_key_exists( "product_id", $this->_params))
        {

            $productId = $this->_params["product_id"];
            $this->currentProduct = $this->productRepository->getById($productId);

            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
            $store = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
            $this->productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->currentProduct->getImage();
        }

    }
        
        
               
    public function getFormAction()
    {
        return $this->getUrl('quickrfq/index/post', ['_secure' => true]);
    }
        
        
        
    public function getCaptchaTheme()
    {
                
        $theme = $this->scopeConfig->getValue(self::CONFIG_CAPTCHA_THEME);
        return $theme;
    }
        
    public function isCaptchaEnable()
    {
                
        $enable = $this->scopeConfig->getValue(self::CONFIG_CAPTCHA_ENABLE);
        return $enable;
    }
        
    public function getAllowedFileExtensions()
    {
                
        $ext = $this->scopeConfig->getValue(self::CONFIG_FILE_EXT_UPLOAD);
        return $ext;
    }
    public function getPublicKey()
    {
        
        return $this->scopeConfig->getValue(self::CONFIG_CAPTCHA_PUBLIC_KEY);
    }
}
