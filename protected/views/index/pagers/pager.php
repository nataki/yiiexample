<div class="pager">
    <?php echo $widget->header; ?>
    <ul id="<?php $widget->id; ?>" class="yiiPager">
        <?php foreach($widget->buttons as $button) { ?>
        <li class="<?php echo $button['class']; ?>"><a href="<?php echo $button['url']; ?>"><?php echo $button['label']?></a></li>
        <?php } ?>
    </ul>
</div>