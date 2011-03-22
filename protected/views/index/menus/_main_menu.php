<ul id="yw0">
<?php foreach($items as $item) { ?>
<li<?php if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a></li>
<?php } ?>
</ul>