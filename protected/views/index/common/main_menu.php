    <div id="mainmenu">
        <?php 
        $mainMenu = $this->beginWidget('ext.qs.widgets.QsMenu',array(            
            //'view' => '//menus/_main_menu',
            'items'=>array(                
                array('label'=>'Home', 'url'=>array('site/index')),
                array('label'=>'About', 'url'=>array('page/view', 'url_keyword'=>'about')),                
                array('label'=>'Contact', 'url'=>array('/help/contact')),
                array('label'=>'Signup', 'url'=>array('/signup/'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Account', 'url'=>array('/account/'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
        <ul id="<?php echo $mainMenu->id; ?>">
            <?php foreach($mainMenu->items as $item) { ?>
            <li<?php if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a></li>
            <?php } ?>
        </ul>
        <?php $this->endWidget();?>
    </div><!-- mainmenu -->