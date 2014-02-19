<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' | error';
$this->breadcrumbs=array(
	'error',
);
?>
<?php /* 
<div class="row">
	<h2>Error <?php echo $code; ?></h2>

	<div class="error">
	echo CHtml::encode($message); 
	</div>
</div>
*/ ?>

<link rel="stylesheet" media="screen" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/error.css">
<div id="error" class="sixteen columns clearfix">
	<div id="error-monster-1" class="five columns alpha">
		<img id="error-monster-2" src="<?php echo Yii::app()->request->baseUrl; ?>/img/error/hanging.png">
	</div>
	<div class="eleven columns omega">
		<h1>Lo sentimos, este contenido no está disponible para ti.</h1>
		<img id="error-monster-3" src="<?php echo Yii::app()->request->baseUrl; ?>/img/error/monstersRight.png">
	</div>
</div>
