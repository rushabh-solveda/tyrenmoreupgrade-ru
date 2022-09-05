<?php

namespace Payment\Phonepe\Gateway\Response;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;

class TxnIdHandler implements HandlerInterface
{
    const TXN_ID = 'TXN_ID';

    /**
     * Handles transaction id
     *
     * @param array $handlingSubject
     * @param array $response
     * @return void
     */
    public function handle(array $handlingSubject, array $response)
    {


        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $logger->info('handle3->'.print_r($response[self::TXN_ID], true));

        if (!isset($handlingSubject['payment'])
            || !$handlingSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        /** @var PaymentDataObjectInterface $paymentDO */
        $paymentDO = $handlingSubject['payment'];

        $payment = $paymentDO->getPayment();
        // $logger->info('handle->'.print_r($payment->setTransactionId($response[self::TXN_ID]), true));
        /** @var $payment \Magento\Sales\Model\Order\Payment */
        $payment->setTransactionId($response[self::TXN_ID]);
        $payment->setIsTransactionClosed(false);
    }
}
