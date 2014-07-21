<?php $this->beginContent('//layouts/main'); ?>
      <div class="row-fluid">
        <div class="span3">
        <?php 
          $this->widget('ListSummaryWidget', array('id'=>$this->id)); 
        ?>
        </div><!-- sidebar span3 -->
    	<div class="span9">
		<div class="main">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent();  ?>