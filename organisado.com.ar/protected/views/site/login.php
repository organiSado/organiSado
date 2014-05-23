<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' | login';
$this->breadcrumbs=array(
        'login',
);
?>

<div class="row">
	<h1>Login</h1>
	
	<div class="pull-right"><h2>¿No tenés cuenta?</h2><a class="btn btn-large btn-primary" href="<?php echo $this->createUrl('/users/create') ?>">registrate</a></div>
	
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="row rememberMe">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>
		
		
		<div class="row buttons">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Login')); ?>
			<a class="btn btn-small btn-link" href="<?php echo $this->createUrl('users/recover') ?>">¿Contraseña Olvidada?</a>
		</div>
		
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>