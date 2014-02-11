<?php
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

<span style="color:red;">(AGREGAR PREVISUALIZADOR DE IMAGENES LIGHTBOX)</span>
<h2 class="featurette-heading">Con organiSado vas a poder...</h2>

<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/crear.png">
	</div>

	<div class="span4 pull-right description">
	    <h2 class="featurette-heading">Crear eventos</h2>
	    <p class="lead ">Texto sin limites.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 pull-right screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/eventos.png">
	</div>

	<div class="span4 description">
	    <h2 class="featurette-heading">Ver eventos</h2>
	    <p class="lead ">Texto Tuyos y a los que fuiste invitado en un solo lugar.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/invitar.png">
	</div>

	<div class="span4 pull-right description">
	    <h2 class="featurette-heading">Invitar</h2>
	    <p class="lead ">Texto por nombre de usuario o por email.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 pull-right screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/cuentas.png">
	</div>

	<div class="span4 description">
	    <h2 class="featurette-heading">Decidir las cuentas</h2>
	    <p class="lead ">Texto flexibilidad con multiples metodos para repartir las cuentas.</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span6 screenshotHolder">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/screenshots/mas.png">
	</div>

	<div class="span4 pull-right description">
	    <h2 class="featurette-heading">Y Más</h2>
	    <p class="lead ">Texto con un recopilado de todo lo demás.</p>
	</div>
</div>
