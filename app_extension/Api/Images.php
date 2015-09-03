<?php

require_once '../../app/Mage.php';
Mage::app();

// get post data
$postData = json_decode(file_get_contents('php://input'), true);

if (!isset($postData['action'])) {
    echo json_encode(array(
        'status' => 'fail'
    ));
    return;
}

switch ($postData['action']) {
    case 'uploadImage' :
        require_once 'functions/uploadImage.php';
        break;
    case 'getProductInfo' :
        require_once 'functions/getProductInfo.php';
        break;
}
