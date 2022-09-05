<?php

namespace Payment\Phonepe\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Payment\Phonepe\Gateway\Http\Client\ClientMock;

class MockDataRequest implements BuilderInterface
{
    const FORCE_RESULT = 'FORCE_RESULT';

    /**
     * Builds ENV request
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/nitesh.log');
	    $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
       

        if (!isset($buildSubject['payment'])
            || !$buildSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        /** @var PaymentDataObjectInterface $paymentDO */
        $paymentDO = $buildSubject['payment'];
        $payment = $paymentDO->getPayment();
        $logger->info('order-request-mock->'.print_r($payment->getAdditionalInformation('transaction_result'), true));
        $transactionResult = $payment->getAdditionalInformation('transaction_result');
        return [
            self::FORCE_RESULT => $transactionResult === null
                ? ClientMock::SUCCESS
                : $transactionResult
        ];
    }
}
