<?php
namespace Meetanshi\IndianGst\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'item_id';

    /**
     * @param EntityFactoryInterface $entityFactory,
     * @param LoggerInterface        $logger,
     * @param FetchStrategyInterface $fetchStrategy,
     * @param ManagerInterface       $eventManager,
     * @param StoreManagerInterface  $storeManager,
     * @param AdapterInterface       $connection,
     * @param AbstractDb             $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->_init('Meetanshi\IndianGst\Model\Item', 'Meetanshi\IndianGst\Model\ResourceModel\Item');
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
    }
    protected function _construct()
    {
        parent::_construct();
        $this->addFilterToMap(
            'created_at',
            'main_table.created_at'
        );
    }
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->where('main_table.parent_item_id IS NULL');
        $this->getSelect()->joinLeft(
            ['order_table' => $this->getTable('sales_order')],
            'main_table.order_id = order_table.entity_id',
            ['status']
        );
    }
}
