<?php

namespace Solveda\ShippingCities\Plugin\Checkout\LayoutProcessor;

use Magento\Framework\Stdlib\ArrayManager;
use Solveda\ShippingCities\Model\CityFactory;
use Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory;

class Cities
{
    protected $arrayManager;

    /**
     * @param \Solveda\ShippingCities\Model\Cities
     */
    private $cities;

    /**
     * @param \Magento\Checkout\Model\Cart
     */
    private $cart;

    /**
     * @param \Magento\Catalog\Model\ProductFactory
     */
    private $productFactory;

    /**
     * @param \Magento\Framework\Stdlib\CookieManagerInterface
     */
    private $cookieManager;

    public function __construct(
        ArrayManager $arrayManager,
        CityFactory $cities,
        CollectionFactory $collectionFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    ) {
        $this->arrayManager = $arrayManager;
        $this->citiesFactory = $cities;
        $this->collectionFactory = $collectionFactory;
        $this->cart = $cart;
        $this->productFactory = $productFactory;
        $this->cookieManager = $cookieManager;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        $checkoutCityFieldPath = $this->arrayManager->findPath(
            'city',
            $jsLayout
        ) . '/label';

        $updatedJsLayout = $this->arrayManager->set(
            $checkoutCityFieldPath,
            $jsLayout,
            'Enter your city'
        );

        $customCityValue = $this->getCustomCityCookie();
        $checkoutCustomCityFieldPath = $this->arrayManager->findPath(
            'custom_city',
            $updatedJsLayout
        ) . '/value';

        $updatedJsLayout = $this->arrayManager->set(
            $checkoutCustomCityFieldPath,
            $updatedJsLayout,
            $customCityValue
        );

        $checkoutCustomCityFieldOptionsPath = $this->arrayManager->findPath(
            'custom_city',
            $updatedJsLayout
        ) . '/options';

        $cityOptions = $this->arrayManager->set(
            $checkoutCustomCityFieldOptionsPath,
            $updatedJsLayout,
            $this->getCustomOptions()
        );
        return $cityOptions;
    }

    protected function getCustomOptions(): array
    {
        //$cities =  $this->citiesFactory->create()->getCollection();
        $status = false;
        foreach ($this->cart->getItems() as $item) {
            $productId = $item->getProductId();
            $product = $this->productFactory->create()->load($productId);
            $categoryIds = $product->getCategoryIds();
            $category = 3404; // category id for battery
            if (in_array($category, $categoryIds)) {
                $status = true;
                break;
            }
        }

        $collection = $this->collectionFactory->create();
        if ($status) {
            $collection->addFieldToFilter('enable_for_battery', ['eq' => 1]);
        }
        $collection->addFieldToFilter('status', ['eq' => 1]);
        $collection->setOrder('position', 'ASC');

        $options[] = [
            'value' => '',
            'label' => "Please select a city"
        ];

        if ($collection->count()) {
            foreach ($collection as $city) {
                $options[] = [
                    'value' => $city->getEntityId(),
                    'label' => $city->getCityName(),
                    'status' => $city->getStatus(),
                    'cod_available' => $city->getCodAvailable(),
                    'display_input_for_city' => $city->getDisplayInputForCity(),
                ];
            }
        }
        return $options;
    }

    protected function getCustomCityCookie()
    {
        return $this->cookieManager->getCookie(
            'selected_city'
        );
    }
}
