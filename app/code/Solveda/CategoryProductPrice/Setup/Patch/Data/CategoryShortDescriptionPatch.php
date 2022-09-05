<?php

namespace Solveda\CategoryProductPrice\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CategoryShortDescriptionPatch implements DataPatchInterface
{

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $eavSetup = $this->categorySetupFactory->create(['setup' => $setup]);
        
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'category_short_description', [
            'type' => 'text',
            'label' => 'Short Description',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 15,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General Information',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '1.0.0';
    }
}
