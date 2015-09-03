<?php

//echo get_class($this);


$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('customform_subscription'))
    ->addColumn('subscription_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ), 'Subscription_id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Created at')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Updated at')
    ->addColumn('firstname', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable' => false
    ), 'First name')
    ->addColumn('lastname', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable' => false
    ), 'Last name')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
        'nullable' => false
    ), 'Email address')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable' => false,
        'default' => 'pending'
    ), 'Status')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'unsigned' => true,
        'nullable' => false
    ), 'Subscription notes')
    ->addIndex($installer->getIdxName('customform_subscription', array('email')), array('email'))
    ->setComment('CustomForm subscriptions');
$installer->getConnection()->createTable($table);

$installer->endSetup();
