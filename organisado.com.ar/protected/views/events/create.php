<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'Create Events', 'url'=>array('index')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);
 */

?>

<h1>Crear Evento</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'inviteesModels'=>$inviteesModels)); ?>