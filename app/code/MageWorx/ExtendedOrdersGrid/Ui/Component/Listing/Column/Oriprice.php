<?php

namespace MageWorx\ExtendedOrdersGrid\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;

class Oriprice extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        array $components = [],
        array $data = [])
    {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {

        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of Object Manager
        $priceHelper    = $objectManager->create('Magento\Framework\Pricing\Helper\Data'); // Instance of Pricing Helper

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $productArr = [];
                $order      = $this->_orderRepository->get($items["entity_id"]);

                foreach ($order->getAllItems() as $item) {
                    //$productArr[] = $item->getAll();
                    $price          = $item->getOriginalPrice(); //Get original_price
                    $productArr[]   = $priceHelper->currency($price, true, false);
                    //$productArr[]   = $item->getOriginalPrice(); //Get original_price
                }
                $items['oriprice']  = implode(' - ', $productArr);
                unset($productArr);
            }
        }
        return $dataSource;
    }
}