<?php 

namespace Payment\Phonepe\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\OfflinePayments\Model\Banktransfer;


class RestrictPaymentMethods  implements ObserverInterface
{
    const payment_method_nonce = 'phonepe';

    /**
     * @var array
     */


    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
        $storeManager  = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $storeID       = $storeManager->getStore()->getStoreId(); 
        $storeName     = $storeManager->getStore()->getName();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        //$logger->info('$storeID ->'.print_r($storeID, true));

        if($storeID != 6){
        
        if($observer->getEvent()->getMethodInstance()->getCode()=='phonepe'){
            $checkResult = $observer->getEvent()->getResult();  
            $checkResult->setData('is_available', false);
        }
        }else{
            
            if($observer->getEvent()->getMethodInstance()->getCode()=='cashondelivery'){
            $checkResult = $observer->getEvent()->getResult();  
            $checkResult->setData('is_available', false);
            }
        }

        
    }
    
    

}



