		<div class="top-menus">
		<?php echo CHtml::link('main application',Yii::app()->homeUrl); ?>
		<?php if (!Yii::app()->user->isGuest): ?>
			| <?php echo CHtml::link('logout',array('/site/logout')); ?>
		<?php endif; ?>
		</div>