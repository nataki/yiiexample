<?php
	$offsetStep = 40;
	$fontColor = $failed ? $this->colors['failed'] : ($incomplete ? $this->colors['incomplete'] : $this->colors['success']);
	$leftOffset = $level*$offsetStep;
?>
<div class="test-info" style="border-color: <?php echo $fontColor; ?>; margin-left:<?php echo $leftOffset; ?>px; color:<?php echo $fontColor; ?>;">
<?php echo $content; ?>
</div>
