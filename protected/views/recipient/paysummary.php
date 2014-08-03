<link rel="stylesheet" href="themes/blackboot/css/additions.css" type="text/css">
<?php
/* @var $this RecipientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Recipients',
);

// I need to add that whenever I create the recipient I also need to add in the id 
$this->menu=array(
	array('label'=>'Create Recipient', 'url'=>Yii::app()->createUrl('recipient/create', array('id'=>$id))),
	array('label'=>'Manage Recipient', 'url'=>array('admin')),
);
?>
<h1> Payment Confirmed </h1> 
<?php // var_dump($badTransactions); ?> 
<div class="row">
<div class="span5">
<table class="table table-bordered">
	<form action="<?php echo Yii::app()->createUrl('recipient/processpayment', array('id'=>$id)) ?>" method="post" >
 		<tr class="primary"><td>Payment Summary</td></tr>
 		<tr ><td>
 		     <?php echo Yii::app()->format->formatNumber($numpeople); ?> Recipient(s)
 		</td></tr>
 		
 		<tr ><td>
 			 Total Paid: &nbsp;<?php echo Yii::app()->format->formatNumber($totaldue); ?> Rwf
 		</td></tr>

		<tr ><td> 
		Error Summary
			<div> 
 		<pre class = "span12 pre-scrollable smallbox paysummary">
 		<?php if(!isset($badTransactions))
 		{
 			echo 'All transactions completed succesfully';
 		}	
 		else 
 		{ 
 			foreach($badTransactions as $badTransaction)
 			{
 				echo 'Name:  '.$badTransaction->name; 
 				echo '  Error Message:  '.$badTransaction->status;
 				?> <br> <?php 
 			}
 		}
 		?>

 		</pre>
 	</div> 
		</td></tr>
		
		<tr> <td> 
    		Current Balance:&nbsp;<?php  echo Yii::app()->format->formatNumber($accountbalance); ?> RWF
       </td> </tr> 
 		<tr> <td> 
 			<button class="btn btn-block btn-primary " type="submit">Pay Now</button>  </td> </tr> 
		</td></tr>
	</form>

  </table>

</div>
<div class="span7"></div>
</div>