<?php
/* @var $this Site_settingController */
/* @var $models array of SiteSetting */
/* @var $form CActiveForm */

$this->sectionTitle = 'Update Site Settings';
?>

<?php if (Yii::app()->user->hasFlash('form_result')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('form_result'); ?>
</div>
<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($models); ?>

	<?php foreach ($models as $i => $model):?>
		<?php echo CHtml::label("{$model->title}:", false, array('required'=>$model->is_required) ); ?>
		<div class="row">
		<?php switch ($model->name):
			/*case 'default_language_id': {
				echo $form->dropDownList($model,'['.$model->getPrimaryKey().']value',array());
			}*/
			default: {
				echo $form->textField($model,'['.$model->getPrimaryKey().']value',array('size'=>80,'maxlength'=>255));
			} ?>
		<?php endswitch;?>
		</div>
		<?php echo $form->error($model,"value"); ?>
		<p class="note"><?php echo $model->description; ?></p>
	<?php endforeach;?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Update'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->