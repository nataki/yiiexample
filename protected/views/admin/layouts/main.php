<?php $this->beginContent('//layouts/overall'); ?>
<div id="main">
    <?php if (!Yii::app()->user->isGuest) { ?>
        <?php $this->renderPartial('//common/main_menu'); ?>
    <?php } ?>
        <div id="entry">
            <?php if (!Yii::app()->user->isGuest) { ?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'homeLink'=>CHtml::link('Administration', $this->createUrl('site/index')),                
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
            <?php } ?>
            
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
            
        </div>    
</div>

<?php $this->endContent(); ?>