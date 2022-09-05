<?php

declare(strict_types=1);

namespace Solveda\ShippingCities\Controller\Adminhtml\City;

use Exception;

class InlineEdit extends \Magento\Backend\App\Action
{

    protected $jsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $error = true;
        $messages = __('Please correct the data sent.');
        $resultJson = $this->jsonFactory->create();

        if ($this->getRequest()->getParam('isAjax')) {
            $sellItems = $this->getRequest()->getParam('items', []);
            if (count($sellItems)) {
                foreach (array_keys($sellItems) as $modelid) {
                    /** @var \Solveda\ShippingCities\Model\City $model */
                    $model = $this->_objectManager->create(\Solveda\ShippingCities\Model\City::class)->load($modelid);
                    try {
                        $data = array_merge($model->getData(), $sellItems[$modelid]);
                        $model->setData($data);
                        $model->save();
                        $error = false;
                    } catch (Exception $e) {
                        $messages[] = "[City ID: {$modelid}]  {$e->getMessage()}";
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
