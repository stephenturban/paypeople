<?php
$balanceHeader = 'Balance (Rwf)';
if (isset($error))
{
 	$balanceHeader = 'Previous Balance'; 
 	echo 'You could not connect to tigo cash. Here is your previous saved balance.';
}
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'account-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'name',
		'mobile_comp',
		'msisdn',
		// this formats the balance
		'balance'=> 
		 array( 
		'name'=>'balance',
		'header'=>''.$balanceHeader.'',
		),
	/*
		'company',
		*/ 

		array(
		'class'=>'CButtonColumn',
    	'template'=>'{manage}',
    	'buttons'=>array
    	(
        'manage' => array
        (
            'label'=>'Manage',
            'url'=>'Yii::app()->createUrl("account/view", array("id"=>$data->id))'
   		 ),
		),
	),
))); 
 ?>