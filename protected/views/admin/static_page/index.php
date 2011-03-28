<?php
$this->sectionTitle = 'Manage Static Pages';

$this->contextMenuItems = array(
    array('label'=>'Create Static Page', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'action',
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
