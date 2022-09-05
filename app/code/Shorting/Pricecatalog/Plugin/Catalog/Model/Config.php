<?php
    namespace Shorting\Pricecatalog\Plugin\Catalog\Model;

    class Config
    {
        public function beforeGetAttributeUsedForSortByArray(
            \Magento\Catalog\Model\Config $catalogConfig,
            $options,
            $requestInfo = null
        ) {

            $options['low_to_high'] = __('Price - Low To High');
            $options['high_to_low'] = __('Price - High To Low');
            return $options;

        }

    }