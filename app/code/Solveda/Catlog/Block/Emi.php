<?php
namespace Solveda\Catlog\Block;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\CurrencyFactory;

class Emi extends \Magento\Framework\View\Element\Template
{
	/**
     * @var \Magento\Framework\Registry
     */
	 
    protected $registry;
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
	 
    protected $priceHelper;
	
	protected $emibankFactory;
	
	protected $emidetailsFactory;
	
	 /**
     * @var StoreManagerInterface
     */
    private $storeConfig;

    /**
     * @var CurrencyFactory
     */
    private $currencyCode;

    /**
     * Currency constructor.
     *
     * @param StoreManagerInterface $storeConfig
     * @param CurrencyFactory $currencyFactory
     */
	
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Solveda\Catlog\Model\EmiBankFactory $emibankFactory,
		\Solveda\Catlog\Model\EmiDetailsFactory $emidetailsFactory,
		\Magento\Framework\Registry $registry,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
		StoreManagerInterface $storeConfig,
        CurrencyFactory $currencyFactory
    ) {

        parent::__construct($context);
        $this->emibankFactory = $emibankFactory;
		$this->emidetailsFactory = $emidetailsFactory;
		$this->registry = $registry;
        $this->priceHelper = $priceHelper;
		$this->storeConfig = $storeConfig;
        $this->currencyCode = $currencyFactory->create();
    }

    public function getBankName(){
        $collection = $this->emibankFactory->create()->getCollection();
        return $collection;     
    }
	public function getCardType($cardType){
        $collection = $this->emibankFactory->create()->getCollection();
		$card = $collection->addFieldToFilter('card_type',$cardType);
        return $card;     
    }
	public function getBankDetails($bankId){
        $collection = $this->emidetailsFactory->create()->getCollection();
		$bankidcollection = $collection->addFieldToFilter('bank_id',$bankId);
        return $bankidcollection;     
    }
	
	public function getPmt($interest,$num_of_payments,$PV,$FV = 0.00, $Type = 0){
		$xp=pow((1+$interest),$num_of_payments);
		return
			($PV* $interest*$xp/($xp-1)+$interest/($xp-1)*$FV)*
			($Type==0 ? 1 : 1/($interest+1));
	}
	public function getProductPrice()
    {
        $product = $this->registry->registry('current_product');
		return $product->getFinalPrice();
    }
	public function getSymbol()
    {
        $currentCurrency = $this->storeConfig->getStore()->getCurrentCurrencyCode();
        $currency = $this->currencyCode->load($currentCurrency);
        return $currency->getCurrencySymbol();
    }
	public function getFormatedPrice($price)
    {
        return $this->priceHelper->currency($price, false, false);
    }
}