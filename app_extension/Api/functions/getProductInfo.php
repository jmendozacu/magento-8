<?php

$products = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToSelect('*');

foreach ($products as $product) {
    echo '<pre>';
    $productData = $product->getData();

    $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
    $productData['stock'] = $stock->getData();

    $productData['image'] = (string)Mage::helper('catalog/image')->init($product, 'image');

    print_r($productData);

    echo '</pre>';
}
