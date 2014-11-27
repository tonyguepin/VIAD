<?php

//autoloader inladen
require_once('./includes/classes/Autoload.php');
try{
    $config = new Pay_Config();

    $orderId = $_GET['orderId'];

    $apiInfo = new Pay_Api_Info();

    $apiInfo->setApiToken($config->apitoken);
    $apiInfo->setServiceId($config->serviceId);
    $apiInfo->setTransactionId($orderId);

    $result = $apiInfo->doRequest();

    
    $paymentDetails = $result['paymentDetails'];
    $statsDetails = $result['statsDetails'];
    $enduser = $result['enduser'];
    $saleData = $result['saleData'];
} catch(Pay_Api_Exception $e){
    $error = "De Pay.nl API gaf de volgende fout:<br />".$e->getMessage();
} catch(Pay_Exception $e){
    $error =  "Er is een fout opgetreden:<br />".$e->getMessage();
}
include('./views/return.phtml');
