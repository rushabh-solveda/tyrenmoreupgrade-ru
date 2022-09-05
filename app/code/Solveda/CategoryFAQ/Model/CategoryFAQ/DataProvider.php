<?php

namespace Solveda\CategoryFAQ\Model\CategoryFAQ;

use Magento\Framework\App\Request\DataPersistorInterface;
use Solveda\CategoryFAQ\Model\ResourceModel\CategoryFAQ\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $collection;
    protected $dataPersistor;

    /**
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data for admin ui-component
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        // $logger = \Magento\Framework\App\ObjectManager::getInstance()->get('\Psr\Log\LoggerInterface');
        // $logger->debug(print_r($this->loadedData, true));

        foreach ($items as $model) {
            $itemData = $model->getData();
            $this->loadedData[$model->getEntityId()] = $itemData;
        }



        return $this->loadedData;
    }
}
