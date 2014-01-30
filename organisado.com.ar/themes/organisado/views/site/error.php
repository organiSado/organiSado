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

<link rel="stylesheet" media="screen" type="text/css" href="css/error.css">
<div id="error" class="sixteen columns clearfix">
	<div id="error-monster-1" class="five columns alpha">
		<img id="error-monster-2" src="img/error/hanging.png">
	</div>
	<div class="eleven columns omega">
		<h1>Lo sentimos, no podemos encontrar lo que nos pedís.</h1>
		<img id="error-monster-3" src="img/error/monstersRight.png">
	</div>
</div>