<?php
    $this->mainMenuItems = array(
        array(
            'label'=>'Settings', 
            'items'=>array(
                    array('label'=>'Site settings', 'url'=>array('setting/'))
            )
        ),
        array(
            'label'=>'Content setup', 
            'items'=>array(
                //array('label'=>'Page Metas', 'url'=>array('/page_meta/index')),
                array('label'=>'Page Metas', 'url'=>array('/page_meta/')),
                array('label'=>'Static Pages', 'url'=>array('/static_page/')),
            )
        ),
        array(
            'label'=>'Users setup', 
            'items'=>array(
                array('label'=>'Administrators', 'url'=>array('/administrator/')),
                array('label'=>'Members', 'url'=>array('/member/')),
            )
        ),                    
    );
?>
        <div id="sidebar_column">
            <div id="sidebar_menu">
                <?php $this->widget('ext.qs.widgets.QsMenu',array(
                    'autoRender'=>true,
                    'items'=>$this->mainMenuItems,
                )); ?>
            </div>
        </div>