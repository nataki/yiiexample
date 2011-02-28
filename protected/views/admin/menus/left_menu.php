<?php
    $this->leftMenu=array(
        array('label'=>'Settings', 'url'=>array('/setting/index')),
        array('label'=>'Users', 'url'=>array('/user/index')),        
        array('label'=>'Page Metas', 'url'=>array('/page_meta/index')),
    );
?>
    <div id="sidebar" style="padding:20px;">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Administration',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->leftMenu,
                'htmlOptions'=>array('class'=>'operations'),                
            ));
            $this->endWidget();
        ?>
    </div><!-- sidebar -->