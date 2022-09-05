<?php
namespace Meetanshi\IndianGst\Plugin\Checkout\Model;

class ShippingInformationManagement
{
    protected $quoteRepository;

    protected $dataHelper;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Meetanshi\IndianGst\Helper\Data $dataHelper
    ) {
    
        $this->quoteRepository = $quoteRepository;
        $this->dataHelper = $dataHelper;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $cgstAmount = $addressInformation->getExtensionAttributes()->getCgstAmount();
        $quote = $this->quoteRepository->getActive($cartId);
        if ($cgstAmount) {
            $cgst = $this->dataHelper->calculateCgst($cartId);
            $quote->setCgstAmount($cgst);
            $quote->setBaseCgstAmount($cgst);
        } else {
            $quote->setCgstAmount(null);
            $quote->setBaseCgstAmount(null);
        }

        $utgstAmount = $addressInformation->getExtensionAttributes()->getUtgstAmount();
        $quote = $this->quoteRepository->getActive($cartId);
        if ($utgstAmount) {
            $utgst = $this->dataHelper->calculateUtgst($cartId);
            $quote->setUtgstAmount($utgst);
            $quote->setBaseUtgstAmount($utgst);
        } else {
            $quote->setUtgstAmount(null);
            $quote->setBaseUtgstAmount(null);
        }

        $sgstAmount = $addressInformation->getExtensionAttributes()->getSgstAmount();
        if ($sgstAmount) {
            $sgst = $this->dataHelper->calculateSgst($cartId);
            $quote->setSgstAmount($sgst);
            $quote->setBaseSgstAmount($sgst);
        } else {
            $quote->setSgstAmount(null);
            $quote->setBaseSgstAmount(null);
        }

        $igstAmount = $addressInformation->getExtensionAttributes()->getIgstAmount();
        if ($igstAmount) {
            $igst = $this->dataHelper->calculateIgst($cartId);
            $quote->setIgstAmount($igst);
            $quote->setBaseIgstAmount($igst);
        } else {
            $quote->setIgstAmount(null);
            $quote->setBaseIgstAmount(null);
        }
        $buyerGstNumber = $addressInformation->getExtensionAttributes()->getBuyerGstNumber();
        if ($buyerGstNumber) {
            $quote->getShippingAddress()->setBuyerGstNumber($addressInformation->getExtensionAttributes()->getBuyerGstNumber());
            $quote->getBillingAddress()->setBuyerGstNumber($addressInformation->getExtensionAttributes()->getBuyerGstNumber());
        }
    }
}
