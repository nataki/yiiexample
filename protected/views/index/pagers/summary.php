<div class="<?php echo $cssClass; ?>">
	<?php if ($count <= 0) { ?>
	No result(s) to display.
	<?php } else { ?>
	Displaying <?php if ($start>0) { ?><?php echo $start; ?>-<?php echo $end; ?> of <?php } ?><?php echo $count; ?> result(s).
	<?php } ?>
</div>