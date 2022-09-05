<?php

namespace Meetanshi\IndianGst\Observer;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Checkout\Model\Session;
use Magento\Config\Model\ResourceModel\Config as ResourceConfig;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Meetanshi\IndianGst\Helper\Data;

class AddGstToPaypal implements ObserverInterface
{
    protected $quoteRepository;
    protected $customerFactory;
    protected $helper;
    protected $productFactory;
    protected $orderFactory;
    protected $categoryRepository;
    protected $storeManager;
    protected $quoteFactory;
    protected $orderSender;
    protected $checkoutSession;
    protected $scopeConfig;
    protected $resourceConfig;
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    public function __construct(QuoteRepository $quoteRepository, CustomerFactory $customerFactory, Data $helper,
                                ProductFactory $productFactory,
                                OrderFactory $orderFactory,
                                CategoryRepositoryInterface $categoryRepository,
                                StoreManagerInterface $storeManager,
                                QuoteFactory $quoteFactory,
                                OrderSender $orderSender,
                                Session $checkoutSession,
                                ScopeConfigInterface $scopeConfig,
                                ResourceConfig $resourceConfig,
                                \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
                                \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool)
    {
        $this->customerFactory = $customerFactory;
        $this->quoteRepository = $quoteRepository;
        $this->helper = $helper;
        $this->productFactory = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->categoryRepository = $categoryRepository;
        $this->storeManager = $storeManager;
        $this->quoteFactory = $quoteFactory;
        $this->orderSender = $orderSender;
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
        $this->resourceConfig = $resourceConfig;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    public function execute(EventObserver $observer)
    {
        try {

            $totals = 0;
            $quote = $this->checkoutSession->getQuote();
            $quoteId = $quote->getEntityId();
            $quote = $this->quoteFactory->create()->load($quoteId);
            $quotedItems = $quote->getAllVisibleItems();
            $excludingGst = $this->helper->isCatalogExclusiveGst();

            $cart = $observer->getEvent()->getCart();
            $shippingAddress = $quote->getShippingAddress();

            if ($shippingAddress->getCountryId() == "IN") {
                $isUnionTarritotial = $this->helper->getCheckUnionTerritory($shippingAddress->getRegion());
                foreach ($quotedItems as $item) {
                    if ( $item->getQuoteItemId() ) {
                        $product = $this->productFactory->create()->load($item->getData('product_id'));
                        $categoryIds = $product->getCategoryIds();
                        $productPriceAfterDiscount = ($product->getFinalPrice() * $product->getDiscountPercent()) / 100;
                        $productPrice = $product->getFinalPrice() - $productPriceAfterDiscount;
                        $flag = false;
                        if ( count($categoryIds) > 0 ) {
                            foreach ($categoryIds as $categoryId) {
                                $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                                $catGstRate = $category->getCatGstRate();
                                $gstRateMinAmount = $category->getCatMinGstAmount();
                                $gstMinRate = $category->getCatMinGstRate();
                                if ( $catGstRate ) {
                                    if ( $category->getCatGstRate() ) {
                                        $flag = true;
                                    }
                                    break;
                                }
                            }
                        }
                        if ( $product->getGstRate() ) {
                            $gstRate = $product->getGstRate();
                            $gstMinimumPrice = $product->getMinGstAmount();
                            if ( $gstMinimumPrice > $productPrice ) {
                                $gstRate = $product->getMinGstRate();
                            }
                            if ( $this->helper->isCatalogExclusiveGst() ) {
                                $gstAmount = ((($productPrice) * $gstRate) / 100);
                            } else {

                                $gstPercent = 100 + $gstRate;
                                $productPrice = ($productPrice) / $gstPercent;
                                $gstAmount = $productPrice * $gstRate;
                            }
                            $sub = $item->getData('qty_ordered') * $gstAmount;
                            if ( $this->helper->canApplyTax('DIFF') ) {
                                $item->setIgstAmount($sub);
                                $item->setBaseIgstAmount($sub);
                                $item->setIgstPercent($gstRate);
                            } else {
                                $item->setCgstAmount($sub / 2);
                                $item->setBaseCgstAmount($sub / 2);
                                $item->setCgstPercent($gstRate / 2);
                                if ( $isUnionTarritotial ) {
                                    $item->setUtgstAmount($sub / 2);
                                    $item->setBaseUtgstAmount($sub / 2);
                                    $item->setUtgstPercent($gstRate / 2);
                                } else {
                                    $item->setSgstAmount($sub / 2);
                                    $item->setBaseSgstAmount($sub / 2);
                                    $item->setSgstPercent($gstRate / 2);
                                }
                            }
                            $totals = $totals + $sub;
                        } elseif ( $flag ) {
                            if ( $gstRateMinAmount > $productPrice ) {
                                $catGstRate = $gstMinRate;
                            }
                            if ( $this->helper->isCatalogExclusiveGst() ) {
                                $gstAmount = ((($productPrice) * $catGstRate) / 100);
                            } else {

                                $gstPercent = 100 + $catGstRate;
                                $productPrice = ($productPrice) / $gstPercent;
                                $gstAmount = $productPrice * $catGstRate;
                            }
                            $sub = $item->getData('qty_ordered') * $gstAmount;
                            if ( $this->helper->canApplyTax('DIFF') ) {
                                $item->setIgstAmount($sub);
                                $item->setBaseIgstAmount($sub);
                                $item->setIgstPercent($catGstRate);
                            } else {
                                $item->setCgstAmount($sub / 2);
                                $item->setBaseCgstAmount($sub / 2);
                                $item->setCgstPercent($catGstRate / 2);
                                if($isUnionTarritotial){
                                    $item->setUtgstAmount($sub / 2);
                                    $item->setBaseUtgstAmount($sub / 2);
                                    $item->setUtgstPercent($catGstRate / 2);
                                }else{
                                    $item->setSgstAmount($sub / 2);
                                    $item->setBaseSgstAmount($sub / 2);
                                    $item->setSgstPercent($catGstRate / 2);
                                }
                            }
                            $totals = $totals + $sub;
                        } else {
                            $rate = $this->helper->getRate();
                            if ( $this->helper->getMinAmount() > $productPrice ) {
                                $rate = $this->helper->getMinRate();
                            }
                            if ( $this->helper->isCatalogExclusiveGst() ) {
                                $gstAmount = ((($productPrice) * $rate) / 100);
                            } else {

                                $gstPercent = 100 + $rate;
                                $productPrice = ($productPrice) / $gstPercent;
                                $gstAmount = $productPrice * $rate;
                            }
                            $sub = $item->getData('qty_ordered') * $gstAmount;
                            if ( $this->helper->canApplyTax('DIFF') ) {
                                $item->setIgstAmount($sub);
                                $item->setBaseIgstAmount($sub);
                                $item->setIgstPercent($rate);
                            } else {
                                $item->setCgstAmount($sub / 2);
                                $item->setBaseCgstAmount($sub / 2);
                                $item->setCgstPercent($rate / 2);
                                if($isUnionTarritotial){
                                    $item->setUtgstAmount($sub / 2);
                                    $item->setBaseUtgstAmount($sub / 2);
                                    $item->setUtgstPercent($rate / 2);
                                }else{
                                    $item->setSgstAmount($sub / 2);
                                    $item->setBaseSgstAmount($sub / 2);
                                    $item->setSgstPercent($rate / 2);
                                }
                            }
                            $totals = $totals + ($sub / 2);
                        }
                        $item->setGstExclusive($excludingGst);
                    }
                }
                if ( $excludingGst ) {
                    if ( $this->helper->canApplyTax('DIFF') ) {
                        $cart->addCustomItem('IGST', 1, $quote->getIgstAmount());
                    } else {
                        $cart->addCustomItem('CGST', 1, $quote->getCgstAmount());
                        $cart->addCustomItem('UTGST', 1, $quote->getUtgstAmount());
                        $cart->addCustomItem('SGST', 1, $quote->getSgstAmount());
                    }
                }
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $this;
    }
}
