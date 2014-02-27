<?php
/* @var $this WallController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Walls',
);

$this->menu=array(
	array('label'=>'Create Wall', 'url'=>array('create')),
	array('label'=>'Manage Wall', 'url'=>array('admin')),
);
?>

<h1>Walls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
