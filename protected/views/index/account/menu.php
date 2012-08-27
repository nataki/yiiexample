<?php /* @var $this AccountController */ ?>
		<div id="sidebar">
		<?php $menu = $this->beginWidget('ext.qs.web.widgets.QsMenu',array(
				'items'=>array(
					array('label'=>'Overview', 'url'=>array("{$this->id}/")),
					array('label'=>'Profile', 'url'=>array('profile')),
				),
			)); ?>
			<ul id="<?php echo $menu->id; ?>">
				<?php foreach ($menu->items as $item) { ?>
				<li<?php if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a></li>
				<?php } ?>
			</ul>
		<?php $this->endWidget(); ?>
		</div>