<?php
/* @var $this EventsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Events',
);

/*
$this->menu=array(
	array('label'=>'Crear Evento', 'url'=>array('create')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);
 
 */
?>

<h1>Eventos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
	