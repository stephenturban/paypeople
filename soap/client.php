<?php
      require 'lib/nusoap.php';
      $client=new nusoap_client("http://localhost/paypeople/soap/service.php?wsdl");
      $book_name ='xyz';
      // remember that "name" is what it will be referred to, "xyz" is the value (key value pair)
      $price = $client->call('price', array("name"=>$book_name));
      $booksold = $client->call('books_sold', array("name" =>'harry potter', "year"=>2000));
      if (empty($price))
      {
      	echo 'this is not a valid book name';
      }
      else 
      	echo 'this is the price: '.$price;
  	  	echo '/n and this is the number of books sold:'.$booksold;
   

  ?>   

