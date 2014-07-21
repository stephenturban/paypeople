<?php $this->beginContent('//layouts/main'); ?>
      <div class="row-fluid">
        <div class="span3">

    		<table class="table list_summary table-bordered">
	<form action="<?php echo Yii::app()->createUrl('recipient/processpayment', array('id'=>$id)) ?>" method="post" >
 		<tr class="primary"><td> <h4>List Summary </h4> </td></tr>
 		<tr ><td>
 			&nbsp;&nbsp;<?php echo $data['totaldue']; ?> Recipient(s)
 		</td></tr>
 		
 		<tr ><td>
 			&nbsp;&nbsp;Total Due: &nbsp;<?php echo $this->total ?> Rwf
 		</td></tr>

       <tr> <td>  

       		<h4> Mobile Money Accounts: </h4> 
			<?php 
			/* 
       			foreach($accounts as $account)
       			{
       				echo $account->name; ?>:&nbsp; <?php echo $account->balance; ?> Rwf<br> <?php  
       			} 
       			*/      
       		?>	

       	</td> </tr>
 		
 		<tr> <td> 
 			<button class="btn btn-block btn-primary " type="submit">Pay Now</button>  </td> </tr> 
		</td></tr>
	</form>

  </table>


        </div><!-- sidebar span3 -->
    	<div class="span9">
		<div class="main">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent();  ?>