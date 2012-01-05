<?php
$this->composePageTitle('Forgot Your Password');
$this->composePageMetaTag('description', 'Forgot Your Password');
$this->breadcrumbs=array(
	'Forgot Your Password',
);
?>

<h1>Forgot Your Password</h1>

<?php if(Yii::app()->user->hasFlash('forgotPassword')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('forgotPassword'); ?>
</div>
<?php else: ?>

<p>
Enter the e-mail address associated with your <?php echo Yii::app()->name; ?> account, then submit form.<br />
Your password will be resetted and its new value will be sent your via email.
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<?php if ( Yii::app()->user->getIsGuest() && CCaptcha::checkRequirements() ): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>

<?php endif; ?>