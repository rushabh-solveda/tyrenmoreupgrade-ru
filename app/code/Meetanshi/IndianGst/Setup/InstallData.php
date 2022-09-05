<?php
namespace Meetanshi\IndianGst\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Class InstallData
 * @package Meetanshi\IndianGst\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory, CustomerSetupFactory $customerSetupFactory, AttributeSetFactory $attributeSetFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'gst_amount');

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'gst_rate',
            [
                'group' => 'GST India - Meetanshi',
                'type' => 'varchar',
                'backend' => '',
                'frontend' => '',
                'label' => 'GST Rate (in Percentage)',
                'input' => 'select',
                'class' => '',
                'source' => 'Meetanshi\IndianGst\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'sort_order' => 5,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'min_gst_amount',
            [
                'group' => 'GST India - Meetanshi',
                'label' => 'Minimum Product Price to Apply Above GST Rate',
                'type'  => 'decimal',
                'input' => 'text',
                'required' => false,
                'sort_order' => 10,
                'searchable' => false,
                'filterable' => false,
                'length'    => '10,2',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'min_gst_rate',
            [
                'group' => 'GST India - Meetanshi',
                'type' => 'varchar',
                'backend' => '',
                'frontend' => '',
                'label' => 'GST Rate to Apply on Products Below Minimum Set Price',
                'input' => 'select',
                'class' => '',
                'source' => 'Meetanshi\IndianGst\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'sort_order' => 15,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'hsn_code',
            [
                'group' => 'GST India - Meetanshi',
                'label' => 'Product HSN Code',
                'type'  => 'varchar',
                'input' => 'text',
                'required' => false,
                'sort_order' => 20,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false
            ]
        );


        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'cat_gst_rate',
            [
                'group' => 'GST India - Meetanshi',
                'type' => 'varchar',
                'label' => 'GST Rate (in Percentage)',
                'input' => 'select',
                'class' => '',
                'source' => 'Meetanshi\IndianGst\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'sort_order' => 5,
                'required' => false,
                'visible'      => true,
                'user_defined' => false,
                'default'      => null,
                'backend'      => ''
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'cat_min_gst_amount',
            [
                'group' => 'GST India - Meetanshi',
                'label' => 'Minimum Product Price to Apply Above GST Rate',
                'type'  => 'decimal',
                'input' => 'text',
                'required' => false,
                'sort_order' => 10,
                'length'    => '10,2',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'cat_min_gst_rate',
            [
                'group' => 'GST India - Meetanshi',
                'type' => 'varchar',
                'label' => 'GST Rate to Apply on Products Below Minimum Set Price',
                'input' => 'select',
                'source' => 'Meetanshi\IndianGst\Model\Config\Source\Options',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'sort_order' => 15,
                'required' => false
            ]
        );


        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $customerSetup->addAttribute('customer_address', 'buyer_gst_number', [
            'type'          => 'text',
            'label'         => 'Buyer GST Number',
            'input'         => 'text',
            'required'      =>  false,
            'visible'       =>  true,
            'user_defined'  =>  true,
            'sort_order'    =>  110,
            'position'      =>  110,
            'system'        =>  0,
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'buyer_gst_number')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => [
                    'adminhtml_customer_address',
                    'customer_address_edit',
                    'checkout_register',
                    'customer_register_address'
                ],
            ]);
        $attribute->save();


        $setup->endSetup();
    }
}
