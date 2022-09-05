<?php
namespace Tatvic\ActionableGoogleAnalytics\Block;

use \Magento\Framework\View\Element\Template;

/**
 * Class EnhancedEcommerce
 * @package Tatvic\ActionableGoogleAnalytics\Block
 */
class ActionableGoogleAnalytics extends Template
{
    protected $_helper;

    protected $request;

    protected $blockFactory;

    /**
     * ActionableGoogleAnalytics constructor.
     * @param Template\Context $context
     * @param array $data
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Tatvic\ActionableGoogleAnalytics\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \Magento\Framework\App\Request\Http $request,
        \Tatvic\ActionableGoogleAnalytics\Helper\Data $helper
    ){
        parent::__construct($context,$data);
        $this->_helper = $helper;
        $this->request = $request;
    }

    public function getUaId()
    {
        return $this->_helper->getUaID();
    }
    public function checkDF_enabled()
    {
        return $this->_helper->checkDf_enabled();
    }
    public function checkIP_anonymization()
    {
        return $this->_helper->checkIP_enabled();
    }
    public function checkClientId_Enabled()
    {
        return $this->_helper->checkClientId_Enabled();
    }
    public function checkOptOut_Enabled()
    {
        return $this->_helper->checkOptOut_Enabled();
    }
    public function FBPixelEnabled()
    {
        return $this->_helper->checkFbpixelEnabled();
    }
    public function AdwordsEnabled()
    {
        return $this->_helper->checkAdwords_Enabled();
    }
    public function getAdwordsID()
    {
        return $this->_helper->getAdwordsID();
    }
    public function getAdwordsLabel()
    {
        return $this->_helper->getAdwordsLabel();
    }
    public function getFbPixelID()
    {
        return $this->_helper->getFBPixelID();
    }
    public function getMagentoVersion(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
        $version = $productMetadata->getVersion();
        return $version;
    }
    public function getAction()
    {
        $get_action = $this->request->getFullActionName();
        if(method_exists($this, $get_action)) {
            $data = $this->$get_action();
            return array($data,$get_action);
        }

    }
    public function getLocalCurrency()
    {
        return $this->_helper->getCurrencyCode();
    }
    public function get_user_ID(){
        $user_id = '';
        if($this->_helper->getUser_ID()) {
            $user_id = $this->_helper->getUser_ID();
        }
        return base64_encode($user_id);
    }
    public function getTotalOrder()
    {
        return $this->_helper->getTotalOrder();
    }
    public function getTotal(){
        return $this->_helper->getFbTotal();
    }
    protected function catalog_category_view()
    {
        $t_getCategoryProduct = $this->_helper->getCategoryProduct();
        return json_encode($t_getCategoryProduct);
    }
    protected function catalog_product_view()
    {
        $tvc_product_details = $this->_helper->getProductDetails();
        return json_encode($tvc_product_details);
    }
    protected function checkout_cart_index()
    {
        $tvc_cart_items = $this->_helper->getCartpageInfo();
        return json_encode($tvc_cart_items);
    }
    protected function checkout_index_index()
    {
        $tvc_cart_items = $this->_helper->getCartpageInfo();
        $tvc_loggedin = $this->_helper->check_IsLoggedIn();
        array_push($tvc_cart_items, $tvc_loggedin);
        return json_encode($tvc_cart_items);
    }
    protected function checkout_onepage_success()
    {
        $tvc_order_obj = $this->_helper->getOrderDetails();
        $tvc_trans_detail = $this->_helper->getTransactionDetails();
        array_push($tvc_order_obj, $tvc_trans_detail);
        return json_encode($tvc_order_obj);
    }
}