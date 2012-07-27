<?php
	$mainMenuItems = array(
		array(
			'label'=>'Settings',
			'items'=>array(
				array('label'=>'Site settings', 'url'=>array('site_setting/')),
				array('label'=>'Maintenance', 'url'=>array('maintenance/')),
			)
		),
		array(
			'label'=>'Content setup',
			'items'=>array(
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
		array(
			'label'=>'Email setup',
			'items'=>array(
				array('label'=>'Email Patterns', 'url'=>array('/email_pattern/')),
			)
		),
		array(
			'label'=>'Help setup',
			'items'=>array(
				array('label'=>'FAQ Categories', 'url'=>array('/faq_category/')),
				array('label'=>'FAQ', 'url'=>array('/faq/')),
			)
		),
		array(
			'label'=>'Logs',
			'items'=>array(
				array('label'=>'Auth Logs', 'url'=>array('/auth_log/')),
			)
		),
	);
?>
		<div id="sidebar_column">
			<div id="sidebar_menu">
				<?php $this->widget('ext.qs.web.widgets.QsMenu',array(
					'autoRender'=>true,
					'items'=>$mainMenuItems,
				)); ?>
			</div>
		</div>