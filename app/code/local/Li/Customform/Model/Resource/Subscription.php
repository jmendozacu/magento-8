<?php

class Li_Customform_Model_Resource_Subscription extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct () {
        /*link the model with theprimary key of the database table*/
        $this->_init('customform/subscription', 'subscription_id');
    }
}