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

	// determinar si es creador, invitado-admin o invitado-normal, pero llevarlo al controller mejor
	//echo Yii::App()->user->id;
	$isAdmin = true;
	$this->renderPartial($isAdmin? '_form': '_formInvitee', array('model'=>$model, 'inviteesModels'=>$inviteesModels));
	
?>