<?php

namespace Meetanshi\IndianGst\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package Meetanshi\IndianGst\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallSchema constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $connection = $installer->getConnection();

        $quoteTable = $installer->getTable('quote');
        $quote_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'gst_exclusive' => ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'comment' => 'Is Exclusive Gst',],

        ];
        foreach ($quote_columns as $name => $definition) {
            $connection->addColumn($quoteTable, $name, $definition);
        }

        $quoteAddressTable = $installer->getTable('quote_address');
        $quote_address_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Percentage of Item',],
            'sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Percentage of Item',],
            'igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Percentage of Item',],
            'shipping_cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Percentage',],
            'shipping_sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Sgst Percentage',],
            'shipping_igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Igst Percentage',],
        ];
        foreach ($quote_address_columns as $name => $definition) {
            $connection->addColumn($quoteAddressTable, $name, $definition);
        }

        $salesOrder = $installer->getTable('sales_order');
        $sales_order_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'shipping_cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Percentage',],
            'shipping_sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Sgst Percentage',],
            'shipping_igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Igst Percentage',],
            'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',],
        ];
        foreach ($sales_order_columns as $name1 => $definition1) {
            $connection->addColumn($salesOrder, $name1, $definition1);
        }

        $salesOrderItem = $installer->getTable('sales_order_item');
        $sales_order_item_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Percentage of Item',],
            'sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Percentage of Item',],
            'igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Percentage of Item',],
            'gst_exclusive' => ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'comment' => 'Is Exclusive Gst',],
        ];
        foreach ($sales_order_item_columns as $name2 => $definition2) {
            $connection->addColumn($salesOrderItem, $name2, $definition2);
        }

        $salesOrderInvoice = $installer->getTable('sales_invoice');
        $sales_invoice_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'shipping_cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Percentage',],
            'shipping_sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Sgst Percentage',],
            'shipping_igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Igst Percentage',],
            'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',],

        ];
        foreach ($sales_invoice_columns as $name1 => $definition1) {
            $connection->addColumn($salesOrderInvoice, $name1, $definition1);
        }

        $salesInvoiceItem = $installer->getTable('sales_invoice_item');
        $sales_order_invoice_item_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Percentage of Item',],
            'sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Percentage of Item',],
            'igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Percentage of Item',],
            'gst_exclusive' => ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'comment' => 'Is Exclusive Gst',],

        ];
        foreach ($sales_order_invoice_item_columns as $name3 => $definition3) {
            $connection->addColumn($salesInvoiceItem, $name3, $definition3);
        }

        $salesOrderCreditmemo = $installer->getTable('sales_creditmemo');
        $sales_creditmemo_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'shipping_cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Percentage',],
            'shipping_sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Sgst Percentage',],
            'shipping_igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Igst Percentage',],
            'buyer_gst_number' => ['type' => Table::TYPE_TEXT, 'nullable' => false, 'comment' => 'Buyer GST Number',],
        ];
        foreach ($sales_creditmemo_columns as $name1 => $definition1) {
            $connection->addColumn($salesOrderCreditmemo, $name1, $definition1);
        }

        $salesOrderCreditmemo_item = $installer->getTable('sales_creditmemo_item');
        $sales_creditmemo_item_columns = [
            'cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Amount',],
            'base_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Cgst Amount',],
            'sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Amount',],
            'base_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Sgst Amount',],
            'igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Amount',],
            'base_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Igst Amount',],
            'shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Shipping Cgst Amount',],
            'base_shipping_cgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Cgst Amount',],
            'shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Shipping Amount',],
            'base_shipping_sgst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Sgst Amount',],
            'shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Shipping Amount',],
            'base_shipping_igst_amount' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Base Shipping Igst Amount',],
            'cgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Cgst Percentage of Item',],
            'sgst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Sgst Percentage of Item',],
            'igst_percent' => ['type' => Table::TYPE_DECIMAL, 'length' => '12,4', 'nullable' => false, 'comment' => 'Igst Percentage of Item',],
            'gst_exclusive' => ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'comment' => 'Is Exclusive Gst',],
        ];
        foreach ($sales_creditmemo_item_columns as $name1 => $definition1) {
            $connection->addColumn($salesOrderCreditmemo_item, $name1, $definition1);
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $directoryconnection = $resource->getConnection();
        $directory_region = $resource->getTableName('directory_country_region');

        $sql = "SELECT * FROM " . $directory_region . " where country_id = 'IN'";
        $result = $directoryconnection->fetchAll($sql);
        if ( count($result) == 0 ) {

            try {
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'JK', 'Jammu and Kashmir')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Jammu and Kashmir')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'HP', 'Himachal Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Himachal Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'PB', 'Punjab')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Punjab')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'CH', 'Chandigarh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Chandigarh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'UK', 'Uttarakhand')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Uttarakhand')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'HR', 'Haryana')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Haryana')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'DL', 'Delhi')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Delhi')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'RJ', 'Rajasthan')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Rajasthan')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'UP', 'Uttar Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Uttar Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'BR', 'Bihar')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Bihar')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'SK', 'Sikkim')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Sikkim')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'AR', 'Arunachal Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Arunachal Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'NL', 'Nagaland')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Nagaland')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'MN', 'Manipur')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Manipur')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'MZ', 'Mizoram')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Mizoram')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'TR', 'Tripura')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Tripura')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'ML', 'Meghlaya')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Meghlaya')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'AS', 'Assam')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Assam')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'WB', 'West Bengal')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'West Bengal')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'JH', 'Jharkhand')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Jharkhand')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'OR', 'Orissa')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Orissa')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'CG', 'Chhattisgarh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Chhattisgarh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'MP', 'Madhya Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Madhya Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'GJ', 'Gujarat')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Gujarat')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'DD', 'Daman and Diu')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Daman and Diu')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'DH', 'Dadra and Nagar Haveli')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Dadra and Nagar Haveli')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'MH', 'Maharashtra')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Maharashtra')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'KA', 'Karnataka')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Karnataka')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'GA', 'Goa')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Goa')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'LD', 'Lakshadweep')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Lakshadweep')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'KL', 'Kerala')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Kerala')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'TN', 'Tamil Nadu')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Tamil Nadu')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'PY', 'Pondicherry')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Pondicherry')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'AN', 'Andaman and Nicobar Islands')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Andaman and Nicobar Islands')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES
        ('IN', 'TS', 'Telangana')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Telangana')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES  ('IN', 'AP', 'Andhra Pradesh')");
                $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
        ('en_US', LAST_INSERT_ID(), 'Andhra Pradesh')");
            } catch (\Exception $e) {
            }
        }

        try {
            $installer->getConnection()->query("ALTER TABLE `{$installer->getTable('directory_country_region')}` ADD `state_code` varchar(3) COMMENT 'State Code';");
            $installer->getConnection()->query("ALTER TABLE `{$installer->getTable('directory_country_region_name')}` ADD `state_code` varchar(3) COMMENT 'State Code';");
        } catch (\Exception $e) {
        }

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '35' WHERE `default_name` = 'Andaman and Nicobar Islands';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '35' WHERE `name` = 'Andaman and Nicobar Islands';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '25' WHERE `default_name` = 'Daman and Diu';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '25' WHERE `name` = 'Daman and Diu';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '37' WHERE `default_name` = 'Andhra Pradesh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '37' WHERE `name` = 'Andhra Pradesh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '12' WHERE `default_name` = 
'Arunachal Pradesh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '12' WHERE `name` = 'Arunachal Pradesh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '18' WHERE `default_name` = 'Assam';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '18' WHERE `name` = 'Assam';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '10' WHERE `default_name` = 'Bihar';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '10' WHERE `name` = 'Bihar';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '04' WHERE `default_name` = 'Chandigarh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '04' WHERE `name` = 'Chandigarh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '22' WHERE `default_name` = 'Chhattisgarh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '22' WHERE `name` = 'Chhattisgarh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '26' WHERE `default_name` = 'Dadra and Nagar Haveli';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '26' WHERE `name` = 'Dadra and Nagar Haveli';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '07' WHERE `default_name` = 'Delhi';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '07' WHERE `name` = 'Delhi';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '30' WHERE `default_name` = 'Goa';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '30' WHERE `name` = 'Goa';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '24' WHERE `default_name` = 'Gujarat';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '24' WHERE `name` = 'Gujarat';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '06' WHERE `default_name` = 'Haryana';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '06' WHERE `name` = 'Haryana';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '02' WHERE `default_name` = 'Himachal Pradesh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '02' WHERE `name` = 'Himachal Pradesh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '01' WHERE `default_name` = 'Jammu and Kashmir';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '01' WHERE `name` = 'Jammu and Kashmir';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '20' WHERE `default_name` = 'Jharkhand';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '20' WHERE `name` = 'Jharkhand';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '29' WHERE `default_name` = 'Karnataka';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '29' WHERE `name` = 'Karnataka';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '32' WHERE `default_name` = 'Kerala';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '32' WHERE `name` = 'Kerala';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '31' WHERE `default_name` = 'Lakshadweep';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '31' WHERE `name` = 'Lakshadweep';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '23' WHERE `default_name` = 'Madhya Pradesh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '23' WHERE `name` = 'Madhya Pradesh';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '27' WHERE `default_name` = 'Maharashtra';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '27' WHERE `name` = 'Maharashtra';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '14' WHERE `default_name` = 'Manipur';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '14' WHERE `name` = 'Manipur';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '17' WHERE `default_name` = 'Meghlaya';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '17' WHERE `name` = 'Meghlaya';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '15' WHERE `default_name` = 'Mizoram';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '15' WHERE `name` = 'Mizoram';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '13' WHERE `default_name` = 'Nagaland';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '13' WHERE `name` = 'Nagaland';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '21' WHERE `default_name` = 'Orissa';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '21' WHERE `name` = 'Orissa';");

        $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES('IN', 'PY', 'Pondichery');");

        $installer->getConnection()->query("INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES('en_US', LAST_INSERT_ID(), 'Pondichery');");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '34' WHERE `default_name` = 'Pondicherry';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '34' WHERE `name` = 'Pondicherry';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '03' WHERE `default_name` = 'Punjab';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '03' WHERE `name` = 'Punjab';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '08' WHERE `default_name` = 'Rajasthan';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '08' WHERE `name` = 'Rajasthan';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '11' WHERE `default_name` = 'Sikkim';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '11' WHERE `name` = 'Sikkim';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '33' WHERE `default_name` = 'Tamil Nadu';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '33' WHERE `name` = 'Tamil Nadu';");

        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '36' WHERE `default_name` = 'Telangana';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '36' WHERE `name` = 'Telangana';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '16' WHERE `default_name` = 'Tripura';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '16' WHERE `name` = 'Tripura';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '09' WHERE `default_name` = 'Uttar Pradesh';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '09' WHERE `name` = 'Uttar Pradesh';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '05' WHERE `default_name` = 'Uttarakhand';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '05' WHERE `name` = 'Uttarakhand';");


        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region')}` SET `state_code` = '19' WHERE `default_name` = 'West Bengal';");
        $installer->getConnection()->query("UPDATE `{$installer->getTable('directory_country_region_name')}` SET `state_code` = '19' WHERE `name` = 'West Bengal';");
    }
}
