<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'model-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data',
	)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id');?>
		<?php echo $form->dropDownList($model, 'status_id', CHtml::listData(UserStatus::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_password'); ?>
		<?php echo $form->passwordField($model,'new_password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'new_password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'new_password_repeat'); ?>
		<?php echo $form->passwordField($model,'new_password_repeat',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'new_password_repeat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<?php /* Member Profile data: */ ?>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'first_name'); ?>
		<?php echo $form->textField($model->profile,'first_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'first_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'last_name'); ?>
		<?php echo $form->textField($model->profile,'last_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'last_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'postal_code'); ?>
		<?php echo $form->textField($model->profile,'postal_code',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'postal_code'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'city'); ?>
		<?php echo $form->textField($model->profile,'city',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'city'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'address1'); ?>
		<?php echo $form->textField($model->profile,'address1',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'address1'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'address2'); ?>
		<?php echo $form->textField($model->profile,'address2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'address2'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'phone_home'); ?>
		<?php echo $form->textField($model->profile,'phone_home',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'phone_home'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model->profile,'phone_mobile'); ?>
		<?php echo $form->textField($model->profile,'phone_mobile',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model->profile,'phone_mobile'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->