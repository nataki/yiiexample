    <div id="secondarymenu">
        <?php 
        $items = array(
            array('label'=>'Home', 'url'=>array('/site/index'))
        );
        //$staticPages = StaticPage::model()->findAll();
        $staticPages = Yii::app()->params['staticPages'];
        if (!empty($staticPages)) {
            foreach($staticPages as $staticPage) {
                $items[] = array('label'=>$staticPage->title, 'url'=>array('/'.$staticPage->action));
            }
        }
        
        $this->widget('zii.widgets.CMenu',array(
            'items'=>$items
        )); ?>
    </div>