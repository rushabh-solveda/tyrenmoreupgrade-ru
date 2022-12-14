<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * BSS Commerce does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * BSS Commerce does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category  BSS
 * @package   Bss_MultiStoreViewPricing
 * @author    Extension Team
 * @copyright Copyright (c) 2016-2017 BSS Commerce Co. ( http://bsscommerce.com )
 * @license   http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Bss\MultiStoreViewPricingCatalogRule\Model\Indexer;

use Magento\Framework\App\ObjectManager;
use Magento\CatalogRule\Model\Indexer\IndexerTableSwapperInterface as TableSwapper;

/**
 * Build select for rule relation with product.
 */
class RuleProductsSelectBuilder extends \Magento\CatalogRule\Model\Indexer\RuleProductsSelectBuilder
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resource;

    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    private $metadataPool;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Indexer\ActiveTableSwitcher
     */
    private $activeTableSwitcher;

    /**
     * @var TableSwapper
     */
    private $tableSwapper;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param \Magento\Catalog\Model\ResourceModel\Indexer\ActiveTableSwitcher $activeTableSwitcher
     * @param TableSwapper|null $tableSwapper
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\EntityManager\MetadataPool $metadataPool,
        \Magento\Catalog\Model\ResourceModel\Indexer\ActiveTableSwitcher $activeTableSwitcher,
        TableSwapper $tableSwapper = null
    ) {
        parent::__construct(
            $resource,
            $eavConfig,
            $storeManager,
            $metadataPool,
            $activeTableSwitcher
        );
        $this->eavConfig = $eavConfig;
        $this->storeManager = $storeManager;
        $this->metadataPool = $metadataPool;
        $this->resource = $resource;
        $this->tableSwapper = $tableSwapper ??
            ObjectManager::getInstance()->get(TableSwapper::class);
    }

    /**
     * Build select for indexer according passed parameters.
     *
     * @param int $websiteId
     * @param \Magento\Catalog\Model\Product|null $product
     * @param bool $useAdditionalTable
     * @return \Zend_Db_Statement_Interface
     */
    public function build(
        $websiteId,
        $productId = null,
        $useAdditionalTable = false
        ) {
        $helper = ObjectManager::getInstance()->get('Bss\MultiStoreViewPricing\Helper\Data');
        if (!$helper->isScopePrice()) {
            return parent::build($websiteId, $product, $useAdditionalTable);
        }

        $connection = $this->resource->getConnection();
        $indexTable = $this->resource->getTableName('catalogrule_product_store');
        if ($useAdditionalTable) {
            $indexTable = $this->resource->getTableName(
                $this->tableSwapper->getWorkingTableName('catalogrule_product_store')
            );
        }

        /**
         * Sort order is important
         * It used for check stop price rule condition.
         * website_id   customer_group_id   product_id  sort_order
         *  1           1                   1           0
         *  1           1                   1           1
         *  1           1                   1           2
         * if row with sort order 1 will have stop flag we should exclude
         * all next rows for same product id from price calculation
         */
        $select = $connection->select()->from(
            ['rp' => $indexTable]
        )->order(
            ['rp.website_id', 'rp.customer_group_id', 'rp.product_id', 'rp.sort_order', 'rp.rule_id']
        );

        if ($product && $product->getEntityId()) {
            $select->where('rp.product_id=?', $product->getEntityId());
        }
        $select->where('rp.store_id=?', $storeId);
        
        /**
         * Join default price and websites prices to result
         */
        $priceAttr = $this->eavConfig->getAttribute(\Magento\Catalog\Model\Product::ENTITY, 'price');
        $priceTable = $priceAttr->getBackend()->getTable();
        $attributeId = $priceAttr->getId();

        $linkField = $this->metadataPool
            ->getMetadata(\Magento\Catalog\Api\Data\ProductInterface::class)
            ->getLinkField();
        $select->join(
            ['e' => $this->resource->getTableName('catalog_product_entity')],
            sprintf('e.entity_id = rp.product_id'),
            []
        );
        $joinCondition = '%1$s.' . $linkField . '=e.' . $linkField . ' AND (%1$s.attribute_id='
            . $attributeId
            . ') and %1$s.store_id=%2$s';

        $select->join(
            ['pp_default' => $priceTable],
            sprintf($joinCondition, 'pp_default', \Magento\Store\Model\Store::DEFAULT_STORE_ID),
            []
        );

        $select->joinInner(
            ['product_website' => $this->resource->getTableName('catalog_product_website')],
            'product_website.product_id=rp.product_id '
            . 'AND product_website.website_id = rp.website_id '
            . 'AND product_website.website_id='
            . $websiteId,
            []
        );

        $tableAlias = 'pp' . $websiteId;
        $select->joinLeft(
            [$tableAlias => $priceTable],
            sprintf($joinCondition, $tableAlias, $storeId),
            []
        );
        $select->columns([
            'default_price' => $connection->getIfNullSql($tableAlias . '.value', 'pp_default.value'),
        ]);

        return $connection->query($select);
    }
}
