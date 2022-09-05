<?php

namespace Solveda\ShippingCities\ViewModel;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Solveda\ShippingCities\Model\ResourceModel\City\CollectionFactory;

class Cities implements ArgumentInterface
{
    public function __construct(
        CollectionFactory $collectionFactory,
        ProductFactory $productFactory,
        SessionManagerInterface $session
    ) {
        $this->productFactory = $productFactory;
        $this->collectionFactory = $collectionFactory;
        $this->session = $session;
    }

    public function getCities($productId = false, $doorstepDelivery = 0): array
    {
        $status = false;
        if ($productId) {
            $product = $this->productFactory->create()->load($productId);
            $categoryIds = $product->getCategoryIds();
            $category = 3404; // category id for battery
            if (in_array($category, $categoryIds)) {
                $status = true;
            }
        }
        $collection = $this->collectionFactory->create();
        if ($status) {
            $collection->addFieldToFilter('enable_for_battery', ['eq' => 1]);
        }
        if ($doorstepDelivery) {
            $collection->addFieldToFilter('city_name', ['eq' => 'Rest Of India']);
        } else {
            $collection->addFieldToFilter('city_name', ['neq' => 'Rest Of India']);
        }

        $collection->addFieldToFilter('status', ['eq' => 1]);
        $collection->setOrder('position', 'ASC');

        $options = [];

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

    public function getSelectedCity()
    {
        $city = 0;
        $this->session->start();
        if ($this->session->hasCity()) {
            $city = $this->session->getCity();
        }
        return $city;
    }
}
