<?php

namespace Payment\Phonepe\Controller\Payment;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;


class Order extends \Magento\Framework\App\Action\Action
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
        $quote=$this->checkoutSession->getQuote();
        
        $amount = (int) (round($quote->getGrandTotal(), 2) * 100);

        $receipt_id = $quote->getId();

        
        $maze_version = $this->_objectManager->get('Magento\Framework\App\ProductMetadataInterface')->getVersion();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        // $logger->info('$receipt_id->'.print_r($receipt_id, true));
        
        $items = $quote->getAllVisibleItems();

        
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $cartObj = $objectManager->get('\Magento\Checkout\Model\Cart');

        $billingAddressInfo = $cartObj->getQuote()->getBillingAddress();
        
        
       
        
        $totalqty= (int) $cartObj->getQuote()->getItemsQty();

        
        

        $billingAddress = $billingAddressInfo->getData();
        $product_list=array();
        foreach($items as $item){

            $pro = array(
                    "category"=> "SHOPPING",
                    "itemId"=> $item->getProductId(),
                    "price"=> (int)$item->getPrice(),
                    "itemName"=> $this->str_clean($item->getName()),
                    "quantity"=> $totalqty,
                    "address"=> array(
                        "addressString"=> $billingAddress['city'],
                        "city"=> $billingAddress['city'],
                        "pincode"=> $billingAddress['postcode'],
                        "country"=> $billingAddress['country_id'],
                        "latitude"=> 1,
                        "longitude"=> 1
                    ),
                    "shippingInfo"=> array(
                        "deliveryType"=> "STANDARD",
                        "time"=> array(
                        "timestamp"=> time(),
                        "zoneOffSet"=> "+05:30"
                        )
                    )
                    
                );
               
            $product_list = $pro;
        }
       
//  $logger->info('items ->'.print_r($product_list, true));
  

   
 
        $orderId = $receipt_id;
        $transactionId = str_replace(".","",microtime(true)).rand(000,999);;
        $saltKey = "15e75ff9-3f54-434a-a283-06f8dc74c0bb";
        $saltIndex = "1";
        $merchantId = "TYRESNMOREINAPP";

        $merchantContext = array(
            'merchantId'=> $merchantId,
            'amount'=> $amount,
            'validFor'=> 10 * 60 * 1000,
            'transactionId'=> $transactionId,
            'merchantOrderId'=> $orderId,
            'transactionType'=> "STANDARD",
            'salt'=> array(
                'key'=>$saltKey,
                'index'=> $saltIndex
            )
        );

        $sampleCart = array(
            "orderContext"=> array(
                "trackingInfo"=> array(
                    "type"=> "HTTPS",
                    "url"=> "https://tyresnmore.com/sales/order/history/"
                )
            ),
            "fareDetails"=> array(
                "totalAmount"=> $amount,
                "payableAmount"=> $amount
            ),
            "cartDetails"=> array(
                "cartItems"=> 
                  [$product_list]
                
            )
        );
        // $sampleCart = array( https://tyres.clarksfield.com/customer/account/
        //     "orderContext"=> array(
        //         "trackingInfo"=> array(
        //             "type"=> "HTTPS",
        //             "url"=> "https://tyres.clarksfield.com/Phonepe/payment/hook/"
        //         )
        //     ),
        //     "fareDetails"=> array(
        //         "totalAmount"=> $amount,
        //         "payableAmount"=> $amount
        //     ),
        //     "cartDetails"=> array(
        //         "cartItems"=> [
        //             array(
        //             "category"=> "SHOPPING",
        //             "itemId"=> "1234567890",
        //             "price"=> $amount,
        //             "itemName"=> "TEST",
        //             "quantity"=> 1,
        //             "address"=> array(
        //                 "addressString"=> "TEST",
        //                 "city"=> "TEST",
        //                 "pincode"=> "TEST",
        //                 "country"=> "TEST",
        //                 "latitude"=> 1,
        //                 "longitude"=> 1
        //             ),
        //             "shippingInfo"=> array(
        //                 "deliveryType"=> "STANDARD",
        //                 "time"=> array(
        //                 "timestamp"=> time(),
        //                 "zoneOffSet"=> "+05:30"
        //                 )
        //             )
        //          )
        //         ]
        //     )
        // );

//  $logger->info('sampleCart1 ->'.print_r($sampleCart1, true));
//   $logger->info('sampleCart ->'.print_r($sampleCart, true));

        $samplePayload = $this->getPayload($sampleCart, $merchantContext);
        $response_data = json_decode($this->getInitiatedRequest($samplePayload, $merchantContext), true);
        // $logger->info('response ->'.print_r($response_data, true));
        
        $responseContent = [
                    'success'           => true,
                    'order_id'          => $receipt_id,
                    'quote_currency'    => $this->checkoutSession->getQuote()->getQuoteCurrencyCode(),
                    'quote_amount'      => round($this->checkoutSession->getQuote()->getGrandTotal(), 2),
                    'RESEVATION_ID'=>$response_data['data']['reservationId'],
                    'transaction_id'=>$transactionId,
                ];
     
        $code = 200;
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($responseContent);
        $response->setHttpResponseCode($code);

        if($response_data['data']['reservationId']){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('phonepe_response'); 
 	    $sql = "Insert Into " . $tableName . " (response_id, response_customer_enail, response_order_id, response_status,response_reservation_id,response_transaction_id,response_obj,response_price) Values ('','','','','".$response_data['data']['reservationId']."','".$transactionId."','','".$amount."')";
        $connection->query($sql);
        }
    
        return $response;
    }

public function str_clean($string) {
   $string = str_replace(' ', '-', $string); 

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

public function getPayload($cart, $merchantContext)
{
  

    $cartContext = base64_encode(json_encode(($cart)));

    $payload = array(
        'merchantId' => $merchantContext['merchantId'],
        'amount' => $merchantContext['amount'],
        'validFor'=> 10*60*1000, // 10 minutes,
        'transactionId' => $merchantContext['transactionId'],
        'merchantOrderId' => $merchantContext['merchantOrderId'],
        'transactionContext'=> $cartContext
    );
    return $payload;
}

public function getInitiatedRequest($payload, $merchantContext)
{
    $xVerify = hash('sha256', base64_encode(json_encode($payload)) . '/v3/transaction/initiate' . $merchantContext['salt']['key']) . '###' . $merchantContext['salt']['index'];

    $request = array(
        'request' => base64_encode(json_encode($payload))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://apps.phonepe.com/v3/transaction/initiate");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-VERIFY: ' . $xVerify,
        'X-CLIENT-ID: ' . $payload['merchantId'],
        'Content-Type: application/json',
        'X-CALLBACK-URL:  https://tyresnmore.com/customer/account/'
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


  
}
