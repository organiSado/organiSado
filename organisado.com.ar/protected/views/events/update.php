<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Eventos'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Actualizar',
);
/*
$this->menu=array(
	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Create Events', 'url'=>array('create')),
	array('label'=>'View Events', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);*/
?>

<h1>Actualizar Evento <?php echo $model->id; ?></h1>

<?php 
	
	$this->renderPartial('_form', array('accessLevel'=>$accessLevel, 'model'=>$model, 'inviteesModels'=>$inviteesModels, 'gallery'=>$gallery, 'xupload'=>$xupload));

?>