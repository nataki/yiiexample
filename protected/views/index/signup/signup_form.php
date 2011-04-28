<?php
$this->breadcrumbs=array(
	'Signup',
);
?>
<h1>Signup</h1>

<p>
Fill the follwing form to signup.
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

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

    <?php if (CCaptcha::checkRequirements()): ?>
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