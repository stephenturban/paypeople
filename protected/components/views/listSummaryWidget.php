<?php 
// protected/components/views/subscriberFormWidget.php
/** 
* This is the view file for list Summary Widget,
* It displays the data of the the list in question and allows the user to choose an account to pay with 
*
**/ 
?> 
	<table class="table list_summary table-bordered">
	
	<form action= "<?php echo Yii::app()->createUrl('recipient/processpayment', array('id'=> $id)) ?>" method="post" >
 		
 		<tr class="primary"><td> <h4>List Summary </h4> </td></tr>
 		
 		<tr ><td>
 			&nbsp;&nbsp;<?php echo $numpeople; ?> Recipient(s)
 		</td></tr>
 		
 		<tr ><td>
 			&nbsp;&nbsp;Total Due: &nbsp;<?php echo $totaldue ?> Rwf
 		</td></tr>

        <tr> <td>  

       		<h4> 
       			Mobile Money Accounts: 
       		</h4> 
			
			<?php 
			
       			foreach($accounts as $account)
       			{
       				echo $account->name; ?>:&nbsp; <?php echo $account->balance; ?> Rwf<br> <?php  
       			}     
       		?>

      	</td> </tr>

        <tr> <td>

			<h4> 
				Choose Your Account
			</h4>	
            
            <?php 
            	echo CHtml::dropDownList("listF",'id', $listedAccounts); 	
			?>

        </td> </tr> 

 		
 		<tr> <td> 
 			<button class="btn btn-block btn-primary " type="submit">Pay Now</button>  </td> </tr> 
 			<?php
	// flash message: Tells User Warning Generated
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }


	?>
		</td></tr>

	</form>

  </table>
