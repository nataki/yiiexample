<?php /*CVarDumper::dump($buttons, 10, true);*/ ?>
<div class="pager">
    <?php echo $pager->header; ?>
    <ul id="yw1" class="yiiPager">
        <?php foreach($buttons as $button) { ?>
        <li class="<?php echo $button['class']; ?>"><a href="<?php echo $button['url']; ?>"><?php echo $button['label']?></a></li>
        <?php } ?>        
    </ul>
</div>
