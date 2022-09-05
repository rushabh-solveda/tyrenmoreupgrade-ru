<?php
namespace Payment\Phonepe\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\OfflinePayments\Model\Banktransfer;

class SaveOrderObserver implements ObserverInterface
{
    
    public function __construct(\Magento\Webapi\Controller\Rest\InputParamsResolver $inputParamsResolver, \Magento\Quote\Model\QuoteRepository $quoteRepository, \Psr\Log\LoggerInterface $logger,\Magento\Framework\App\State $state) {
        $this->_inputParamsResolver = $inputParamsResolver;
        $this->_quoteRepository = $quoteRepository;
        $this->logger = $logger;
        $this->_state = $state;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        
         $inputParams = $this->_inputParamsResolver->resolve();
         
    //     $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	   // $logger = new \Zend\Log\Logger();
    //     $logger->addWriter($writer);
        
        
    //     $inputParams = $this->_inputParamsResolver->resolve();
        
    //      $logger->info('pyyyyyyyy-$inputParams->'.print_r($inputParams, true));
         
    //     foreach ($inputParams as $inputParam) {
          
    //             $paymentData = $inputParam->getData('additional_data');
    //             $logger->info('additional_data->'.print_r($paymentData, true));
                
    //             // $paymentOrder = $observer->getEvent()->getPayment();
    //             // $order = $paymentOrder->getOrder();
    //             // $quote = $this->_quoteRepository->get($order->getQuoteId());
    //             // $paymentQuote = $quote->getPayment();
    //             // $method = $paymentQuote->getMethodInstance()->getCode();
    //             // // if ($method == 'phonepe') {
                    
    //             //     $paymentQuote->setData('RESEVATION_ID', $paymentData['RESEVATION_ID']);
    //             //     $paymentOrder->setData('temp_order_id', $paymentData['temp_order_id']);
    //             //     $paymentOrder->setData('transaction_id', $paymentData['transaction_id']);
                    
    //             //     $logger->info('pyyyyyyyy-$order->'.print_r($paymentData['transaction_id'], true));
    //             //     $logger->info('pyyyyyyyy-$order->'.print_r($paymentData['RESEVATION_ID'], true));
                    
                    
    //             // }
    //         // }
    //     // }
    //   }
        

                        
        // $order = $observer->getEvent()->getOrder();
        // $quote = $observer->getEvent()->getQuote();

        

        
        // $logger->info('pyyyyyyyy-$order->'.print_r($order, true));
        // $logger->info('pyyyyyyyy-$order->'.print_r($quote, true));
        
        // $logger->info('pyyyyyyyy-$order->'.print_r($order['additional_data'], true));
        // $logger->info('pyyyyyyyy-$quote->'.print_r($quote['additional_data'], true));
        

        return $this;
        
    }
}