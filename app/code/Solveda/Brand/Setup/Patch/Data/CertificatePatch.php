<?php

namespace Solveda\Brand\Setup\Patch\Data;

// use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
// use Magento\Catalog\Model\Category\Attribute\Backend\Image;
use Solveda\Brand\Model\Category\Attribute\Backend\Image;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CertificatePatch implements DataPatchInterface
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
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'certificate_image',
            [
                'type' => 'varchar',
                'label' => 'Certificate Image',
                'input' => 'image',
                'backend' => Image::class,
                'required' => false,
                'sort_order' => 9,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General Information',
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'authorized_dealer',
            [
                'type' => 'varchar',
                'label' => 'Authorized Dealer',
                'input' => 'boolean',
                'source'   => Boolean::class,
                'required' => false,
                'default'  => '0',
                'sort_order' => 10,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General Information',
            ]
        );
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
