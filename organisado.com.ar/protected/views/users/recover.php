<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	'Recuperar Contraseña',
);

?>

<h1>Restablecer contraseña</h1>

<?php $this->renderPartial('_formRecover', array('model'=>$model,'status'=>$status)); ?>