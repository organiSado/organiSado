<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'usuarios'=>array('index'),
	'crear',
);

if (Yii::app()->user->id == "admin")
{
	$this->menu=array(
		array('label'=>'List Users', 'url'=>array('index')),
		array('label'=>'Manage Users', 'url'=>array('admin')),
	);
}
else
{
	$this->toSideBar = '<div class="pull-right"><h2>¿Ya tenés cuenta?</h2><a class="btn btn-large btn-primary" href="'.$this->createUrl('/site/login').'">ingresá</a></div>';
}

?>

<h1>Crear Usuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>