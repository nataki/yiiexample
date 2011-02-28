<?php
$this->breadcrumbs[]='Manage';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Users</h2>

<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
*/ ?>
<?php echo CHtml::link('Create User','create'); ?><br />
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
    'filter'=>$model,
    //'ajaxUpdate'=>false,
    //'selectableRows'=>1,
    //'filterPosition'=>'body',
	//'summaryText'=>'{start}-{end} of {count}',
    'pager' => array(
        'class'=>'CLinkPager',
        'pages' => array(
            'pageSize' => 2
        ),
    ),
	'columns'=>array(
		'id',
		'name',
		//'password',
        'email',
		'status.name:text:Status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
