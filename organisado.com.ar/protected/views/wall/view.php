<?php
/* @var $this WallController */
/* @var $model Wall */

$this->breadcrumbs=array(
	'Walls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Wall', 'url'=>array('index')),
	array('label'=>'Create Wall', 'url'=>array('create')),
	array('label'=>'Update Wall', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Wall', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Wall', 'url'=>array('admin')),
);
?>

<h1>View Wall #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'event',
		'message',
		'attachment_url',
	),
)); ?>
