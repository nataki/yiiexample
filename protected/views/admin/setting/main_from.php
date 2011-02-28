<h1>Settings</h1>

<?php if(Yii::app()->user->hasFlash('form_result')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('form_result'); ?>
</div>

<?php endif; ?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

    <?php /*<p class="note">Fields with <span class="required">*</span> are required.</p>*/ ?>

    <?php /*echo $form->errorSummary($model);*/ ?>

    <?php foreach($items as $i => $model):?>
    
    <div class="row">
        <?php echo CHtml::label("{$model->description}:", false); ?>
        <?php echo $form->textField($model,"[$i]value",array('size'=>80,'maxlength'=>255)); ?>
        <?php echo $form->error($model,"value"); ?>
    </div>

    <?php endforeach;?>
        

    <div class="row buttons">
        <?php echo CHtml::submitButton('Update'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->