<?php
/**
 * Provider: Meetanshi.
 * Package: @_LiveData
 * Support: support@meetanshi.com (https://meetanshi.com/)
 */

namespace Meetanshi\IndianGst\Ui\Component\Listing\Column;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Pricing\Helper\Data;

class GstAmount extends Column
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
                $order  = $this->_orderRepository->get($item["entity_id"]);
                $gstAmount = round($order->getData("igst_amount") + $order->getData("cgst_amount") + $order->getData("sgst_amount"), 2);

                $item[$this->getData('name')] = $this->_currencyHelper->currency(number_format($gstAmount, 2), true, false);
            }
        }

        return $dataSource;
    }
}
