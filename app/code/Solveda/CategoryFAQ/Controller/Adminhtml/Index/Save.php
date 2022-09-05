<?php

namespace Solveda\CategoryFAQ\Controller\Adminhtml\Index;

use Exception;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Solveda_CategoryFAQ::addnew';

    protected $dataPersistor;

    /**
     * @param \Solveda\CategoryFAQ\Model\CategoryFAQFactory
     */
    private $categoryfaqFactory;

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
        \Solveda\CategoryFAQ\Model\CategoryFAQFactory $categoryfaqFactory
    ) {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
        $this->pricehelper = $pricehelper;
        $this->categoryfaqFactory = $categoryfaqFactory;
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
            $model = $this->categoryfaqFactory->create();

            $model->setData($data);

            try {
                $model->save();
                if (isset($data['entity_id'])) {
                    $this->messageManager->addSuccessMessage('Category FAQ updated Successfully');
                } else {
                    $this->messageManager->addSuccessMessage('Category FAQ Added Successfully');
                }

                // return $resultRedirect->setPath('*/*/index');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __($e->getMessage()));
            }
        }

        if (isset($data['entity_id']) && isset($data['back'])) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $data['entity_id']]);
        }
        return $resultRedirect->setPath('*/*/index');
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
