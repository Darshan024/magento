<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();
$attributeCode = 'most_selling_item';
$attributeLabel = 'most_selling_item';
$data = array(
    'attribute_code' => $attributeCode,
    'type' => 'int',
    'input' => 'select',
    'label' => $attributeLabel,
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'configurable' => false,
    'apply_to' => 'simple,configurable',
    'visible_on_front' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
    'option' => array(
        'values' => array(
            'Yes',
            'No'
        )
    )
);
$installer->addAttribute('catalog_product', $attributeCode, $data);

$Code = 'has_most_selling_related_items';
$Label = 'has_most_selling_related_items';
$data2 = array(
    'attribute_code' => $Code,
    'type' => 'int',
    'input' => 'select',
    'label' => $Label,
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'configurable' => false,
    'apply_to' => 'simple,configurable',
    'visible_on_front' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
    'option' => array(
        'values' => array(
            'Yes',
            'No'
        )
    )
);
$installer->addAttribute('catalog_product', $Code, $data2);

$installer->endSetup();