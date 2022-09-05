<?php

namespace Payment\Phonepe\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 *
 * @package Payment\Phonepe\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install Blog Posts table
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

     
        $tableResponse = $setup->getTable('phonepe_response');
        

        if ($setup->getConnection()->isTableExists($tableResponse) != true) {
            $table1 = $setup->getConnection()
                ->newTable($tableResponse)
                ->addColumn(
                    'response_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'response_customer_enail',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => true,
                       
                    ],
                    'Cuntomer Email'
                )
                ->addColumn(
                    'response_order_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => true,
                       
                    ],
                    'Order ID'
                )
                ->addColumn(
                    'response_status',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Status'
                )
                ->addColumn(
                    'response_reservation_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Reservation Id'
                )
                ->addColumn(
                    'response_transaction_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Transaction Id'
                )
                ->addColumn(
                    'response_obj',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Response Obj'
                )  
                ->addColumn(
                    'response_price',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => true],
                    'Response Price'
                ) 
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Phonepe');
            $setup->getConnection()->createTable($table1);
        }



        $setup->endSetup();
    }
}
