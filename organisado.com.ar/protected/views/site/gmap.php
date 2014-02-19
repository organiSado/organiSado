<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' | GMap';
$this->breadcrumbs=array(
        'GMap',
);

	$cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/tools.js');
	$cs->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3&sensor=false');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/gmap.js');
//	$cs->registerCssFile($baseUrl.'/css/yourcss.css');

?>     
        
<div class="container marketing" align="left">
  <div class="content">
    <div class="row">
      	<h2>GMap</h2>
      	<input type="text" id='address' onkeyup="scheduleCall(this, findAddressInEditorMap);">Mejorar con timer para no saturara de queries y hacer que el arrastrar el marker devuelva la direccion, e imprimir en el infoWindow la direccion
      	<br>
      	<input type="text" id='field_latitude'>
      	<input type="text" id='field_longitude'>
      	<div id="map" style="width:90%;height:400px;border:2px solid skyblue;">
        </div>	
  	</div>	   
</div>



<script type="text/javascript"> google.maps.event.addDomListener(window, 'load', initEditorMap()); </script>
        
        
