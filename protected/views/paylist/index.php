<?php
/* @var $this PaylistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Paylists',
);

$this->menu=array(
	array('label'=>'Create Paylist', 'url'=>array('create')),
	array('label'=>'Manage Paylist', 'url'=>array('admin')),
);



?>

<h1>Paylists</h1>


<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'paylist-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'name',
		'numindv',
		// the virtual attribute totaldue is formmated in the model 
		'totaldue',
		'due_date',
		
		/*
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
    		'template'=>'{Manage}',
    		'buttons'=>array
			(
			    'Manage' => array
			    (
			        'label'=>'Manage',
			        'url'=>'Yii::app()->createUrl("recipient/index", array("id"=>$data->id))',
			    ),
			    
    		)
		),
	),
)); ?>


<?
/* php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',


)); 
*/ ?>
