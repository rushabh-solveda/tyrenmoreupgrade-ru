<?php

declare(strict_types=1);

namespace Solveda\CategoryFAQ\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CategoryNewAttributePatch implements DataPatchInterface
{
    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory          $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
		

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'lowest_price_html', [
            'type' => 'text',
            'label' => 'Lowest Price Html',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category Price Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);
		
				$eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_cheapest_price', [
            'type' => 'text',
            'label' => 'Tyre Cheapest Price',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 50,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);
		
		$eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_highest_price', [
            'type' => 'text',
            'label' => 'Tyre Highest Price',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 50,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
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
}
