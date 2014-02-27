<?php
/* @var $this WallController */
/* @var $model Wall */

$this->breadcrumbs=array(
	'Walls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Wall', 'url'=>array('index')),
	array('label'=>'Manage Wall', 'url'=>array('admin')),
);
?>

<h1>Create Wall</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>