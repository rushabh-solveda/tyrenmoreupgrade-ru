<?php

namespace Payment\Phonepe\Controller\Payment;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;


class Webhook extends \Magento\Framework\App\Action\Action
{
	protected $quote;

    protected $checkoutSession;
 

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
        \Magento\Catalog\Model\Session $catalogSession

      
    ) {
        parent::__construct(
            $context
            
        );
    $this->customerSession = $customerSession;
    $this->checkoutSession = $checkoutSession;
    $this->catalogSession = $catalogSession;
    }

    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $data=$this->getRequest()->getParams();
       
        
        
        $merchantId="TYRESNMOREINAPP";
        $saltKey = "15e75ff9-3f54-434a-a283-06f8dc74c0bb";
        $saltIndex = "1";


          
     	$transactionId=$data['transaction_id'];
     	$temp_order_id=$data['temp_order_id'];
     	
     	     	
     	     	
     	
     		
     	$xVerify = hash('sha256','/v3/transaction/'.$merchantId.'/'.$transactionId.'/status'. $saltKey) . '###' . $saltIndex;
     	$url="https://apps.phonepe.com/v3/transaction/".$merchantId."/".$transactionId."/status";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-VERIFY: ' . $xVerify,
            'X-CLIENT-ID:' . $merchantId
        ));
       
        $payment_data =curl_exec($ch);
        curl_close($ch);
   
        $res_data=json_decode($payment_data, true);

    
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
     	$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
     	$connection = $resource->getConnection();
     	$tableName = $resource->getTableName('phonepe_response'); 
     		
        $sql = "Update " . $tableName . " Set response_obj = '".$payment_data."', response_status='".$res_data['data']['paymentState']."' where response_transaction_id =".$transactionId;
        $connection->query($sql);
        
        $responseContent = [
            'success'           => true,
            'status'=>$res_data['data']['payResponseCode'],
           
        ];
      
        $code = 200;
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($responseContent);
        $response->setHttpResponseCode($code);
        return $response;
    }


  
}
