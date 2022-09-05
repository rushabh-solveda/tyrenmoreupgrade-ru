<?php

namespace Solveda\ShippingCities\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class CustomCityPatch implements SchemaPatchInterface
{
    private $moduleDataSetup;


    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }


    public static function getDependencies()
    {
        return [];
    }


    public function getAliases()
    {
        return [];
    }


    public function apply()
    {
        $this->moduleDataSetup->startSetup();


        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('quote'),
            'custom_city_id',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment'  => 'Custom City ID',
            ]
        );

        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('sales_order'),
            'custom_city_id',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment'  => 'Custom City ID',
            ]
        );

        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('sales_order_grid'),
            'custom_city_id',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment'  => 'Custom City ID',
            ]
        );


        $this->moduleDataSetup->endSetup();
    }
}
