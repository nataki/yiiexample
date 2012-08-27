<?php /* @var $this IndexController */ ?>
<?php
$cacheOptions = array(
	'duration' => 3600*24,
	'varyByRoute'=>false,
	'dependency' => array(
		'class'=>'CFileCacheDependency',
		'fileName'=>__FILE__
	)
);
if ($this->beginCache('secondaryMenuHtml', $cacheOptions)) { 
?>
	<div id="secondarymenu">
		<?php
		$items = array(
			array('label'=>'Home', 'url'=>array('site/index'))
		);
		$staticPages = StaticPage::model()->findAll();
		if (!empty($staticPages)) {
			foreach ($staticPages as $staticPage) {
				$items[] = array('label'=>$staticPage->title, 'url'=>array('page/view', 'model'=>$staticPage));
			}
		}
		$items[] = array('label'=>'FAQ', 'url'=>array('help/faq'));
		$items[] = array('label'=>'Contact', 'url'=>array('help/contact'));

		$secondaryMenu = $this->beginWidget('ext.qs.web.widgets.QsMenu',array(
			'items'=>$items
		)); ?>

		<ul id="<?php echo $secondaryMenu->id; ?>">
		<?php foreach ($secondaryMenu->items as $item) { ?>
			<a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a><?php if (!isset($item['last'])) { ?>&nbsp;|&nbsp;<?php } ?>
		<?php } ?>
		</ul>
		<?php $this->endWidget(); ?>
	</div>
<?php $this->endCache(); } ?>