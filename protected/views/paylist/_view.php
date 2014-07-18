<?php
/* @var $this PaylistController */
/* @var $data Paylist */
?>

<div class="view">
	<div class="row">
		<div class="span4">
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('due_date')); ?>:</b>
	<?php echo CHtml::encode($data->due_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	</div>
	<div class="span8">
		<div id="manage_button">
<a class="btn btn-info" type="button" href="index.php?r=recipient/index&id=<?php echo $data->id; ?>">Manage</a>
<?php
// Previous attempts to create a button for PayPeoplle 
// echo $list_id = $data->id;
// echo CHtml::link('Manage',array('recipient/index', 'id'=>$list_id)); 
?>
</div>
	</div>
	</div>


</div>