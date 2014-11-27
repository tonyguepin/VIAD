<?php
//Autoloader inladen zodat we niet handmatig de classes hoeven te includen
require_once('./includes/classes/Autoload.php');

$config = new Pay_Config();
$error = '';
try {
    //Beschikbare betaalmethoden ophalen (Dit zou je kunnen cachen)
    $serviceApi = new Pay_Api_Getservice();

    $apiToken = $config->apitoken;
    $serviceId = $config->service_id;
    
    if(empty($apiToken) || empty($serviceId)){
        throw new Pay_Exception('Apitoken en/of ServiceId niet geset, deze kunt u instellen in config.xml');
    }
    
    $serviceApi->setApiToken($config->apitoken);
    $serviceApi->setServiceId($config->service_id);

    $result = $serviceApi->doRequest();

    //Resultaat opschonen
    $basePath = $result['service']['basePath'];
    $paymentOptions = array();
    foreach ($result['paymentOptions'] as $paymentOption) {
        $tmpPaymentOption = array();
        $tmpPaymentOption['id'] = $paymentOption['id'];
        $tmpPaymentOption['name'] = $paymentOption['visibleName'];
        $tmpPaymentOption['image'] = $basePath . $paymentOption['path'] . $paymentOption['img'];
        if (!empty($paymentOption['paymentOptionSubList'])) {
            $tmpPaymentOption['subList'] = array();
            foreach ($paymentOption['paymentOptionSubList'] as $subItem) {
                $tmpPaymentOption['subList'][$subItem['id']] = array(
                    'id' => $subItem['id'],
                    'name' => $subItem['visibleName'],
                    'img' => $basePath . $subItem['path'] . $subItem['img'],
                );
            }
        }
        $paymentOptions[$tmpPaymentOption['id']] = $tmpPaymentOption;
    }
    //paymentOptions op naam sorteren
    $paymentOption = Pay_Helper::sortPaymentOptions($paymentOptions);

    //Kijken of het formulier verstuurd is
    if (isset($_POST['action']) && $_POST['action'] == 'startTransaction') {
        $startApi = new Pay_Api_Start();
        // token en serviceId setten
        $startApi->setApiToken($config->apitoken);
        $startApi->setServiceId($config->service_id);

        //bedrag meegeven
        $startApi->setAmount($_POST['bedrag']);

        //betaalmethode en eventueel bank meegeven
        if (!empty($_POST['optionId'])) {
            $startApi->setPaymentOptionId($_POST['optionId']);
        }

        if (!empty($_POST['optionSubId'])) {
            $startApi->setPaymentOptionSubId($_POST['optionSubId']);
        }

        
        //Naar deze pagina wordt de gebruiker teruggestuurd na de betaling
        $returnUrl = Pay_Helper::getUri() . "return.php";
       
        //De communicatie url, deze hoef je dus nu niet meer in te stellen in de admin van pay.
        $exchangeUrl = Pay_Helper::getUri() . "exchange.php";

        //de return url opgeven
        $startApi->setFinishUrl($returnUrl);
        $startApi->setExchangeUrl($exchangeUrl);

        //extra data meegeven als die is meegestuurd
        if (!empty($_POST['description'])) {
            $startApi->setDescription($_POST['description']);
        }
        if (!empty($_POST['extra1'])) {
            $startApi->setExtra1($_POST['extra1']);
        }
        if (!empty($_POST['extra2'])) {
            $startApi->setExtra2($_POST['extra2']);
        }
        if (!empty($_POST['extra3'])) {
            $startApi->setExtra3($_POST['extra3']);
        }
        if (!empty($_POST['info'])) {
            $startApi->setInfo($_POST['info']);
        }
        if (!empty($_POST['object'])) {
            $startApi->setObject($_POST['object']);
        }
        if (!empty($_POST['tool'])) {
            $startApi->setTool($_POST['tool']);
        }
        if (!empty($_POST['promotorId'])) {
            $startApi->setPromotorId($_POST['promotorId']);
        }
        if (!empty($_POST['domain_id'])) {
            $startApi->setDomainId($_POST['domain_id']);
        }
        
        $enduser = Pay_Helper::filterArrayRecursive($_POST['enduser']); 
        
        if(!empty($enduser)){
            $startApi->setEnduser($_POST['enduser']);
        }
        $products = Pay_Helper::filterArrayRecursive($_POST['products']);
        
        if(!empty($products)){        
            foreach($_POST['products']['id'] as $key => $id){
                $startApi->addProduct(
                        $_POST['products']['id'][$key], 
                        $_POST['products']['description'][$key], 
                        $_POST['products']['price'][$key], 
                        $_POST['products']['quantity'][$key], 
                        'H');
            }
        }

        if (!empty($_POST['transferData']['key'])) {
            $transferData = array();
            foreach ($_POST['transferData']['key'] as $count => $key) {
                $value = $_POST['transferData']['value'][$count];
                if (!empty($key) && !empty($value)) {
                    $transferData[$key] = $value;
                }
            }
            if (!empty($transferData)) {
                $startApi->setTransferData($transferData);
            }
        }

        // als ordernummer is meegegeven maken stellen we dit in als omschrijving
        if(!empty($_POST['orderNumber'])){
            $startApi->setDescription($_POST['orderNumber']);
        }
        
        //verzoek versturen
        $result = $startApi->doRequest();

        $transaction = array(
            'transactionId' => $result['transaction']['transactionId'],
            'paymentURL' => $result['transaction']['paymentURL'],
        );
    }
} catch (Pay_Api_Exception $e) {
    $error = "De Pay.nl API gaf de volgende fout:<br />" . $e->getMessage();
} catch (Pay_Exception $e) {
    $error = "Er is een fout opgetreden:<br />" . $e->getMessage();
}

include('./views/index.phtml');
