<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */


$steps = array(
0=>'Ingrese el email de su cuenta, por favor.',
1=>'No pudimos encontrar su email, por favor, revise los datos ingresados.',
2=>'El servidor no pudo enviar el email a su dirección, por favor, intente más tarde.',
3=>'Ha sido enviado un email con un enlace para restablecer su contraseña, por favor, siga las instrucciones del mismo.',
4=>'Enlace de reestablecimiento de contraseña no válido, por favor, verifique el mismo.',
);


echo "<p>".$steps[$status]."</p>";
if ($status<2):
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Recuperar', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget();
endif;
 ?>

</div><!-- form -->