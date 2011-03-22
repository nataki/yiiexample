    <div id="mainmenu">
        <?php //$this->widget('zii.widgets.CMenu',array(
        $this->widget('ext.qs.widgets.QsMenu',array(
            'view' => '//menus/_main_menu',
            'items'=>array(
                //array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'Home', 'url'=>array('/')),
                //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'About', 'url'=>array('/about')),
                //array('label'=>'Contact', 'url'=>array('/site/contact')),                
                array('label'=>'Contact', 'url'=>array('/help/contact')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
    </div><!-- mainmenu -->