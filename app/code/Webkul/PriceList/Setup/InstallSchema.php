<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PriceList
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PriceList\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface as SchemaSetup;
use Magento\Framework\Setup\ModuleContextInterface as ModuleContext;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetup $setup, ModuleContext $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /*
         * Create table 'wk_pricelist_list'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_pricelist_list'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Title'
            )
            ->addColumn(
                'priority',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Priority'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                'start_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Start Date'
            )
            ->addColumn(
                'end_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'End Date'
            )
            ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created Date'
            )
            ->setComment('Pricelist List Table');
        $installer->getConnection()->createTable($table);

        /*
         * Create table 'wk_pricelist_rule'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_pricelist_rule'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Title'
            )
            ->addColumn(
                'priority',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Priority'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                'calculation_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Calculation Type'
            )
            ->addColumn(
                'price_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Price Type'
            )
            ->addColumn(
                'apply_on',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Applicable On'
            )
            ->addColumn(
                'price_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Price Type'
            )
            ->addColumn(
                'rule_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Rule Type'
            )
            ->addColumn(
                'is_combination',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Is Combination'
            )
            ->addColumn(
                'is_combination',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Is Combination'
            )
            ->addColumn(
                'amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => false],
                'Amount'
            )
            ->addColumn(
                'total',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => false],
                'Total Product Price'
            )
            ->addColumn(
                'qty',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Quantity'
            )
            ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created Date'
            )
            ->setComment('Pricelist Rules Table');
        $installer->getConnection()->createTable($table);

        /*
         * Create table 'wk_pricelist_assigned_rule'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_pricelist_assigned_rule'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'pricelist_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Pricelist Id'
            )
            ->addColumn(
                'rule_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Rule Id'
            )
            ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Date'
            )
            ->setComment('Pricelist Assigned Rule Table');
        $installer->getConnection()->createTable($table);

        /*
         * Create table 'wk_pricelist_rule_items'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_pricelist_rule_items'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'entity_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Entity Type'
            )
            ->addColumn(
                'parent_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Rule Id'
            )
            ->addColumn(
                'entity_value',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Entity Value'
            )
            ->setComment('Pricelist Rule Items Table');
        $installer->getConnection()->createTable($table);

        /*
         * Create table 'wk_pricelist_user_details'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wk_pricelist_user_details'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )
            ->addColumn(
                'pricelist_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Pricelist Id'
            )
            ->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'User Type'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'User Id'
            )
            ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Date'
            )
            ->setComment('Pricelist User Details Table');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
