<?php

namespace Solveda\ShippingCities\Plugin\Model\Method;

use Magento\Payment\Model\MethodList;

class PaymentMethodAvailable
{
    /**
     * @param \Magento\Checkout\Model\Cart
     */
    private $cart;

    /**
     * @param \Solveda\ShippingCities\Model\Cities
     */
    private $cities;

    public function __construct(
        \Magento\Checkout\Model\Cart $cart,
        \Solveda\ShippingCities\Model\CityFactory $cities
    ) {
        $this->cart = $cart;
        $this->citiesFactory = $cities;
    }

    /**
     * @param Magento\Payment\Model\MethodList $subject
     * @param $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAvailableMethods(MethodList $subject, $result)
    {
        $quote = $this->cart->getQuote();
        $cityId = $quote->getCustomCityId();
        
        $cityModel = $this->citiesFactory->create()->load($cityId);

        $payu = ['pumbolt'];

        foreach ($result as $key => $_result) {
            if ($cityModel->getCodAvailable() == 0) {
                if ($_result->getCode() == "cashondelivery") {
                    unset($result[$key]);
                }
            } else {
                if (in_array($_result->getCode(), $payu)) {
                    unset($result[$key]);
                }
            }
        }
        return $result;
    }
}
