<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' | contacto';
$this->breadcrumbs=array(
        'contacto',
);
?>
<div class="row">
	<h1>Contacto</h1>

	<?php if(Yii::app()->user->hasFlash('contact')): ?>

	<div class="flash-success">
		<?php echo Yii::app()->user->getFlash('contact'); ?>
	</div>

	<?php else: ?>

	<p>
	Si quieres hacernos consultas sobre organiSado, por favor, llena el siguiente formulario para contactarnos. Gracias.
	</p>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'subject'); ?>
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'body'); ?>
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'body'); ?>
		</div>

		<?php if(CCaptcha::checkRequirements()): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<div>
			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model,'verifyCode'); ?>
			</div>
			<div class="hint">Por favor, ingresa los caracteres tal como se ven en la imagen.
			<br/>Las letras no son sensibles a mayúsculas.</div>
			<?php echo $form->error($model,'verifyCode'); ?>
			<br/>
		</div>
		<?php endif; ?>

		<div class="row buttons">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Enviar')); ?>	
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->

	<?php endif; ?>
</div>
