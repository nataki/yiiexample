<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>		
        <?php echo $form->textArea($model,'description',array('cols'=>60,'rows'=>4)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'keywords'); ?>
        <?php echo $form->textArea($model,'keywords',array('cols'=>60,'rows'=>4)); ?>
        <?php echo $form->error($model,'keywords'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->