<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->email=>array('view','id'=>$model->email),
	'Actualizar',
);
/*
$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'View Users', 'url'=>array('view', 'id'=>$model->email)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);*/
?>

<h1>Actualizar registro de <?php echo $model->first_name.' '.$model->last_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>