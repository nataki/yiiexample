<?php
$this->breadcrumbs[]=$model->id;
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'group.name:html:Group',
        'status.name:html:Status',
		'name',
		'password',
        'email',
		'create_date',
	),
)); ?>
<div>
<?php $this->widget('ext.qs.widgets.QsButtonLink', array('label'=>'Back to list','url'=>array('index') ) ); ?>
<?php $this->widget('ext.qs.widgets.QsButtonLink', array('label'=>'Update User','url'=>array('update', 'id'=>$model->id) ) ); ?>
<?php $this->widget('ext.qs.widgets.QsButtonLink', array('label'=>'Delete User','url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?') ) ); ?>    
</div>