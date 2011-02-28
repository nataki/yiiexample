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
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'file'); ?>
        <?php echo $form->fileField($model,'file'); ?>
        <?php echo $form->error($model,'file'); ?>        
    </div>
    
	<div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php $this->widget('ext.qs.widgets.QsButtonLink', array('label'=>'Back','url'=>array('index') ) ); ?>        
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->