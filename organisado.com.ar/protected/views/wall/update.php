<?php
/* @var $this WallController */
/* @var $model Wall */

$this->breadcrumbs=array(
	'Walls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wall', 'url'=>array('index')),
	array('label'=>'Create Wall', 'url'=>array('create')),
	array('label'=>'View Wall', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Wall', 'url'=>array('admin')),
);
?>

<h1>Update Wall <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>