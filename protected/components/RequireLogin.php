<?php
class RequireLogin extends CBehavior
{

	// this function calls the handler BeginRequest 
	public function attach($owner)
	{
		$owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
	}


	public function handleBeginRequest($event)
	{
			
			// If the user is guest and the directory sent to is not the base, site/login, or site/index 
			// redirect using loginRequired
			if (Yii::app()->user->isGuest && !in_array($_GET['r'],array('site/login', 'site/index', '', 'login/create'))) {
		    Yii::app()->user->loginRequired();
			}
			
	}
}
?>