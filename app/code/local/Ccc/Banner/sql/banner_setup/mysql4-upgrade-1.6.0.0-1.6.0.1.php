<?php
// $installer = $this;
// $installer->startSetup();

// $tableName = $installer->getTable('catalogrule_affected_product');

// $installer->getConnection()
//     ->addColumn(
//         $tableName,
//         'test',
//         array(
//             'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
//             'length' => 255,
//             'comment' => 'Test'
//         )
//     );
// $installer->endSetup();


$installer = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

$attributeCode = 'is_low_seller_product_checkbox';
$attributeLabel = 'Is Low Seller Product (Checkbox)';
$data = array(
    'type' => 'varchar', // 'varchar' is used for multi-select
    'backend' => 'eav/entity_attribute_backend_array', // Backend model for array values
    'frontend' => '',
    'label' => $attributeLabel,
    'input' => 'multiselect', // Multi-select input
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
            'Option 1',
            'Option 2',
            'Option 3'
        )
    ),
);

$installer->addAttribute('catalog_product', $attributeCode, $data);

$installer->endSetup();


// $installer = new Mage_Eav_Model_Entity_Setup('core_setup');

// $installer->startSetup();

// $attributeCode = 'is_low_seller_product_text';
// $attributeLabel = 'Is Low Seller Product (Text)';
// $data = array(
//     'type' => 'varchar', // 'varchar' is used for text input
//     'backend' => '',
//     'frontend' => '',
//     'label' => $attributeLabel,
//     'input' => 'text', // Text input
//     'class' => '',
//     'source' => '',
//     'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
//     'visible' => true,
//     'required' => false,
//     'user_defined' => false,
//     'default' => '',
//     'searchable' => false,
//     'filterable' => false,
//     'comparable' => false,
//     'visible_on_front' => true,
//     'unique' => false,
//     'apply_to' => 'simple,configurable',
//     'is_configurable' => false,
//     'used_in_product_listing' => true,
// );

// $installer->addAttribute('catalog_product', $attributeCode, $data);

// $installer->endSetup();


// $installer = new Mage_Eav_Model_Entity_Setup('core_setup');

// $installer->startSetup();

// $attributeCode = 'is_low_seller_product_radio';
// $attributeLabel = 'Is Low Seller Product (Radio)';
// $data = array(
//     'type' => 'int',
//     'backend' => '',
//     'frontend' => '',
//     'label' => $attributeLabel,
//     'input' => 'select', // Radio input is represented by 'select'
//     'class' => '',
//     'source' => 'eav/entity_attribute_source_table',
//     'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
//     'visible' => true,
//     'required' => false,
//     'user_defined' => false,
//     'default' => '',
//     'searchable' => false,
//     'filterable' => false,
//     'comparable' => false,
//     'visible_on_front' => true,
//     'unique' => false,
//     'apply_to' => 'simple,configurable',
//     'is_configurable' => false,
//     'used_in_product_listing' => true,
//     'option' => array(
//         'values' => array(
//             'Yes',
//             'No'
//         )
//     ),
// );

// $installer->addAttribute('catalog_product', $attributeCode, $data);

// $installer->endSetup();
?>

?>

