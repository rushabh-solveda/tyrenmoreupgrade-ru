<?php

namespace Payment\Phonepe\Model;

/**
 * Pay In Store payment method model
 */
class Adapter extends \Magento\Payment\Model\Method\AbstractMethod
{

public function assignData(\Magento\Framework\DataObject $data)
{
    $this->eventManager->dispatch(
        'payment_method_assign_data_' . $this->getCode(),
        [
            AbstractDataAssignObserver::METHOD_CODE => $this,
            AbstractDataAssignObserver::MODEL_CODE => $this->getInfoInstance(),
            AbstractDataAssignObserver::DATA_CODE => $data
        ]
    );

    $this->eventManager->dispatch(
        'payment_method_assign_data',
        [
            AbstractDataAssignObserver::METHOD_CODE => $this,
            AbstractDataAssignObserver::MODEL_CODE => $this->getInfoInstance(),
            AbstractDataAssignObserver::DATA_CODE => $data
        ]
    );
    return $this;
}

}