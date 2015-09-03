<?php
class Custom_Restapi_Model_Api2_Restapi_Rest_Admin_V1 extends Custom_Restapi_Model_Api2_Restapi
{

    public function _retrieve() {
        $id = Mage::app()->getRequest()->getParam('id');
        return $id;
    }

    public function _retrieveCollection() {
        $products = Mage::getModel('catalog/product')->getCollection();
        $response = array();
        foreach ($products as $product) {
            $productData = $product->getData();

            $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
            $productData['stock'] = $stock->getData();

            $images = Mage::getModel('catalog/product')->load($product->getData('entity_id'))->getMediaGalleryImages();
            foreach ($images as $image) {
                $productData['images'][] = $image->getData();
            }

            $response[] = $productData;
        }
        return json_encode($response);
    }

    /**
     * Create a customer
     * @return array
     */
    public function _create(array $data) {

        $firstName = $data['firstname'];
        $lastName = $data['lastname'];
        $email = $data['email'];
        $password = $data['password'];

        $customer = Mage::getModel("customer/customer");

        $customer->setFirstname($firstName);
        $customer->setLastname($lastName);
        $customer->setEmail($email);
        $customer->setPasswordHash(md5($password));
        $customer->save();

        return $this->_getLocation($customer);
    }

}