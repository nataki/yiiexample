<?php
/* @var $this AccountController */
/* @var $model Member */
/* @var $form CActiveForm */

$this->pageTitle = 'Edit Your Profile At '.Yii::app()->name;
Yii::app()->getComponent('clientScript')->registerMetaTagUnique('Edit your profile at '.Yii::app()->name, 'description');

$this->sectionTitle = 'Edit Profile';
$this->breadcrumbs[] = 'Profile';
?>

<?php if (Yii::app()->user->hasFlash('account_profile')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('account_profile'); ?>
</div>
<?php endif; ?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model->profile,'first_name'); ?>
		<?php echo $form->textField($model->profile,'first_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'last_name'); ?>
		<?php echo $form->textField($model->profile,'last_name'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>