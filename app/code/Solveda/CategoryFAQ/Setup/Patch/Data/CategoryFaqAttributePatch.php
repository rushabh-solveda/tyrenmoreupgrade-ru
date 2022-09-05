<?php

declare(strict_types=1);

namespace Solveda\CategoryFAQ\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CategoryFaqAttributePatch implements DataPatchInterface
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
		
		$eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_tyre_size', [
            'type' => 'text',
            'label' => 'Tyre Size',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_best_tyre', [
            'type' => 'text',
            'label' => 'Best Tyres',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 15,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_air_pressure', [
            'type' => 'text',
            'label' => 'Air pressure',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 20,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_tyre_life', [
            'type' => 'text',
            'label' => 'Tyre Life',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 25,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_tyre_fuel_savings', [
            'type' => 'text',
            'label' => 'Tyre fuel savings',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 30,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => TRUE,
            'is_wysiwyg_enabled' => TRUE,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_tyre_grip', [
            'type' => 'text',
            'label' => 'Tyre grip',
            'input' => 'textarea',
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'sort_order' => 40,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Category FAQs Settings',
            'wysiwyg_enabled' => true,
            'is_wysiwyg_enabled' => true,
            'visible_on_front' => false,
            'is_html_allowed_on_front' => true
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'faq_tyre_warranty', [
            'type' => 'text',
            'label' => 'Tyre Warranty',
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
