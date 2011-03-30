
<div class="row">
	<h4>
		<span id="hidetime_wait"></span>
		Hide Time:		
		<input type="checkbox" name="hidetime" id="hidetime" value="<?php echo $hide; ?>" 
		<?php echo ($hide ? 'checked="checked"' : ''); ?> onclick="toggleHideTime('<?php echo url::site(); ?>', '<?php echo $report_id; ?>'); "/>
		<span>Checking this will hide the time.</span>
	</h4>	
</div>

