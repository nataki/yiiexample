<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
    <?php if( Yii::app()->user->allowAutoLogin ) { ?>
    <div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
    <?php } ?>

    <?php if ( CCaptcha::checkRequirements() ): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
        <div class="hint">Type the characters you see in the picture below.</div>
        <div>
		<?php
            $this->widget('CCaptcha',array(
                'buttonLabel'=>CHtml::image(Yii::app()->baseUrl.'/images/admin/refresh.gif', 'Get new code',array('style'=>'margin: 12px 5px;')),
            ));
        ?>
		</div>
        <?php echo $form->textField($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
