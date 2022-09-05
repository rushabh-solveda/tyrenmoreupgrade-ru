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
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\AddressRepositoryInterface;

class BackendSaveGstToOrder implements ObserverInterface
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
    protected $addressRepository;

    public function __construct(
        QuoteRepository $quoteRepository,
        CustomerFactory $customerFactory,
        Data $helper,
        ProductFactory $productFactory,
        OrderFactory $orderFactory,
        CategoryRepositoryInterface $categoryRepository,
        StoreManagerInterface $storeManager,
        QuoteFactory $quoteFactory,
        OrderSender $orderSender,
        Session $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        ResourceConfig $resourceConfig,
        AddressRepositoryInterface $addressRepository,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    ) {
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
        $this->addressRepository = $addressRepository;
    }

    public function execute(EventObserver $observer)
    {
        $countryCodes = 1;
        $order = $observer->getOrder();
        $shippingAddress = $order->getShippingAddress();

        if ($shippingAddress->getCountryId() == "IN") {
            $isUnionTarritotial = $this->helper->getCheckUnionTerritory($shippingAddress->getRegion());
            $totals = 0;
            $quoteId = $order->getQuoteId();
            $quote = $this->quoteFactory->create()->load($quoteId);
            $excludingGst = $quote->getGstExclusive();
            $orderItems = $order->getAllItems();
            foreach ($orderItems as $item) {
                if ($item->getQuoteItemId()) {
                    $product = $this->productFactory->create()->load($item->getData('product_id'));
                    $categoryIds = $product->getCategoryIds();
                    $productPriceAfterDiscount = ($product->getFinalPrice() * $product->getDiscountPercent()) / 100;

                    if (trim($item->getData('product_type')) === 'configurable') {
                        $productPrice = $tmep = $item->getRowTotal() - $item->getDiscountAmount();
                    } else {
                        $productPrice = $tmep = $item->getRowTotal() - $productPriceAfterDiscount;
                    }
                    $flag = false;
                    if (count($categoryIds) > 0) {
                        foreach ($categoryIds as $categoryId) {
                            $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                            $catGstRate = $category->getCatGstRate();
                            $gstRateMinAmount = $category->getCatMinGstAmount();
                            $gstMinRate = $category->getCatMinGstRate();
                            if ($catGstRate) {
                                if ($category->getCatGstRate()) {
                                    $flag = true;
                                }
                                break;
                            }
                        }
                    }
                    if ($product->getGstRate()) {
                        $gstRate = $product->getGstRate();
                        $gstMinimumPrice = $product->getMinGstAmount();
                        if ($gstMinimumPrice > $productPrice) {
                            $gstRate = $product->getMinGstRate();
                        }
                        if ($this->helper->isCatalogExclusiveGst()) {
                            $gstAmount = ((($productPrice) * $gstRate) / 100);
                        } else {
                            $gstPercent = 100 + $gstRate;
                            $productPrice = ($productPrice) / $gstPercent;
                            $gstAmount = $productPrice * $gstRate;
                        }

                        //$sub = $item->getData('qty_ordered') * $gstAmount;
                        $sub = $gstAmount;
                        if ($this->helper->canApplyTax('DIFF')) {
                            $item->setIgstAmount($sub);
                            $item->setBaseIgstAmount($sub);
                            $item->setIgstPercent($gstRate);
                        } else {
                            $item->setCgstAmount($sub / 2);
                            $item->setBaseCgstAmount($sub / 2);
                            $item->setCgstPercent($gstRate / 2);
                            if($isUnionTarritotial){
                                $item->setUtgstAmount($sub / 2);
                                $item->setBaseUtgstAmount($sub / 2);
                                $item->setUtgstPercent($gstRate / 2);
                            }else{
                                $item->setSgstAmount($sub / 2);
                                $item->setBaseSgstAmount($sub / 2);
                                $item->setSgstPercent($gstRate / 2);
                            }
                        }
                        $totals = $totals + $sub;
                    } elseif ($flag) {
                        if ($gstRateMinAmount > $productPrice) {
                            $catGstRate = $gstMinRate;
                        }
                        if ($this->helper->isCatalogExclusiveGst()) {
                            $gstAmount = ((($productPrice) * $catGstRate) / 100);
                        } else {
                            $gstPercent = 100 + $catGstRate;
                            $productPrice = ($productPrice) / $gstPercent;
                            $gstAmount = $productPrice * $catGstRate;
                        }

                        $sub = $item->getData('qty_ordered') * $gstAmount;
                        $sub = $gstAmount;
                        if ($this->helper->canApplyTax('DIFF')) {
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
                        if ($this->helper->getMinAmount() > $productPrice) {
                            $rate = $this->helper->getMinRate();
                        }
                        if ($this->helper->isCatalogExclusiveGst()) {
                            $gstAmount = ((($productPrice) * $rate) / 100);
                        } else {
                            $gstPercent = 100 + $rate;
                            $productPrice = ($productPrice) / $gstPercent;
                            $gstAmount = $productPrice * $rate;
                        }
                        $sub = $item->getData('qty_ordered') * $gstAmount;
                        $sub = $gstAmount;
                        if ($this->helper->canApplyTax('DIFF')) {
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
            if ($this->helper->isEnabled()) {
                if ($this->helper->canApplyTax('DIFF')) {
                    $order->setIgstAmount($quote->getIgstAmount());
                    $order->setBaseIgstAmount($quote->getBaseIgstAmount());
                } else {
                    $order->setCgstAmount($quote->getCgstAmount());
                    $order->setBaseCgstAmount($quote->getBaseCgstAmount());
                    if($isUnionTarritotial){
                        $order->setUtgstAmount($quote->getUtgstAmount());
                        $order->setBaseUtgstAmount($quote->getBaseUtgstAmount());
                    }else{
                        $order->setSgstAmount($quote->getSgstAmount());
                        $order->setBaseSgstAmount($quote->getBaseSgstAmount());
                    }
                }
                try {
                    $order->save();
                } catch (LocalizedException $e) {
                    return $e->getMessage();
                }
            }
            if ($this->helper->isShippingGst()) {
                if ($this->helper->canApplyShipping('SSAME')) {
                    $order->setShippingCgstAmount($quote->getShippingCgstAmount());
                    $order->setBaseShippingCgstAmount($quote->getBaseShippingCgstAmount());
                    if($isUnionTarritotial) {
                        $order->setShippingUtgstAmount($quote->getShippingUtgstAmount());
                        $order->setBaseShippingUtgstAmount($quote->getBaseShippingUtgstAmount());
                    }else{
                        $order->setShippingSgstAmount($quote->getShippingSgstAmount());
                        $order->setBaseShippingSgstAmount($quote->getBaseShippingSgstAmount());
                    }
                } else {
                    $order->setShippingIgstAmount($quote->getShippingIgstAmount());
                    $order->setBaseShippingIgstAmount($quote->getBaseShippingIgstAmount());
                }
                $order->save();
            }/**/
            $quoteRepository = $this->quoteRepository;
            $quote = $quoteRepository->get($order->getQuoteId());
            $customer = $this->customerFactory->create()->load($quote->getCustomer()->getId());
            if (!empty($customer->getId())) {
                $addressId = $quote->getShippingAddress()->getCustomerAddressId();
                if ($addressId != 0) {
                    $addressObject = $this->addressRepository->getById($addressId);
                    $buyerGst = $addressObject->getCustomAttribute('buyer_gst_number');
                    if (empty($buyerGst)) {
                        $quote = $quoteRepository->get($order->getQuoteId());
                        $buyerGst = $quote->getBuyerGstNumber();
                    } else {
                        $buyerGst = $addressObject->getCustomAttribute('buyer_gst_number')->getValue();
                    }
                } else {
                    $buyerGst = $quote->getShippingAddress()->getBuyerGstNumber();
                }

            } else {
                $quote = $quoteRepository->get($order->getQuoteId());
                $buyerGst = $quote->getShippingAddress()->getBuyerGstNumber();
            }
            $order->setBuyerGstNumber($buyerGst);
            $billingAddress = $order->getBillingAddress();
            $shippingAddress->setBuyerGstNumber($buyerGst);
            $billingAddress->setBuyerGstNumber($buyerGst);
        }
        return $this;
    }
}