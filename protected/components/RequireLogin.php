<?php
class RequireLogin extends CBehavior
{

	public function attach($owner)
	{
		echo  'this is the path info'.$_GET['r']; 
		$owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
	}


	public function handleBeginRequest($event)
	{
			//echo $_GET['r']; 
			echo  ' this is the path info'.$_GET['r']; 

			// if  I wanted to allow access to other pages, say the index or something that is very common
			// I could do that by adding other sites after the array('site/login')
			// if (Yii::app()->user->isGuest && !in_array($_GET['r'],array('site/login', 'site/index', 'site/contact'))) 
			if (Yii::app()->user->isGuest && !in_array($_GET['r'],array('site/login', 'site/index'))) {
		    Yii::app()->user->loginRequired();
			}
	}
}
?>