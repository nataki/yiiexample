<?php
$this->sectionTitle = 'Manage Site Settings';

$this->contextMenuItems = array(
    array('label'=>'Update Values', 'url'=>array('index')),
    array('label'=>'Create Site Setting', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
        'name',
		'value',
        array(
            'name'=>'is_required',
            'value'=>'$data->is_required ? Yes: no;',
        ),
		'title',		
	),
)); ?>
