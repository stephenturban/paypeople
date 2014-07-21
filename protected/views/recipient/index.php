

<?php

/* @var $this RecipientController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	$listname,
);
?>

<div id="simple-div"></div>


<h1> <?php echo $listname ?> </h1> 
<div class="row">
	<div class="span8 offset5">  
		<a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('recipient/create', array('id'=>$id)); ?>" >Add Recipient</a>
		<a class="btn btn-inverse" href="<?php echo Yii::app()->createUrl('recipient/admin', array('id'=>$id)); ?>" >Manage Recipients</a>
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
));   

?>





