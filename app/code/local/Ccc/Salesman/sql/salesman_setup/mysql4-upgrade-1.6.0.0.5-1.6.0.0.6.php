<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
print_r($installer);
die;
$installer->startSetup();

$attributeCode = 'is_low_seller_product';
$attributeLabel = 'Is Low Seller Product';
$data = array(
    'type' => 'int',
    'backend' => '',
    'frontend' => '',
    'label' => $attributeLabel,
    'input' => 'select',
    'class' => '',
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
    'default' => '',
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'unique' => false,
    'apply_to' => 'simple,configurable',
    'is_configurable' => false,
    'used_in_product_listing' => true,
    'option' => array(
        'values' => array(
            'Yes',
            'No'
        )
    ),
);

$installer->addAttribute('catalog_product', $attributeCode, $data);

$installer->endSetup();
?>
