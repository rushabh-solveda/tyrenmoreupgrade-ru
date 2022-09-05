<?php

namespace Solveda\ShippingCities\Plugin\Model\Carrier;

use Exception;
use Magento\Quote\Api\ShipmentEstimationInterface;
use Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory;

class ShippingEstimation
{
    const AREA_CODE = \Magento\Framework\App\Area::AREA_ADMINHTML;

    protected $state;

    public function __construct(
        CollectionFactory $collectionFactory,
        \Magento\Framework\App\State $state
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->state = $state;
    }

    public function aroundEstimateByExtendedAddress(
        ShipmentEstimationInterface $subject,
        \Closure $proceed,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address
    ) {
        try {

            $shippingMethods = $proceed($cartId, $address);
            $data = json_decode(file_get_contents('php://input'), true);
            $cityId = null;
            if (isset($data['address']['custom_attributes'])) {
                foreach ($data['address']['custom_attributes'] as $attribute) {
                    if (isset($attribute['attribute_code']) && $attribute['attribute_code'] == 'custom_city') {
                        $cityId = $attribute['value'];
                        break;
                    }
                }
            }
        } catch (Exception $e) {
        }

        // $city = $address->getCity();

        if ($cityId) {

            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('entity_id', ['eq' => $cityId]);

            $isCodAvailable = 0;
            if ($collection->count()) {
                $city = $collection->getFirstItem();
                $isCodAvailable = $city->getDisplayInputForCity();
            }

            if($this->state->getAreaCode() != self::AREA_CODE) {
                foreach ($shippingMethods as $key => $shippingMethod) {
                    // if ($shippingMethod->getMethodCode() == 'flatrate') {
                    //     if ($isCodAvailable == 1) {
                    //         $title = 'Fees Inclusive of Doorstep Product delivery charges only. Delivery will be done by courier in a minimum of 7 working days post payment';
                    //         $shippingMethod->setCarrierTitle($title);
                    //     }
                    //     // unset($shippingMethods[$key]);
                    // }
                    // There is no reset of india so only 1 shipping method so comment below line
                    // unset($shippingMethods[0]); // remove standard custom shipping method
                    // if ($shippingMethod->getMethodCode() == 'flatrate') {
                    //     if ($isCodAvailable == 0) {
                    //         unset($shippingMethods[1]);
                    //     }
                    // }
                    
                    // if ($shippingMethod->getMethodCode() == 'RESTOFINDIA') {
                    //     if ($isCodAvailable == 1) {
                    //         unset($shippingMethods[2]);
                    //     }
                    // }
                }
            }
        }
        return $shippingMethods;
    }
}
