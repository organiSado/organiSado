<?php
/* @var $this TourController */
/* @var $model Tour */

$this->breadcrumbs=array(
	'Tours'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tour', 'url'=>array('index')),
	array('label'=>'Manage Tour', 'url'=>array('admin')),
);
?>

<h1>Create Tour</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>