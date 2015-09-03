<?php

if (!isset($postData['sku']) || !isset($postData['imageBase64'])) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'require infos are missing'
    ));
    return;
}

$product = Mage::getModel('catalog/product')->loadByAttribute('sku', $postData['sku']);
$productData = $product->getData();
$productData['image'] = (string)Mage::helper('catalog/image')->init($product, 'image');
print_r($productData);
$tempFileName = 'logo.gif';
//$tempFileName = 'temp.txt';
//file_put_contents($tempFileName, $postData['image']);

try {

    $imageFileContent = file_get_contents($tempFileName);
    $ioAdapter = new Varien_Io_File();
    $ioAdapter->open(array('path' => '.'));
    $ioAdapter->write($tempFileName, $imageFileContent, 0666);
    new Varien_Image('.' . DS . $tempFileName);
    $imageFileUri = $product->_getMediaGallery()->addImage($product, '.' . DS . $tempFileName, null, false, false);
    // updateImage() must be called to add image data that is missing after addImage() call
    $product->_getMediaGallery()->updateImage($product, $imageFileUri, array());

//    if (isset($data['types'])) {
//        $product->_getMediaGallery()->setMediaAttribute($product, $data['types'], $imageFileUri);
//    }
    $product->save();
    var_dump($product->_getImageLocation($product->_getCreatedImageId($imageFileUri)));


    echo json_encode(array('message' => 'should success I suppose'));
} catch (Exception $e) {
    echo $e->getMessage();
}

//unlink($tempFileName);

