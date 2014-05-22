<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Eventos'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Lista de Eventos', 'url'=>array('index')),
	array('label'=>'Crear Evento', 'url'=>array('create')),
	array('label'=>'Actualizar Evento', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Evento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que quieres borrar este evento?')),
	//array('label'=>'Manage Events', 'url'=>array('admin')),
);
?>

<h1>Ver Eventos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'date',
		'time',
		'description',
		'creator',
		'location_name',
		'location_address',
		'location_lat',
		'location_long',
		'confirmation_closed',
		'cost_mode',
		'cost_val1',
		'cost_val2',
	),
)); ?>
