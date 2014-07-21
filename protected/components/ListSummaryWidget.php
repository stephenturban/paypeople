<?php

// protected/components/SubscriberFormWidget.php
/**
* @param $id is the list_id 
* @param $parameters are the parameters to be shown 
* ListSummary Widget creates a List Summary form based upon the current ListID 
*
*/ 
class ListSummaryWidget extends CWidget
{   
    /** 
    *
    * @var $id is the current lists id 
    */ 
    public $id;



    /** 
    *  
    * This function renders the view. It passes in the $id and returns  
    *  the total due, numper of people, available accounts and the 
    */  
    public function run()
    {
        // initializes the id as the current list_id 
        $id = $this->id;
         // gives the paylist with the given $id 
        $paylist = Paylist::model()->findByPk($id);
        // returns the current User's Id
        $user_id = Login::model()->getUserId();
        // find all of the accounts under a certain user id  
        $accounts = Account::model()->findAll(array("condition"=>"user_id = $user_id"));    

        $this->render('ListSummaryWidget', array(
            // returns the total amount that is due in a paylist 
            'totaldue'=> Recipient::model()->totaldue($id), 
            // number of people in that pay list 
            'numpeople'=>$paylist->numindv,
            // gives the current accounts under a certain id
            'accounts'=> $accounts, 
            // lists the accounts for a dropdown table to s=use
            'listedAccounts'=> CHtml::listData($accounts,'id', 'name'),
            // gives the name of the current list 
            'listname'=>$paylist->name,
            // the list id
            'id'=>$id 
            ));

    }
}