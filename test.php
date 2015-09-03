<?php

require_once 'app/Mage.php';

Mage::app();

// Mage_Customer_Model_Session

//$customer = Mage::getModel('customer/session');

//echo get_class($customer);

$products = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToSelect('*');
//
$response = array();
foreach ($products as $product) {
    $images = Mage::getModel('catalog/product')->load($product->getData('entity_id'))->getMediaGalleryImages();
    foreach ($images as $image) {
        $response[] = $image->getData();
    }
    //    echo '<pre>';
//    $productData = $product->getData();
//
//    $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
//    $productData['stock'] = $stock->getData();
//    print_r($productData);
//
//    echo '</pre>';
//    var_dump($product);
}
echo '<pre>';
print_r($response);
echo '</pre>';
