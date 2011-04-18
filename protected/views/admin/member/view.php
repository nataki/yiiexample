<?php
$this->sectionTitle = 'View Member #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
    array('label'=>'Back To List', 'url'=>array('index')),
    array('label'=>'Create Member', 'url'=>array('create')),
    array('label'=>'Update Member', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Member', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),    
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'group.name:html:Group',
        'status.name:html:Status',
		'name',
		//'password',
        'email',
		'create_date:strdate',
        array(
            'label'=>'Full name',
            'value'=>$model->first_name.' '.$model->last_name,
        ),
        'profile.postal_code',
        'profile.city',
        'profile.address1',
        'profile.address2',                
        'profile.phone_home',
        'profile.phone_mobile',
	),
)); ?>