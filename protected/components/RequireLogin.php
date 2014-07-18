<?php
class RequireLogin extends CBehavior
{
	public function attach($owner)
	{
    	$owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
	}

	public function handleBeginRequest($event)
	{
	// if  I wanted to allow access to other pages, say the index or something that is very common
	// I could do that by adding other sites after the array('site/login')
	// if (Yii::app()->user->isGuest && !in_array($_GET['r'],array('site/login', 'site/index', 'site/contact'))) 
    	if (Yii::app()->user->isGuest && !in_array($_GET['r'],array('site/login'))) {
        Yii::app()->user->loginRequired();
    	}
	}
}
?>