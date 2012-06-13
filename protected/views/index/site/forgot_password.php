<?php
$this->pageTitle = 'Forgot Your Password At '.Yii::app()->name;
Yii::app()->clientScript->registerMetaTag('Forgot your password at '.Yii::app()->name, 'description');
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

<?php $form=$this->beginWidget('CActiveForm',array(
    'id'=>'forgot-password-form',
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
	</div>

	<?php if ( Yii::app()->user->getIsGuest() && CCaptcha::checkRequirements() ): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
        <div class="hint">Type the characters you see in the picture below.</div>
        <div>
		<?php
            $this->widget('CCaptcha',array(
                'buttonLabel'=>CHtml::image(Yii::app()->baseUrl.'/images/admin/refresh.gif', 'Get new code',array('title'=>'Get new code', 'style'=>'margin: 12px 5px;')),
            ));
        ?>
		</div>
        <?php echo $form->textField($model,'verifyCode'); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>

<?php endif; ?>