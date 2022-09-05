<?php
namespace Meetanshi\IndianGst\Ui\Component\Listing\Column;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Sales\Api\Data\OrderInterface;

class CustomerName extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;
    protected $currencyHelper;

    public function __construct(Data $currencyHelper, ContextInterface $context, UiComponentFactory $uiComponentFactory, OrderRepositoryInterface $orderRepository, SearchCriteriaBuilder $criteria, array $components = [], array $data = [])
    {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        $this->_currencyHelper = $currencyHelper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $searchCriteria = $this->_searchCriteria->addFilter(
                    OrderInterface::ENTITY_ID,
                    $item["order_id"]
                )->create();
                $result = $this->_orderRepository->getList($searchCriteria);
                if (empty($result->getItems())) {
                    $item[$this->getData('name')] = "No such order.";
                } else {
                    $order = $this->_orderRepository->get($item["order_id"]);
                    $billingAddress = $order->getBillingAddress();
                    $item[$this->getData('name')] = $billingAddress['firstname'].' '.$billingAddress['lastname'];
                }
            }
        }

        return $dataSource;
    }
}
