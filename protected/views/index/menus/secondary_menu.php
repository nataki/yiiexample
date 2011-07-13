    <div id="secondarymenu">
        <?php 
        $items = array(
            array('label'=>'Home', 'url'=>array('site/index'))
        );
        $staticPages = StaticPage::model()->cache(60)->findAll();
        //$staticPages = Yii::app()->params['staticPages'];
        if (!empty($staticPages)) {
            foreach($staticPages as $staticPage) {
                $items[] = array('label'=>$staticPage->title, 'url'=>array('page/view', 'model'=>$staticPage));
            }
        }
        $items[] = array('label'=>'FAQ', 'url'=>array('help/faq'));
        $items[] = array('label'=>'Contact', 'url'=>array('help/contact'));
        
        $secondaryMenu = $this->beginWidget('ext.qs.widgets.QsMenu',array(
            'items'=>$items
        )); ?>
        
        <ul id="<?php echo $secondaryMenu->id; ?>">
        <?php foreach($secondaryMenu->items as $item) { ?>
            <a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a><?php if (!$item['last']) { ?>&nbsp;|&nbsp;<?php } ?>
        <?php } ?>
        </ul>
        <?php $this->endWidget(); ?>
    </div>