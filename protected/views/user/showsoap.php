<?php
$client=new SoapClient('http://127.0.0.1/s/index.php/service/wreader'); 
echo "\n".$client->getauth('harpreet'); 
echo "\n".$client->getemp('harpreet'); 

?>