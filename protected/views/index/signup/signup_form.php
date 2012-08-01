<?php
/* @var $this SignupController */
/* @var $model SignupForm */
/* @var $form CActiveForm */

$this->pageTitle = 'Signup For '.Yii::app()->name;
Yii::app()->clientScript->registerMetaTag('Sign up for '.Yii::app()->name, 'description');
$this->breadcrumbs=array(
	'Signup',
);
?>
<h1>Signup</h1>

<p>
Fill the following form for sign up.
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_password'); ?>
		<?php echo $form->passwordField($model,'new_password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'new_password_repeat'); ?>
		<?php echo $form->passwordField($model,'new_password_repeat'); ?>
	</div>

	<?php if (CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php
			$this->widget('CCaptcha',array(
				'buttonLabel'=>CHtml::image(Yii::app()->baseUrl.'/images/index/refresh.gif', 'Get new code',array('title'=>'Get new code', 'style'=>'margin: 12px 5px;')),
			));
		?>
		</div>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>