<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/accordion.css');

	//$cs->registerScriptFile('http://code.jquery.com/jquery.js');
	$cs->registerScriptFile('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js');
	/*
	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
	<!-- bootstrap -->
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	*/

	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/tools.js');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/events.js');

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
	'enableAjaxValidation'=>true,
));

?>
	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary(array_merge(array($model), $inviteesModels)); ?>
	
	

	<div class="row">
		<h2 class="inline">Invitados <a id="add-invitee" class="btn btn-success" href="#addInvitee"><i class="icon-plus"></i></a></h2>

		<div class="inline pull-right">
			<?php echo $form->labelEx($model,'confirmation_closed', array('class'=>'inline')); ?>
			<?php echo $form->checkBox($model,'confirmation_closed', array('class'=>'inline')); ?>
			<?php echo $form->error($model,'confirmation_closed'); ?>
		</div>
		

        <table id="table-invitados" class="table table-striped">
        <thead>
          <tr>
            <th><?php echo $form->labelEx($inviteesModels[0],'email'); ?><?php //echo $form->labelEx($model,'name'); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'admin', array('class'=>'inline')); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'confirmed', array('class'=>'inline')); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'adults', array('class'=>'inline')); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'kids', array('class'=>'inline')); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'cost', array('class'=>'inline')); ?></th>
            <th><?php echo $form->labelEx($inviteesModels[0],'spent', array('class'=>'inline')); ?></th>
            <th>Balance</th>
            <th><?php echo $form->labelEx($inviteesModels[0],'money_ok', array('class'=>'inline')); ?></th>
            <th colspan="2">Acciones</th>
          </tr>
		</thead>
		<tbody>
			<?php foreach($inviteesModels as $i=>$inviteesModel): ?>
			<tr>
		            <td>
		                <?php /*<input size="60" maxlength="255" value="" name="Invitees[name]" id="Invitees_name" type="text">*/?>
		                
						<?php echo $form->textField($inviteesModel,"[$i]email",array('size'=>60,'maxlength'=>255)); ?>
						<?php echo $form->error($inviteesModel,'email'); ?>
		            </td>
		            <td>
						<?php echo $form->checkBox($inviteesModel,"[$i]admin", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'admin'); ?>
					</td>
		            <td>
						<?php echo $form->checkBox($inviteesModel,"[$i]confirmed", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'confirmed'); ?>
					</td>
		            <td>
						<?php echo $form->numberField($inviteesModel,"[$i]adults", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'adults'); ?>
					</td>
		            <td>
						<?php echo $form->numberField($inviteesModel,"[$i]kids", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'kids'); ?>
					</td>
		            <td>
		            	$
						<?php echo $form->numberField($inviteesModel,"[$i]cost", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'cost'); ?>
					</td>
		            <td>
		            	$
						<?php echo $form->numberField($inviteesModel,"[$i]spent", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'spent'); ?>
						</td>
					<td>
		            	$
						<input disabled="disabled" id="Invitees_time" type="number" value="-1">
					</td>
		            <td>
		            	<?php echo $form->checkBox($inviteesModel,"[$i]money_ok", array('class'=>'inline')); ?>
						<?php echo $form->error($inviteesModel,'money_ok'); ?>
					</td>
		            <td class="buttons">
		            	<a class="btn btn-default" href="#mailInvitee" title="mail cuentas o invitacion">
		            		<i class="icon-envelope"></i>
		            	</a>
		            </td>
		            <td class="buttons">
		            	<a class="btn btn-danger remove-invitee" href="#removeInvitee" title="remove" >
		            		<i class="icon-remove"></i>
		            	</a>
		            </td>
			</tr>
			<?php endforeach; ?>
        </tbody>
        </table>

		<a class="btn btn-info pull-right btn-invitees" href="#resendInvitation" title="Reenviar invitaciones a no confirmados" type=""><i class="icon-envelope"></i> Reenviar invitaciones</a>
		<a class="btn btn-info pull-right btn-invitees" href="#sendBills" title="Enviar cuentas a confirmados" type=""><i class="icon-envelope"></i> Enviar cuentas</a>
    </div>
	<hr>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget(); ?><div class="row">
	</div>

</div><!-- form -->