<?php

namespace Payment\Phonepe\Model;

/**
 * Pay In Store payment method model
 */
class Payment extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'phonepe';

public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $paymentDO = $this->subjectReader->readPayment($buildSubject);
        $payment = $paymentDO->getPayment();
        $order = $paymentDO->getOrder();
        
        // $result = [
        //     self::AMOUNT => $this->formatPrice($this->subjectReader->readAmount($buildSubject)),
        //     self::PAYMENT_METHOD_NONCE => $payment->getAdditionalInformation(
        //         DataAssignObserver::PAYMENT_METHOD_NONCE
        //     ),
        //     self::ORDER_ID => $order->getOrderIncrementId()
        // ];
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('payment method'.print_r($order->getOrderIncrementId(), true));
        return $order;
    }

}

