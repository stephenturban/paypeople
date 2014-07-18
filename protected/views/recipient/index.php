

<?php
/* @var $this RecipientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	$listname,
);
?>
<div id="simple-div"></div>


<div class="row">
<div class="span3">
<table class="table table-bordered">
	<form action="<?php echo Yii::app()->createUrl('recipient/processpayment', array('id'=>$id)) ?>" method="post" >
 		<tr class="primary"><td> <h4>List Summary </h4> </td></tr>
 		<tr ><td>
 			&nbsp;&nbsp;<?php echo $numpeople; ?> Recipient(s)
 		</td></tr>
 		
 		<tr ><td>
 			&nbsp;&nbsp;Total Due: &nbsp;<?php echo $totaldue ?> Rwf
 		</td></tr>

       <tr> <td>  

       		<h4> Mobile Money Accounts: </h4> 
			<?php 
       			foreach($accounts as $account)
       			{
       				echo $account->name; ?>:&nbsp; <?php echo $account->balance; ?> Rwf<br> <?php  
       			}      
       		?>	

       	</td> </tr>

		<tr> <td> 
			<h4> Choose Your Account </h4>	
            <?php 
         		$accountName= CHtml::listData($accounts,'id', 'name');
				echo CHtml::dropDownList("listF",'id', $accountName); 
			?>
        </td> </tr> 
 		
 		<tr> <td> 
 			<button class="btn btn-block btn-primary " type="submit">Pay Now</button>  </td> </tr> 
		</td></tr>
	</form>

  </table>

</div>
<div class="span9"></div>
</div>
<?php
	// flash message: Tells User Warning Generated
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>



<h1> <?php echo $listname ?> </h1> 
<div class="row">
	<div class="span8 offset6">  
		<a class="btn btn-primary" href= 
    		"<?php echo Yii::app()->createUrl('recipient/processpayment', array('id'=>$id)); ?>"> Pay All </a>
		<a class="btn btn-inverse" href="<?php echo Yii::app()->createUrl('recipient/create', array('id'=>$id)); ?>" >Add User</a>
	<div class ="span4"> 
	</div> 
	</div> 
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recipient-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'name',
		'position',
		'msisdn',
		'balance',
		/* 
		* this is to implement the checklist 
		array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',   
        ),
        */
         
	),
));   ?>




