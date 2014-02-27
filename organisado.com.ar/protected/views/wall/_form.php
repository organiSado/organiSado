<?php
/* @var $this WallController */
/* @var $model Wall */
/* @var $form CActiveForm */

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/imageuploader.css');

	$cs->registerScriptFile('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js');

	//js del uploader de imagenes
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/imgup-jquery-1.10.2.min.js');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/imgup-jquery.form.min.js');

	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/wall.js');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wall-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php //echo $form->labelEx($model,'email'); ?>
		<?php echo $form->hiddenField($model,'email',array('value'=>Yii::app()->user->id)); ?>
		<?php //echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'event'); ?>
		<?php echo $form->hiddenField($model,'event',array('value'=>'$event')); ?>
		<?php //echo $form->error($model,'event'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attachment_url'); ?>
		<?php echo $form->textField($model,'attachment_url',array('size'=>60,'maxlength'=>255,'readonly'=>'true')); ?>
		<?php echo $form->error($model,'attachment_url'); ?>
	</div>

<?php $this->endWidget(); ?>

	<form action="<?php echo Yii::app()->request->baseUrl; ?>/php/processupload.php" method="post" enctype="multipart/form-data" id="uploadForm">
		<div id="uploader">
			<input name="ImageFile" id="imageInput" type="file" value=""/>
			<a href="#upload" id="upload">Subir</a>
		</div>

		<div id="manager">
			<a href="#delete" id="delete">Eliminar</a>
			<div id="output"></div>
		</div>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/loadgif/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
	</form>
	<div id="text-output"></div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => "btn", 'id' => "yii-submit-btn")); ?>
	</div>


</div><!-- form -->