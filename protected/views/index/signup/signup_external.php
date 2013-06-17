<?php
/* @var $this SignupController */
/* @var $model SignupForm */
/* @var $form CActiveForm */
/* @var $externalAuthService QsAuthExternalService */

$this->pageTitle = 'Signup For '.Yii::app()->name;
Yii::app()->getComponent('clientScript')->registerMetaTagUnique('Sign up for '.Yii::app()->name, 'description');
$this->breadcrumbs = array(
	'Signup',
);
?>
<h1>Signup</h1>

<p>
	Unfortunally "<?php echo $externalAuthService->getTitle() ?>" does not provide us enough data about you.<br />
	Please fill the following form for sign up.
</p>

<div class="form">

	<?php $form = $this->beginWidget('CActiveForm'); ?>

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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>