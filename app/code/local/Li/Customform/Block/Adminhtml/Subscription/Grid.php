<?php

class Li_Customform_Block_Adminhtml_Subscription_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct () {
        parent::__construct();

        $this->setId('subscription_grid');
        $this->setDefaultSort('subscription_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection () {
        $collection = Mage::getModel('customform/subscription')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns () {
        $this->addColumn('subscription_id', array(
            'index' => 'subscription_id',
            'header' => Mage::helper('customform')->__('Subscription id'),
            'type' => 'number',
            'sortable' => true,
            'width' => '100px'
        ));

        $this->addColumn('firstname', array(
            'index' => 'firstname',
            'header' => Mage::helper('customform')->__('Firstname'),
            'sortable' => false
        ));

        $this->addColumn('lastname', array(
            'index' => 'lastname',
            'header' => Mage::helper('customform')->__('Lastname'),
            'sortable' => false
        ));

        $this->addColumn('email', array(
            'index' => 'email',
            'header' => Mage::helper('customform')->__('Email'),
            'sortable' => false
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl () {
        return $this->getUrl('*/*/grid', array(
            '_current' => true
        ));
    }

}