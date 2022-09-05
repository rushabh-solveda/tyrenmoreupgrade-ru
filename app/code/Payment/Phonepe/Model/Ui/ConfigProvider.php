<?php

namespace Payment\Phonepe\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Payment\Phonepe\Gateway\Http\Client\ClientMock;

/**
 * Class ConfigProvider
 */
final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'phonepe';

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'payment' => [
                self::CODE => [
                    'transactionResults' => [
                        ClientMock::SUCCESS => __('Success'),
                        ClientMock::FAILURE => __('Fraud')
                    ]
                ]
            ]
        ];
    }
}