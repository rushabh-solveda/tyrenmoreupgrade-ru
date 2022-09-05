<?php

namespace Solveda\ShippingCities\Controller\Adminhtml\City;

use Exception;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Solveda_ShippingCities::manage_cities';

    protected $dataPersistor;

    /**
     * @param \Solveda\ShippingCities\Model\CityFactory
     */
    private $cityFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Pricing\Helper\Data $pricehelper,
        \Solveda\ShippingCities\Model\CityFactory $cityFactory
    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
        $this->pricehelper = $pricehelper;
        $this->cityFactory = $cityFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if ($data) {
            $model = $this->cityFactory->create();

            $model->setData($data);

            try {
                $model->save();
                if (isset($data['entity_id'])) {
                    $this->messageManager->addSuccessMessage('City updated Successfully');
                } else {
                    $this->messageManager->addSuccessMessage('City Added Successfully');
                }
                return $resultRedirect->setPath('*/*/grid');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __($e->getMessage()));
            }
        }
        if (isset($data['entity_id'])) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $data['entity_id']]);
        }
        return $resultRedirect->setPath('*/*/create');
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
