<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <h2><?php echo CHtml::encode($this->sectionTitle); ?></h2>
    <div class="access_actions">    
        <?php
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->contextMenuItems,
                'htmlOptions'=>array('class'=>'operations'),
            ));
        ?>
    </div><!-- .acces_actions-->    
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>