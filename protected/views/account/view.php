<link rel="stylesheet" href="themes/blackboot/css/additions.css" type="text/css">
<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Your PayPeople Accounts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Add a mobile-money account', 'url'=>array('create')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1 class ="centertext" ><?php echo $model->name; ?></h1>

<div class = "row"> 

<pre class = "span4 smallbox leftbox">
  Total Deposits

     <?php echo $model->totaldeposit ?> Rwf 
</pre>

<pre class = "span4 smallbox">
  Total Payments 
      
      <?php echo $model->totalpayment ?> Rwf 
</pre>

<pre class = "span4 smallbox">
  Current Balance 
      
      <?php echo $model->balance ?> Rwf 
</pre>
</strong>

</div>

<h3 class= "centertext"> Previous Transactions 
</h3> 
<pre class = "span12 pre-scrollable smallbox">





