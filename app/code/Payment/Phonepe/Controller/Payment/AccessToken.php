<?php

namespace Payment\Phonepe\Controller\Payment;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Math\Random;
use Magento\Store\Model\StoreManagerInterface;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Magento\Framework\App\ResponseFactory;
use Magento\Authorization\Model\ResourceModel\Role\Collection;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;

class AccessToken extends \Magento\Framework\App\Action\Action
{
	protected $quote;

    protected $checkoutSession;
    private $randomUt;
    private $defaultRole;
    private $userFactory;
    private $customerModel;
    
	protected $_currency = 'INR';
	/**
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Customer\Model\Session $customerSession
    * @param \Magento\Checkout\Model\Session $checkoutSession
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Model\Session $catalogSession,
        Random $randomUtility,
        User $adminUserModel,
        Customer $customerModel,
        StoreManagerInterface $storeManager,
        CustomerFactory $customerFactory

    ) {
        parent::__construct(
            $context
            

        );
    $this->randomUtility = $randomUtility;        
    $this->customerSession = $customerSession;
    $this->checkoutSession = $checkoutSession;
    $this->catalogSession = $catalogSession;
    $this->customerModel = $customerModel;
    $this->storeManager = $storeManager;
    $this->customerFactory = $customerFactory;
    }

    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        

        $data=$this->getRequest()->getParams();
        $grantToken=$data['grantToken'];
        // $email=$data['email'];
        
        if(!$grantToken==0){
        
        $merchantId="TYRESNMOREINAPP";
        $saltKey = "15e75ff9-3f54-434a-a283-06f8dc74c0bb";
        $saltIndex = "1";


     	
     	$payload = array(
        'grantToken' => $grantToken
        );
        $encode_payload=base64_encode(json_encode($payload));
        
     	 $request = array(
        'request' => $encode_payload
         );
	    
     	$xVerify = hash('sha256',$encode_payload . '/v3/service/auth/access' . $saltKey) . '###' . $saltIndex;
     	
     	

  
     	
     	
     	
     	$url="https://apps.phonepe.com/v3/service/auth/access";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-VERIFY: ' . $xVerify,
            'X-CLIENT-ID:' . $merchantId,
            'Content-Type:application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        
        $payment_data =curl_exec($ch);
        curl_close($ch);
   
        $res_data=json_decode($payment_data, true);

        $accessToken=$res_data['data']['accessToken'];
    
        $req_data=[
            'accessToken'=>$accessToken,
            'merchantId'=>$merchantId,
            'saltKey'=>$saltKey,
            'saltIndex'=>$saltIndex
            
            ];
        
        $user_data=$this->getUserDetails($req_data);
        
    
        //$logger->info('user_data ->'.print_r($user_data, true));

        $name=$user_data['data']['name'];
        $phoneNumber=$user_data['data']['phoneNumber'];
        $userEmail=$user_data['data']['primaryEmail'];
        
        $str_name=explode(" ",$name);
        $fname=$str_name[0];
        
        $lname=!empty($str_name[1]) ? $str_name[1] : '-';
        

        
        $user_email=!empty($userEmail) ? $userEmail : $this->generateEmail($phoneNumber);
       
        $user_id=null; 
	$user=null;

	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $session = $objectManager->get('Magento\Customer\Model\Session');
        $session->setTestKey($phoneNumber);
    
        
         $customerData=$this->getUser($user_email);
        if($customerData==null){
            
            $customerData=$this->createCustomer($fname,$lname,$user_email,$phoneNumber); 
            
            $user=$customerData->getData();
            $user_id=$user['entity_id'];

            
        }
  
        $quote=$this->checkoutSession->getQuote();
        
         $items = $quote->getAllVisibleItems();
         $c_item=!empty($items) ? true : false;
         
        $responseContent = [
            'success'=> true,
            'data'=>$payment_data,
            'cartItems'=>$c_item,
            'user_data'=>$user_data,
           
        ];
        
        $code = 200;
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($responseContent);
        $response->setHttpResponseCode($code);
        return $response;    
        
    }else{
        $responseContent = [
            'success'=> true,
            'data'=>'',
            'cartItems'=>'',
            'user_data'=>'',
           
        ];
        $code = 200;
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($responseContent);
        $response->setHttpResponseCode($code);
        return $response;
}

      
    
    }
    
    
public function getUser($email){
    
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
    $logger = new \Zend\Log\Logger();
    $logger->addWriter($writer);
    

    $customerData=null;
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    
    $customerSession = $objectManager->get('Magento\Customer\Model\Session');
    
    if($customerSession->isLoggedIn()) {
        $customerData = $customerSession->getCustomer()->getData(); 

    }else{
        $CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
        $websiteId  = $this->storeManager->getWebsite()->getWebsiteId();

        $CustomerModel->setWebsiteId($websiteId); 
        $CustomerModel->loadByEmail($email);
  
        if($CustomerModel->getId()){

            $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($CustomerModel->getId()); 
            $customerSession = $objectManager->create('Magento\Customer\Model\Session');
            $customerSession->setCustomerAsLoggedIn($customer);
            
            $customerData = $customerSession->getCustomer()->getData(); 
        
        }else{
            $customerData=null;
        }


    }
    
    //$logger->info('$customerData ->'.print_r($customerData, true));
    
    return $customerData;
}

public function is_email($email){
    
    if(empty($email) or $email =='' or $email==null or $email=='undefined' ){
        return false;
    }
    return true;
}

public function getUserDetails($data)
{
    $xVerify = hash('sha256','/v3/service/userdetails' . $data['saltKey']) . '###' . $data['saltIndex'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://apps.phonepe.com/v3/service/userdetails");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-VERIFY: ' . $xVerify,
        'X-CLIENT-ID: ' . $data['merchantId'],
        'Content-Type: application/json',
        'X-ACCESS-TOKEN:' . $data['accessToken']
    ));

    $user_data = curl_exec($ch);
    curl_close($ch);
    $res=json_decode($user_data, true);
    return $res;
}


  
 /**
     * Create a temporary email address based on the mobile
     * in the SAML response. Email Address is a required so we
     * need to generate a temp/fake email if no email comes from
     * the IDP in the SAML response.
     *
     * @param $mobile
     * @return string
     */
    public function generateEmail($mobile)
    {
        $siteurl = 'tyresnmore.com';
        
        return $mobile .'@'.$siteurl;
    }



    
      /**
     * Create a new customer.
     *
     * @param $email
     * @param $userName
     * @param $phoneNumber
     */
    private function createCustomer($fname,$lname, $email, $phoneNumber)
    {   
	$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $random_password = $this->randomUtility->getRandomString(8);
        $websiteId  = $this->storeManager->getWebsite()->getWebsiteId();
        // Instantiate object (this is the most important part)
        $customer   = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        // Preparing data for new customer
        $customer->setEmail($email); 
        $customer->setFirstname($fname);
        $customer->setLastname($lname);
        $customer->setPassword($random_password);
        // Save data
        $customer->save();
        $customer->sendNewAccountEmail();
        $this->userLogin($customer['entity_id']);
        return $customer;
        
        
        
    }
    
    
    
  public function userLogin($customer_id){
        
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // Load customer
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customer_id); //2 is Customer ID
        
        // Load customer session
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        $customerSession->setCustomerAsLoggedIn($customer);
        
        if($customerSession->isLoggedIn()) {
            
            return true;
        }else{
             return false;
        }
    }
  
}
