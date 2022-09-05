<?php

namespace Meetanshi\IndianGst\Helper;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\QuoteFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Session\SessionManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const COOKIE_DURATION = 250;
    protected $cookie;
    protected $checkoutSession;
    protected $productFactory;
    protected $categoryRepository;
    protected $storeManager;
    protected $coreSession;
    protected $productRepository;
    protected $quoteFactory;
    protected $cart;
    protected $cookieMetadataFactory;
    protected $sessionManager;

    public function __construct(
        Context $context,
        CookieManagerInterface $cookieManager,
        CheckoutSession $checkoutSession,
        ProductFactory $productFactory,
        CategoryRepositoryInterface $categoryRepository,
        StoreManagerInterface $storeManager,
        SessionManagerInterface $coreSession,
        ProductRepositoryInterface $productRepository,
        QuoteFactory $quoteFactory,
        Cart $cart,
        CookieMetadataFactory $cookieMetadataFactory,
        SessionManagerInterface $sessionManager
    )
    {
        parent::__construct($context);
        $this->sessionManager = $sessionManager;
        $this->checkoutSession = $checkoutSession;
        $this->cookie = $cookieManager;
        $this->productFactory = $productFactory;
        $this->categoryRepository = $categoryRepository;
        $this->storeManager = $storeManager;
        $this->coreSession = $coreSession;
        $this->productRepository = $productRepository;
        $this->quoteFactory = $quoteFactory;
        $this->cart = $cart;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
    }

    public function getCookieMetaData()
    {
        return $this->cookieMetadataFactory;
    }

    public function getSessionManager()
    {
        return $this->getSessionManager();
    }

    public function getOrigin()
    {
        return $this->scopeConfig->getValue('indiangst/general/origin', ScopeInterface::SCOPE_STORE);
    }

    public function canApplyTax($code)
    {
        if (!$this->getConfig('indiangst/general/enable')) {
            return false;
        }

        if (\Magento\Framework\App\Area::AREA_ADMINHTML) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();

            $isDisplay = $om->get(
                'Magento\Customer\Model\Session'
            )->getIsSame();
            if ($isDisplay == $code) {
                return true;
            }
        } else {
            $isDisplay = $this->getCookie()->getCookie('isSame');
            if ($isDisplay == $code) {
                return true;
            }
        }

        return false;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue($config_path, ScopeInterface::SCOPE_STORE);
    }

    public function getCookie()
    {
        return $this->cookie;
    }

    public function canApplyShipping($code)
    {
        if (!$this->getConfig('indiangst/general/enable')) {
            return false;
        }

        if (!$this->isShippingGst()) {
            return false;
        }

        if (\Magento\Framework\App\Area::AREA_ADMINHTML) {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            $isDisplay = $om->get(
                'Magento\Customer\Model\Session'
            )->getIsSSame();

            if ($isDisplay == $code) {
                return true;
            }
        } else {
            $isDisplay = $this->getCookie()->getCookie('isSSame');
            if ($isDisplay == $code) {
                return true;
            }
        }
        return false;
    }

    public function isShippingGst()
    {
        return $this->scopeConfig->getValue('indiangst/shipping/enabled', ScopeInterface::SCOPE_STORE);
    }

    public function getSignature()
    {
        return $this->scopeConfig->getValue('indiangst/general/signature', ScopeInterface::SCOPE_STORE);
    }

    public function getSignatureText()
    {
        return $this->scopeConfig->getValue('indiangst/general/signaturetext', ScopeInterface::SCOPE_STORE);
    }

    public function getGstNumber()
    {
        return $this->scopeConfig->getValue('indiangst/general/gstin', ScopeInterface::SCOPE_STORE);
    }

    public function getPanNumber()
    {
        return $this->scopeConfig->getValue('indiangst/general/pan', ScopeInterface::SCOPE_STORE);
    }

    public function getCinNumber()
    {
        return $this->scopeConfig->getValue('indiangst/general/cin', ScopeInterface::SCOPE_STORE);
    }

    public function isEnabled()
    {
        return $this->scopeConfig->getValue('indiangst/general/enable', ScopeInterface::SCOPE_STORE);
    }

    public function getBuyerGst()
    {
        return $this->scopeConfig->getValue('indiangst/general/buyer_gst', ScopeInterface::SCOPE_STORE);
    }
    public function isCatalogExclusiveGst()
    {
        return $this->scopeConfig->getValue('indiangst/general/taxclass', ScopeInterface::SCOPE_STORE);
    }

    public function getRate()
    {
        return $this->scopeConfig->getValue('indiangst/general/gst_rate', ScopeInterface::SCOPE_STORE);
    }

    public function getMinAmount()
    {
        return $this->scopeConfig->getValue('indiangst/general/min_amount', ScopeInterface::SCOPE_STORE);
    }

    public function getMinRate()
    {
        return $this->scopeConfig->getValue('indiangst/general/min_gst_rate', ScopeInterface::SCOPE_STORE);
    }

    public function getShippingGstClass()
    {
        return $this->scopeConfig->getValue('indiangst/shipping/taxclass', ScopeInterface::SCOPE_STORE);
    }
    public function getCheckUnionTerritory($region){
        $unionTerritories = array(
            'Delhi',
            'Chandigarh',
            'Daman and Diu',
            'Dadra and Nagar Haveli',
            'Pondicherry',
            'Andaman and Nicobar Islands',
            'Lakshadweep'
        );
        if(in_array($region,$unionTerritories)){
            return true;
        }
        return false;
    }

    public function calculateCgst($quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $total = 0;
        $quote->setGstExclusive($this->isCatalogExclusiveGst());
        $quote->save();

        $shippingGstRate = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                if ($product->getTypeId() == 'configurable') {
                    $product = $this->productRepository->get($item->getSku());
                    $productPrice = $product->getFinalPrice();
                } else {
                    $productPrice = $product->getFinalPrice();
                }
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($productPrice * $product->getDiscountPercent()) / 100;
                $productPrice = $productPrice - $productPriceAfterDiscount;
                $flag = false;
                // if (count($categoryIds) > 0) {
                //     foreach ($categoryIds as $categoryId) {
                //         $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                //         $shippingGstRate = $category->getCatGstRate();
                //         $gstRateMinAmount = $category->getCatMinGstAmount();
                //         $gstMinRate = $category->getCatMinGstRate();
                //         if ($shippingGstRate) {
                //             $gstMinRate = $category->getCatMinGstRate();
                //             if ($category->getCatGstRate()) {
                //                 $flag = true;
                //             }
                //             break;
                //         }
                //     }
                // }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
                $rowTotal = $item->getRowTotal();
                $discountAmount = $item->getDiscountAmount();

                if ($this->isCatalogExclusiveGst()) {
                    $gstAmount = ((($rowTotal - $discountAmount) * $shippingGstRate) / 100);
                } else {
                    $gstPercent = 100 + $shippingGstRate;
                    $productPrice = ($rowTotal - $discountAmount) / $gstPercent;
                    $gstAmount = $productPrice * $shippingGstRate;
                }

                $total = $total + $gstAmount;
            }
        }
        return $total / 2;
    }

    public function calculateUtgst($quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $total = 0;

        $quote->setGstExclusive($this->isCatalogExclusiveGst());
        $quote->save();

        $shippingGstRate = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                if ($product->getTypeId() == 'configurable') {
                    $product = $this->productRepository->get($item->getSku());
                    $productPrice = $product->getFinalPrice();
                } else {
                    $productPrice = $product->getGstRategetFinalPrice();
                }
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($productPrice * $product->getDiscountPercent()) / 100;
                $productPrice = $productPrice - $productPriceAfterDiscount;
                $flag = false;
                // if (count($categoryIds) > 0) {
                //     foreach ($categoryIds as $categoryId) {
                //         $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                //         $shippingGstRate = $category->getCatGstRate();
                //         $gstRateMinAmount = $category->getCatMinGstAmount();
                //         $gstMinRate = $category->getCatMinGstRate();
                //         if ($shippingGstRate) {
                //             $gstMinRate = $category->getCatMinGstRate();
                //             if ($category->getCatGstRate()) {
                //                 $flag = true;
                //             }
                //             break;
                //         }
                //     }
                // }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
                $rowTotal = $item->getRowTotal();
                $discountAmount = $item->getDiscountAmount();

                if ($this->isCatalogExclusiveGst()) {
                    $gstAmount = ((($rowTotal - $discountAmount) * $shippingGstRate) / 100);
                } else {
                    $gstPercent = 100 + $shippingGstRate;
                    $productPrice = ($rowTotal - $discountAmount) / $gstPercent;
                    $gstAmount = $productPrice * $shippingGstRate;
                }

                $total = $total + $gstAmount;
            }
        }
        return $total / 2;
    }



    public function calculateSgst($quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $total = 0;

        $quote->setGstExclusive($this->isCatalogExclusiveGst());
        $quote->save();

        $shippingGstRate = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                if ($product->getTypeId() == 'configurable') {
                    $product = $this->productRepository->get($item->getSku());
                    $productPrice = $product->getFinalPrice();
                } else {
                    $productPrice = $product->getFinalPrice();
                }
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($productPrice * $product->getDiscountPercent()) / 100;
                $productPrice = $productPrice - $productPriceAfterDiscount;
                $flag = false;
                // if (count($categoryIds) > 0) {
                //     foreach ($categoryIds as $categoryId) {
                //         $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                //         $shippingGstRate = $category->getCatGstRate();
                //         $gstRateMinAmount = $category->getCatMinGstAmount();
                //         $gstMinRate = $category->getCatMinGstRate();
                //         if ($shippingGstRate) {
                //             $gstMinRate = $category->getCatMinGstRate();
                //             if ($category->getCatGstRate()) {
                //                 $flag = true;
                //             }
                //             break;
                //         }
                //     }
                // }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
                $rowTotal = $item->getRowTotal();
                $discountAmount = $item->getDiscountAmount();

                if ($this->isCatalogExclusiveGst()) {
                    $gstAmount = ((($rowTotal - $discountAmount) * $shippingGstRate) / 100);
                } else {
                    $gstPercent = 100 + $shippingGstRate;
                    $productPrice = ($rowTotal - $discountAmount) / $gstPercent;
                    $gstAmount = $productPrice * $shippingGstRate;
                }

                $total = $total + $gstAmount;
            }
        }
        return $total / 2;
    }

    public function calculateIgst($quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $total = 0;

        $quote->setGstExclusive($this->isCatalogExclusiveGst());
        //$quote->save();

        $shippingGstRate = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                if ($product->getTypeId() == 'configurable') {
                    $product = $this->productRepository->get($item->getSku());
                    $productPrice = $product->getFinalPrice();
                } else {
                    $productPrice = $product->getFinalPrice();
                }
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($productPrice * $product->getDiscountPercent()) / 100;
                $productPrice = $productPrice - $productPriceAfterDiscount;
                $flag = false;
                // if (count($categoryIds) > 0) {
                //     foreach ($categoryIds as $categoryId) {
                //         $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                //         $shippingGstRate = $category->getCatGstRate();
                //         $gstRateMinAmount = $category->getCatMinGstAmount();
                //         if ($shippingGstRate) {
                //             $gstMinRate = $category->getCatMinGstRate();
                //             if ($category->getCatGstRate()) {
                //                 $flag = true;
                //             }
                //             break;
                //         }
                //     }
                // }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }

                $rowTotal = $item->getRowTotal();
                $discountAmount = $item->getDiscountAmount();

                if ($this->isCatalogExclusiveGst()) {
                    $gstAmount = ((($rowTotal - $discountAmount) * $shippingGstRate) / 100);
                } else {
                    $gstPercent = 100 + $shippingGstRate;
                    $productPrice = ($rowTotal - $discountAmount) / $gstPercent;
                    $gstAmount = $productPrice * $shippingGstRate;
                }

                $total = $total + $gstAmount;
            }
        }
        return $total;
    }

    public function calculateCgstSgstShipping($shippingAmount, $quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $maxShippingPercent = $shippingGstRate = 0;
        $shippingGst = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($product->getFinalPrice() * $product->getDiscountPercent()) / 100;
                $productPrice = $product->getFinalPrice() - $productPriceAfterDiscount;
                $flag = false;
                if (count($categoryIds) > 0) {
                    foreach ($categoryIds as $categoryId) {
                        $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                        $shippingGstRate = $category->getCatGstRate();
                        $gstRateMinAmount = $category->getCatMinGstAmount();
                        $gstMinRate = $category->getCatMinGstRate();
                        if ($shippingGstRate) {
                            $gstMinRate = $category->getCatMinGstRate();
                            if ($category->getCatGstRate()) {
                                $flag = true;
                            }
                            break;
                        }
                    }
                }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
            }
            if ($shippingGstRate > $maxShippingPercent) {
                $maxShippingPercent = $shippingGstRate;
            }

            if ($this->getShippingGstClass()) :
                $shippingGst = $shippingAmount * ($maxShippingPercent / 100);
            else :
                $shippingGstTotal = 100 + $maxShippingPercent;//108
                $shippingGstPeracent = $shippingAmount / $shippingGstTotal; //5/108
                $shippingGst = $shippingGstPeracent * $maxShippingPercent;
            endif;
        }
        return $shippingGst / 2;
    }

    public function calculateCgstUtgstShipping($shippingAmount, $quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $maxShippingPercent = $shippingGstRate = 0;
        $shippingGst = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($product->getFinalPrice() * $product->getDiscountPercent()) / 100;
                $productPrice = $product->getFinalPrice() - $productPriceAfterDiscount;
                $flag = false;
                if (count($categoryIds) > 0) {
                    foreach ($categoryIds as $categoryId) {
                        $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                        $shippingGstRate = $category->getCatGstRate();
                        $gstRateMinAmount = $category->getCatMinGstAmount();
                        $gstMinRate = $category->getCatMinGstRate();
                        if ($shippingGstRate) {
                            $gstMinRate = $category->getCatMinGstRate();
                            if ($category->getCatGstRate()) {
                                $flag = true;
                            }
                            break;
                        }
                    }
                }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
            }
            if ($shippingGstRate > $maxShippingPercent) {
                $maxShippingPercent = $shippingGstRate;
            }

            if ($this->getShippingGstClass()) :
                $shippingGst = $shippingAmount * ($maxShippingPercent / 100);
            else :
                $shippingGstTotal = 100 + $maxShippingPercent;//108
                $shippingGstPeracent = $shippingAmount / $shippingGstTotal; //5/108
                $shippingGst = $shippingGstPeracent * $maxShippingPercent;
            endif;
        }
        return $shippingGst / 2;
    }


    public function calculateIgstShipping($shippingAmount, $quoteId = null)
    {
        $quote = $this->quoteFactory->create()->load($quoteId);
        $items = $quote->getAllVisibleItems();
        $maxShippingPercent = $shippingGstRate = 0;
        $shippingGst = 0;

        foreach ($items as $item) {
            if ($item->getId()) {
                $product = $this->productFactory->create()->load($item->getProductId());
                $categoryIds = $product->getCategoryIds();
                $productPriceAfterDiscount = ($product->getFinalPrice() * $product->getDiscountPercent()) / 100;
                $productPrice = $product->getFinalPrice() - $productPriceAfterDiscount;
                $flag = false;
                if (count($categoryIds) > 0) {
                    foreach ($categoryIds as $categoryId) {
                        $category = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId());
                        $shippingGstRate = $category->getCatGstRate();
                        $gstRateMinAmount = $category->getCatMinGstAmount();
                        $gstMinRate = $category->getCatMinGstRate();
                        if ($shippingGstRate) {
                            $gstMinRate = $category->getCatMinGstRate();
                            if ($category->getCatGstRate()) {
                                $flag = true;
                            }
                            break;
                        }
                    }
                }

                if ($product->getGstRate()) {
                    $shippingGstRate = $product->getGstRate();
                    $gstMinimumPrice = $product->getMinGstAmount();
                    if ($gstMinimumPrice > $productPrice) {
                        $shippingGstRate = $product->getMinGstRate();
                    }
                } elseif ($flag) {
                    if ($gstRateMinAmount > $productPrice) {
                        $shippingGstRate = $gstMinRate;
                    }
                } else {
                    $shippingGstRate = $this->getRate();
                    if ($this->getMinAmount() > $productPrice) {
                        $shippingGstRate = $this->getMinRate();
                    }
                }
            }
            if ($shippingGstRate > $maxShippingPercent) {
                $maxShippingPercent = $shippingGstRate;
            }

            if ($this->getShippingGstClass()) :
                $shippingGst = $shippingAmount * ($maxShippingPercent / 100);
            else :
                $shippingGstTotal = 100 + $maxShippingPercent;//108
                $shippingGstPeracent = $shippingAmount / $shippingGstTotal; //5/108
                $shippingGst = $shippingGstPeracent * $maxShippingPercent;
            endif;
        }
        return $shippingGst;
    }

    public function logger($str){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/gst.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info(print_r($str,true));

    }
}
