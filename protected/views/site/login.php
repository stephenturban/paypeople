<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <kbd> turban@axis.rw </kbd> <kbd>with the password paypeople </kbd> 
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<!-- 
	<a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('site/login'); ?>" >Log-in</a>
	<a class="btn btn-inverse" href="<?php echo Yii::app()->createUrl('login/create'); ?>" >Create An Account</a>
	-->
	<div class = "row"> 
	<button class="span2 offset1 btn btn-inverse" type="submit">Log-in</button>
	<a class="span2 btn btn-primary" href="<?php echo Yii::app()->createUrl('login/create'); ?>">Create An Account</a>
	</div>
	<!-- 
	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	<div class="buttons">
		<?php echo CHtml::submitButton('Create'); ?>
	</div>
-->

<?php $this->endWidget(); ?>
</div><!-- form -->
