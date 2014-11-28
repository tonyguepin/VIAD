<?php

class Pay_Config{
    /**
     *
     * @var SimpleXMLElement
     */
   protected $_objXml;
   public function __construct(){
       $dir = realpath(dirname(__FILE__));
       $this->_objXml = simplexml_load_file($dir.'/../../../config.xml');       
   } 

   public function __get($name) {
   	if(empty($this->_objXml->$name)){
   		throw new Pay_Exception(sprintf("`%s' niet geset, deze kunt u instellen in config.xml", $name));
   	}
    return (string) $this->_objXml->$name;
   }
}