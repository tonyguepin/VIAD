<?php
//autoloader inladen
require_once('./includes/classes/Autoload.php');
try{
    $config = new Pay_Config();

    //Het transactie id
    $orderId = $_GET['order_id'];

    // Voor de veiligheid negeren we de rest van de data die is meegegeven in de url, 
    // we halen zelf de transactie op bij pay en we kijken wat daar de status van is
    $apiInfo = new Pay_Api_Info();

    $apiInfo->setApiToken($config->apitoken);
    $apiInfo->setServiceId($config->serviceId);

    $apiInfo->setTransactionId($orderId);

    $result = $apiInfo->doRequest();
    
    $state = $result['paymentDetails']['state'];
    $stateText = Pay_Helper::getStateText($state);
    
} catch(Pay_Api_Exception $e){
    $error = "De Pay.nl API gaf de volgende fout:<br />".$e->getMessage();
} catch(Pay_Exception $e){
    $error =  "Er is een fout opgetreden:<br />".$e->getMessage();
}

if(empty($error)){
    echo "TRUE|Statusupdate ontangen. Status is: ".$state.' ('.$stateText.')';
} else {
    echo "TRUE|".$error;
}