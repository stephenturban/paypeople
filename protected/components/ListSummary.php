<?php

// protected/components/SubscriberFormWidget.php
/**
* ListSummary Widget creates a List Summary form based upon the current ListID 
*
*/ 
class ListSummarymWidget extends CWidget
{
    /**
     * @var CFormModel
     */
    public $form;

    public function run()
    {
        if (! $this->form instanceof CFormModel) {
            throw new RuntimeException('No valid form available.');
        }
        $this->render('ListSummaryWidget', array('form'=>$this->form));
    }
}