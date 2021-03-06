﻿<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' | ¿qué es?';
$this->breadcrumbs=array(
        '¿qué es?',
);
?>

<div class="row">
	<div class="span4 pull-right logoHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/logo.png">
	</div>

	<div class="span6 description">
	    <h2 class="featurette-heading">¿Qué es organiSado?</h2>
	    <p class="lead ">organiSado es una plataforma online para organizar asados y comidas entre amigos, de manera sencilla, rápida e intuitiva.</p>
	    <p class="lead ">Ponemos a tu alcance las mejores tecnologías web de última generación para que el organizar tu próxima comida sea distendido y efectivo.</p>
        <p class="lead">¿Cuánto más vas a esperar para comenzar a descansar?</p>
        <a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('/users/create') ?>">Registrarme</a>
	</div>
</div>

<h2 class="featurette-heading">Con organiSado vas a poder...</h2>

<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/crear_evento.png">
	</div>

	<div class="span4 pull-right description">
	    <h2 class="featurette-heading">Crear eventos</h2>
	    <p class="lead ">En organiSado vas a poder crear tus eventos rápidamente para que tus invitados lleguen a tiempo.</p>
	    <p class="lead ">Con la incorporación de Google Maps tus invitados no se van a perder.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 pull-right screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/lista_eventos.png">
	</div>

	<div class="span4 description">
	    <h2 class="featurette-heading">Ver eventos</h2>
	    <p class="lead ">Tu lista de eventos ágil y rápida ó mejor dicho "cortita y al pie".</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/invitados.png">
	</div>

	<div class="span4 pull-right description">
	    <h2 class="featurette-heading">Invitar</h2>
	    <p class="lead ">organiSado te brinda una lista de invitados totalmente detalla.</p>
	    <p class="lead ">Vas a poder controlar el gasto de cada invitado y decidir si alguno te dá una mano con la organización.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 pull-right screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/acordeon_cuentas.png">
	</div>

	<div class="span4 description">
	    <h2 class="featurette-heading">Decidir las cuentas</h2>
	    <p class="lead ">Sí los números no son tu fuerte, organiSado te ofrece varias formas de repartir los gastos.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/logo.png">
	</div>

	<div class="span4 pull-right description">
	    <p class="lead ">...el aplauso ya no es mas para el asador. Es para el OrganiSador.</p>
	</div>
</div>
