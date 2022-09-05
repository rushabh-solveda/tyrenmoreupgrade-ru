<?php


namespace Meetanshi\IndianGst\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class UpgradeSchema
 * @package Meetanshi\IndianGst\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.8', '<')) {
            $connection = $installer->getConnection();

            $quoteTable = $installer->getTable('quote');
            $quote_columns = [
                'utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Utgst Amount'
                    ],
                'base_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Base Utgst Amount'
                    ],
                'shipping_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Shipping Utgst Amount'
                    ],
                'base_shipping_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Base Shipping Utgst Amount'
                    ],
            ];
            foreach ($quote_columns as $name => $definition) {
                $connection->addColumn($quoteTable, $name, $definition);
            }

            $quoteAddressTable = $installer->getTable('quote_address');
            $quote_address_columns = [
                'utgst_amount' => 
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Utgst Amount'
                    ],
                'base_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Base Utgst Amount'
                    ],
                'utgst_percent' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Utgst Percentage of Item'
                    ],
                'shipping_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Shipping Utgst Amount'
                    ],
                'base_shipping_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Base Shipping Utgst Amount'
                    ],
                'shipping_utgst_percent' =>
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'length' => '12,4',
                        'nullable' => false,
                        'comment' => 'Shipping Utgst Percentage'
                    ],
            ];
            foreach ($quote_address_columns as $name => $definition) {
                $connection->addColumn($quoteAddressTable, $name, $definition);
            }

            $salesOrder = $installer->getTable('sales_order');
            $sales_order_columns = [
                'utgst_amount' => 
                    [
                        'type' => Table::TYPE_DECIMAL, 
                        'length' => '12,4', 
                        'nullable' => false, 
                        'comment' => 'Utgst Amount'
                    ],
                'base_utgst_amount' =>
                    [
                        'type' => Table::TYPE_DECIMAL, 
                        'length' => '12,4', 
                        'nullable' => false, 
                        'comment' => 'Base Utgst Amount'
                    ],
                'shipping_utgst_amount' => 
                    [
                        'type' => Table::TYPE_DECIMAL, 
                        'length' => '12,4', 
                        'nullable' => false, 
                        'comment' => 'Shipping Utgst Amount'
                    ],
                'base_shipping_utgst_amount' => 
                    [
                        'type' => Table::TYPE_DECIMAL, 
                        'length' => '12,4', 
                        'nullable' => false, 
                        'comment' => 'Base Shipping Utgst Amount'
                    ],
                'shipping_utgst_percent' =>
                    [
                        'type' => Table::TYPE_DECIMAL, 
                        'length' => '12,4', 
                        'nullable' => false, 
                        'comment' => 'Shipping Utgst Percentage'
                    ],
            ];
            foreach ($sales_order_columns as $name1 => $definition1) {
                $connection->addColumn($salesOrder, $name1, $definition1);
            }

            $salesOrderItem = $installer->getTable('sales_order_item');
            $sales_order_item_columns = [
                'utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Amount'],
                'base_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Utgst Amount'],
                'shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Amount'],
                'base_shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Utgst Amount'],
                'utgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Percentage of Item'],
            ];
            foreach ($sales_order_item_columns as $name2 => $definition2) {
                $connection->addColumn($salesOrderItem, $name2, $definition2);
            }

            $salesOrderInvoice = $installer->getTable('sales_invoice');
            $sales_invoice_columns = [
                'utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Amount'],
                'base_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Utgst Amount'],
                'shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Amount'],
                'base_shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Utgst Amount'],
                'shipping_utgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Percentage'],
            ];
            foreach ($sales_invoice_columns as $name1 => $definition1) {
                $connection->addColumn($salesOrderInvoice, $name1, $definition1);
            }

            $salesInvoiceItem = $installer->getTable('sales_invoice_item');
            $sales_order_invoice_item_columns = [
                'utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Amount'],
                'base_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Utgst Amount'],
                'shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Amount'],
                'base_shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Utgst Amount'],
                'utgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Percentage of Item'],
            ];
            foreach ($sales_order_invoice_item_columns as $name3 => $definition3) {
                $connection->addColumn($salesInvoiceItem, $name3, $definition3);
            }

            $salesOrderCreditmemo = $installer->getTable('sales_creditmemo');
            $sales_creditmemo_columns = [
                'utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Amount'],
                'base_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Utgst Amount'],
                'shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Amount'],
                'base_shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Utgst Amount'],
                'shipping_utgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Percentage'],
            ];
            foreach ($sales_creditmemo_columns as $name1 => $definition1) {
                $connection->addColumn($salesOrderCreditmemo, $name1, $definition1);
            }

            $salesOrderCreditmemo_item = $installer->getTable('sales_creditmemo_item');
            $sales_creditmemo_item_columns = [
                'utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Amount'],
                'base_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Utgst Amount'],
                'shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Utgst Amount'],
                'base_shipping_utgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Utgst Amount'],
                'utgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Utgst Percentage of Item'],

                ];
            foreach ($sales_creditmemo_item_columns as $name1 => $definition1) {
                $connection->addColumn($salesOrderCreditmemo_item, $name1, $definition1);
            }

            $quoteAddress = $installer->getTable('quote_address');
            $quote_address_columns = [
                'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',]
            ];
            foreach ($quote_address_columns as $name1 => $definition1) {
                $connection->addColumn($quoteAddress, $name1, $definition1);
            }

            $salesOrderAddress = $installer->getTable('sales_order_address');
            $sales_order_address_columns = [
                'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',]
            ];
            foreach ($sales_order_address_columns as $name1 => $definition1) {
                $connection->addColumn($salesOrderAddress, $name1, $definition1);
            }
        }
        $installer->endSetup();
    }
}