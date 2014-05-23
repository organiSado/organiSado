<?php
/* @var $this EventsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Eventos',
);

/*
$this->menu=array(
	array('label'=>'Crear Evento', 'url'=>array('create')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);
 
 */
?>

<h1>Eventos</h1>

<?php
	
$this->widget('zii.widgets.grid.CGridView', array(
'id'=>'events-grid',
'itemsCssClass' => 'table table-striped',
'dataProvider'=>$dataProvider,
'columns'=>array(
	//'id',
	'name',
	'location_name',
	//'location_address',
	'date',
	'time',
	//'description',
	'creator',
	array(
		'header'=>'Operaciones',
		'class'=>'CButtonColumn',
	),
),
));

	
?>


<?php /* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
	
	
<?php /*$this->widget('zii.widgets.grid.CGridView', array(
//'id'=>'events-grid',
'dataProvider'=>$dataProvider,
//'filter'=>$model,
'columns'=>array(
	'id',
	'name',
	'date',
	'time',
	'description',
	'creator',
	/*
	'location_name',
	'location_address',
	'location_lat',
	'location_long',
	'confirmation_closed',
	'cost_mode',
	'cost_val1',
	'cost_val2',
	* /
/*	array(
		'class'=>'CButtonColumn',
	),* /
),
));*/ ?>
