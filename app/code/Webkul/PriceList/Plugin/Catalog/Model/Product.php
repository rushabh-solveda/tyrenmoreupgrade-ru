<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Plugin\Catalog\Model;

use Magento\Catalog\Model\Product as CatalogProduct;

class Product
{
    /**
     * @var \Webkul\PriceList\Helper\Data
     */
    private $_pricelistHelper;

    /**
     * Initialize dependencies.
     *
     * @param \Webkul\PriceList\Helper\Data $pricelistHelper
     */
    public function __construct(
        \Webkul\PriceList\Helper\Data $pricelistHelper
    ) {
        $this->_pricelistHelper = $pricelistHelper;
    }

    public function afterGetPrice(CatalogProduct $subject, $result)
    {
        if ($this->_pricelistHelper->isModuleEnable()) {
            $price = $this->_pricelistHelper->getPrice($subject, $result);
            return $price;
        }
        return $result;
    }
}
