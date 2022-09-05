<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_PriceList
 * @author Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */

namespace Webkul\PriceList\Observer;

use Magento\Framework\Event\ObserverInterface;

class CartSaveAfter implements ObserverInterface
{

   /**

    * @param \Magento\Framework\App\Request\Http $request
    * @param \Magento\Checkout\Model\Session $checkoutSession
    * @param \Webkul\PriceList\Helper\Data $helper
    * @param \Magento\Framework\Module\Manager $moduleManager
    */
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Webkul\PriceList\Helper\Data $helper,
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->_helper = $helper;
        $this->request = $request;
        $this->checkoutSession = $checkoutSession;
        $this->moduleManager = $moduleManager;
    }

    /**
     * Cart save after observer.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_helper->isModuleEnable()) {
            $quote = $this->checkoutSession->getQuote();
            $status = false;
            if (($this->moduleManager->isOutputEnabled('Webkul_Walletsystem'))
                && count($quote->getAllItems()) == 1 ) {
                foreach ($quote->getAllItems() as $item) {
                    if ($item->getProduct()->getSku() ==\Webkul\Walletsystem\Helper\Data::WALLET_PRODUCT_SKU) {
                        $status = true;
                        break;
                    }
                }
            } elseif ($this->moduleManager->isOutputEnabled('Webkul_Auction')
            && count($quote->getAllItems()) == 1) {
                foreach ($quote->getAllItems() as $item) {
                    if ($item->getProduct()->getSku() == \Webkul\Auction\Helper\Data::AUCTION_PRODUCT_SKU) {
                        $status = true;
                        break;
                    } elseif ($this->moduleManager->isOutputEnabled('Webkul_Auction')
                    && $item->getProduct()->getAuctionType() == 2
                    || $item->getOriginalCustomPrice()!= null) {
                        if ($this->getAuctionProduct($item->getProduct()) != null) {
                            $status = true;
                            break;
                        }
                    }
                }
            }
            if (!$status) {
                $this->_helper->collectTotals($quote);
            }
        }
        $this->checkoutSession->getQuote()->save();
    }

    protected function getAuctionProduct($product)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $auctionHelper = $objectManager->get(\Webkul\Auction\Helper\Data::class);
        return $auctionHelper->getActiveAuctionId($product->getEntityId());
    }
}
