<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
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
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'location'); ?>
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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'creator'); ?>
		<?php echo $form->hiddenField($model,'creator',array('value'=>Yii::app()->user->id)); ?>
		<?php //echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gmaps_lat'); ?>
		<?php echo $form->hiddenField($model,'gmaps_lat',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'gmaps_lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gmaps_long'); ?>
		<?php echo $form->hiddenField($model,'gmaps_long',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'gmaps_long'); ?>
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