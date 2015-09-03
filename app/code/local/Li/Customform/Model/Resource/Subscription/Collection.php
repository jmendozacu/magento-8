<?php

class Li_Customform_Model_Resource_Subscription_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    protected function _construct () {
        $this->_init('customform/subscription');
    }

}