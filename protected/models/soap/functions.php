<?php
function price ($name)
{
          $details=array(
                    'abc'=>100,
                    'xyz'=>200
                    );
         
          foreach($details as $n=>$p)
          {
               if($name==$n)
                    $price=$p;
          }
          return $price;
}


function books_sold ($name, $year)
{   
     $titles = array( 
                'harry potter'=>array(2000=>500, 2001=>600),
                'the bible'=>array(2000=>600, 2001=>1000)); 

     
     foreach($titles as $nm=>$yeararray)
     {
          if ($nm==$name)
          {
               foreach($yeararray as $yr=>$bsold)
               {
                    if ($year==$yr)
                    {
                         $numsold=$bsold;
                    }

               }

          }
               
     }
     return $numsold;
}
?>
