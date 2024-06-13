<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'test';

$attributeId = $installer->getAttributeId('catalog_product', $attributeCode);

$newData = array(
    'label' => 'Updated Test Label',
    'visible_on_front' => false,
    'is_html_allowed_on_front' => false,
    'option' => array(
        'value' => array(
            'option3' => array(0 => 'test3') 
        )
    )
);

// Update the attribute
$installer->updateAttribute('catalog_product', $attributeId, $newData);

$installer->endSetup();
