<?php /* @var $this AdminBaseController */ ?>
<?php
	$mainMenuItems = array(
		array(
			'label' => 'Settings',
			'items' => array(
				array('label'=>'Site settings', 'url'=>array('sitesetting/')),
				array('label'=>'Maintenance', 'url'=>array('maintenance/')),
			)
		),
		array(
			'label' => 'Users setup',
			'items' => array(
				array('label'=>'Administrators', 'url'=>array('/administrator/')),
				array('label'=>'Members', 'url'=>array('/member/')),
			)
		),
		array(
			'label' => 'Content setup',
			'items' => array(
				array('label'=>'Static Pages', 'url'=>array('/staticpage/')),
			)
		),
		array(
			'label' => 'Email setup',
			'items' => array(
				array('label'=>'Email Patterns', 'url'=>array('/emailpattern/')),
			)
		),
		array(
			'label' => 'Help setup',
			'items' => array(
				array('label'=>'FAQ Categories', 'url'=>array('/faqcategory/')),
				array('label'=>'FAQ', 'url'=>array('/faq/')),
			)
		),
		array(
			'label' => 'Logs',
			'items' => array(
				array('label'=>'Auth Logs', 'url'=>array('/authlog/')),
			)
		),
	);
?>
		<div id="sidebar_column">
			<div id="sidebar_menu">
				<?php $this->widget('ext.qs.lib.web.widgets.QsMenu',array(
					'autoRender' => true,
					'items' => $mainMenuItems,
				)); ?>
			</div>
		</div>