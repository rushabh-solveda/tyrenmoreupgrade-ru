<?php

namespace Payment\Phonepe\Controller\Payment;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;


class Hook extends \Magento\Framework\App\Action\Action
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
       // $logger->info('hookdddddddddddddd');
        
        $responseContent = [
                    'success'           => true,
                    'order_id'          => 1,
                    'quote_currency'    => 'inc',
                    'quote_amount'      => 'xczvz',
                    'RESEVATION_ID'=>'sdsadsa',
                ];
     
        $code = 200;
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($responseContent);
        $response->setHttpResponseCode($code);

        return $response;
    }





  
}
