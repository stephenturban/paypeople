<?php
/* @var $this AccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounts',
);

$this->menu=array(
	array('label'=>'Add a mobile-money account', 'url'=>array('create')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>Your Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
