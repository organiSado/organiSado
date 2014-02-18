<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */


	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/tools.js');
	$cs->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3&sensor=false');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/gmap.js');
//	$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->dateField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->timeField($model,'time',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'creator'); ?>
		<?php echo $form->hiddenField($model,'creator',array('value'=>Yii::app()->user->id)); ?>
		<?php //echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_name'); ?>
		<?php echo $form->textField($model,'location_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_address'); ?>
		<?php echo $form->textField($model,'location_address',array('size'=>60,'maxlength'=>255,  'onkeyup'=>"scheduleCall(this, findAddressInEditorMap);")); ?>
		<?php echo $form->error($model,'location_address'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'location_lat'); ?>
		<?php echo $form->hiddenField($model,'location_lat',array('size'=>45,'maxlength'=>45)); ?>
		<?php //echo $form->error($model,'location_lat'); ?>

		<?php //echo $form->labelEx($model,'location_long'); ?>
		<?php echo $form->hiddenField($model,'location_long',array('size'=>45,'maxlength'=>45)); ?>
		<?php //echo $form->error($model,'location_long'); ?>

      	<div id="map"></div>
  		<script type="text/javascript"> google.maps.event.addDomListener(window, 'ready', initEditorMap()); </script>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirmation_closed'); ?>
		<?php echo $form->checkBox($model,'confirmation_closed'); ?>
		<?php echo $form->error($model,'confirmation_closed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->