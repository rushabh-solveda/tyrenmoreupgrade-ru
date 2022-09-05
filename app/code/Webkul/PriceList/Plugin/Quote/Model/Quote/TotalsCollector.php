<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Plugin\Quote\Model\Quote;

use Magento\Quote\Model\Quote\TotalsCollector as Collector;

class TotalsCollector
{
    /**
     * @var \Webkul\PriceList\Helper\Data
     */
    private $_helper;

    /**
     * Initialize dependencies.
     *
     * @param \Webkul\PriceList\Helper\Data $helper
     */
    public function __construct(
        \Webkul\PriceList\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

    public function aroundCollect(
        Collector $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote $quote
    ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $state =  $objectManager->get('Magento\Framework\App\State');
        if ($state->getAreaCode() == 'frontend') {
            $this->_helper->collectTotals($quote);
        }
        $result = $proceed($quote);
        return $result;
    }
}
