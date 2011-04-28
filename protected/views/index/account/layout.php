<?php $this->beginContent('//layouts/main'); ?>    
    <div class="span-18">
        <h2><?php echo $this->sectionTitle; ?></h2>
        <?php echo $content; ?>
    </div>
    <div class="span-5 last">
        <?php $this->renderPartial("//{$this->id}/menu"); ?>
    </div>
<?php $this->endContent(); ?>