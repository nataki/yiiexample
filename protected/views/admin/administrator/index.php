<?php
$this->sectionTitle = 'Manage Administrators';

$this->contextMenuItems = array(
    array('label'=>'Create Administrator', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
    'filter'=>$model,
    'pager' => array(
        'class'=>'CLinkPager',
    ),
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
		'name',
		//'password',
        'email',
        'create_date:strdate',
		//'status.name:text:Status',
        array(
            'header'=>'Status',
            'name'=>'status_id',
            'filter'=>CHtml::listData(UserStatus::model()->findAll(), 'id', 'name'),
            'value'=>'$data->status->name',
        ),
	),
)); ?>
