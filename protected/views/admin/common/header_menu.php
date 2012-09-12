<?php /* @var $this AdminBaseController */ ?>
<?php if (!Yii::app()->user->isGuest): ?>
		<div class="header_actions">
			Welcome <b><?php echo Yii::app()->getComponent('user')->name?></b>&nbsp;&nbsp;<br />
			<?php echo CHtml::link('Administration', array('/site/index'));?>&nbsp;&nbsp;
			<?php echo CHtml::link('Home', Yii::app()->baseUrl);?>&nbsp;&nbsp;
			<?php echo CHtml::link('Logout', array('/site/logout'));?>&nbsp;&nbsp;
		</div>
<?php endif; ?>