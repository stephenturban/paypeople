<noscript> 
This page needs Javascript enabled in order to work properly. Please enable Javascript in your browser. 
</noscript> 

<?php

/* @var $this AccountController */
/* @var $dataProvider CActiveDataProvider */
// include(Yii::app()->basePath . '/components/DataColumn.php');
$this->breadcrumbs=array(
	'Accounts',
);

$this->menu=array(	
	array('label'=>'Add a mobile-money account', 'url'=>array('create')),
	array('label'=>'Manage Multiple Accounts', 'url'=>array('admin')),
);


// Include the client scripts
$baseUrl = Yii::app()->baseUrl; 
 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/ajaxScript.js');
?>




<h1>Your Accounts</h1>
<div id = "accountTable" > 
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'account-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'name',
		'mobile_comp',
		'msisdn',
		array(
			// 'class'=>'application.components.DataColumn',
			'header'=>'Balance (Rwf)',
			'name'=>'balance',
			// 'value'=> 
			// 'evaluateHtmlOptions'=>true,	
	        // 'htmlOptions'=>array('id'=>'balance'),
		), 
		array(
		'class'=>'CButtonColumn',
    	'template'=>'{manage}',
    	'buttons'=>array
    	(
        'manage' => array
        (
            'label'=>'Dashboard',
            'url'=>'Yii::app()->createUrl("account/view", array("id"=>$data->id))'
   		 ),
		),
	),
))); 
 ?>
</div> 
 <script>
	 // save the current user_id 
	var userId = "<?php echo $userId; ?>";
	/** 
	*
	* getBalance calls actionBalance in the account controller 
	* the returned table then is used to update the default displayed table
	*/ 
	function getBalance(){
		$.get('index.php?r=account/balance', { userId : userId } , function(data){
			// replaces everything under the id accountTable
			$('#accountTable').html(data);
		});
	}
	getBalance();

</script> 