    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
        //$this->widget('ext.qs.widgets.WMainMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>dirname( Yii::app()->homeUrl )),
                array('label'=>'Administration', 'url'=>array('/site/index')),
                /*array('label'=>'Users', 'url'=>array('/user/index')),
                array('label'=>'Settings', 'url'=>array('/setting/index')),*/
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
    </div><!-- mainmenu -->