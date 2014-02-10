<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

if (Yii::app()->user->id == "admin")
{
	$this->menu=array(
		array('label'=>'List Users', 'url'=>array('index')),
		array('label'=>'Manage Users', 'url'=>array('admin')),
	);
}
?>

<h1>Crear Usuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>