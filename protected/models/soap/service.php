<?php
     // remember when we use require this is  essentially importing in a file that we need
     require 'lib/nusoap.php';
     require 'functions.php';
     $server= new nusoap_server();
     $server->configureWSDL("demo", "urn:demo");

     $server->register(
                    "price",  // name of the function
                    array("name"=>'xsd:string'), // inputs
                    array("return"=>"xsd:intger") // outputs 
                    );

     $server->register(
                    "books_sold",  // name of the function
                    array("name"=>'xsd:string', "year"=>"xsd:intger"), // inputs
                    array("return"=>"xsd:intger") // outputs 
                    );
     

      $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
      $server->service($HTTP_RAW_POST_DATA);
?>