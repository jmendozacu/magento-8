<?php


$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'li_label', array(
    'group' => 'CustomFrom',
    'type' => 'varchar',
    'lable' => 'Customform label',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'unique' => false,
    'apply_to' => 'simple,configurable,virtual,bundle,downloadable',
    'is_configurable' => false
));

$installer->endSetup();