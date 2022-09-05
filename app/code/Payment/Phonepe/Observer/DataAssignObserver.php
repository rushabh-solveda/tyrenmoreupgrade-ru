<?php 

namespace Payment\Phonepe\Observer;
use Magento\Framework\Event\Observer;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Payment\Observer\AbstractDataAssignObserver;

class DataAssignObserver extends AbstractDataAssignObserver
{
    const payment_method_nonce = 'phonepe';
     const RESEVATION_ID = 'RESEVATION_ID';
      const temp_order_id = 'temp_order_id';
       const transaction_id = 'transaction_id';

    /**
     * @var array
     */
    protected $additionalInformationList = [
        self::payment_method_nonce,
         self::RESEVATION_ID,
          self::temp_order_id,
           self::transaction_id,
    ];

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        

        
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        // $order = $paymentDO->getOrder();
         
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	       $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        
        // $logger->info('pyyyyyyyy-$inputParams->'.print_r($data->getData('additional_data'), true));
       // $logger->info('pyyyyyyyy-$inputParams->'.print_r($additionalData['transaction_id'], true));
       
       // $order_id=$order->getOrderIncrementId();
       
    //   $merchantId="TYRESNMORETEST";
    //   $saltKey = "7440ea8c-0998-43f5-833b-a0310379a0b6";
    //   $saltIndex = "1";
    //   $transactionId=$additionalData['transaction_id'];
       
       
       // $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
     		// $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
     		// $connection = $resource->getConnection();
     		// $tableName = $resource->getTableName('phonepe_response'); 
     		
     		
     		 //$xVerify = hash('sha256','/v3/transaction/'.$merchantId.'/'.$transactionId.'/status'. $saltKey) . '###' . $saltIndex;

     		 //$url="https://apps-uat.phonepe.com/v3/transaction/".$merchantId."/".$transactionId."/status";
     		
     		 //$logger->info('pyyyyyyyy-$inputParams->'.print_r($additionalData['transaction_id'], true));
     		 //$logger->info('pyyyyyyyy-$inputParams->'.print_r($url, true));
     		 //$logger->info('pyyyyyyyy-$inputParams->'.print_r($xVerify, true));
     		 
     		 
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'X-VERIFY: ' . $xVerify,
    //         'X-CLIENT-ID:' . $merchantId
    //     ));
       
    //     $payment_data = curl_exec($ch);
    //     curl_close($ch);
   

    //   $logger->info('$payment_data->'.print_r($payment_data, true));

     		
     		// $sql = "Update " . $tableName . "Set response_order_id = ".$order_id." where emp_id = 12";
     		
 	     // $sql = "Insert Into " . $tableName . " (response_id, response_customer_enail, response_order_id, response_status,response_reservation_id,response_transaction_id,response_obj,response_price) Values ('','','','','".$response_data['data']['reservationId']."','".$transactionId."','','".$amount."')";
       // $connection->query($sql);
       

       
    //     [RESEVATION_ID] => R2004251919351911416591
    // [temp_order_id] => 1241
    // [transaction_id] => 15878225741676380
    
    
    
        // $method = $this->readMethodArgument($observer);

        // $paymentInfo = $method->getInfoInstance();



        // $paymentInfo = $this->readPaymentModelArgument($observer);

        // foreach ($this->additionalInformationList as $additionalInformationKey) {
        //     if (isset($additionalData[$additionalInformationKey])) {
        //         $paymentInfo->setAdditionalInformation(
        //             $additionalInformationKey,
        //             $additionalData[$additionalInformationKey]
                   
        //         );
                
                
            
            
        
        //     }
        //}
    }
    
    


}




