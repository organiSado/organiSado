<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */


	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/accordion.css');

	$cs->registerScriptFile('http://code.jquery.com/jquery.js');
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
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
		
	<div class="row">
		<div class="col pull-left">
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
				<?php echo $form->labelEx($model,'description'); ?>
				<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'description'); ?>
			</div>
		</div>

		<div class="col pull-left">
			<div class="row">
				<?php echo $form->labelEx($model,'location_name'); ?>
				<?php echo $form->textField($model,'location_name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'location_name'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'location_address'); ?>
				<?php echo $form->textField($model,'location_address',array('size'=>60,'maxlength'=>255, 'onkeyup'=>"scheduleCall(this, findAddressInEditorMap);")); ?>
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
		</div>
	</div>

	<hr>

	<div class="row">
		<h2>Cuentas</h2>

	
<section class="ac-container">
        <div>
          <input id="tipo1" name="cuentas" type="radio" value="0" checked />
          <label for="tipo1">El organizador invita</label>
          <article class="ac-small">
            <p>El evento no tiene costo alguno para los invitados</p>
          </article>
        </div>
        <div>
          <input id="tipo2" name="cuentas" type="radio" value="1" />
          <label for="tipo2">Se establece un costo fijo</label>
          <article class="ac-medium">
            <p>El costo del evento para todos los invitados sera igual a un valor fijo, independientemente del costo total del evento. </p>
          </article>
        </div>
        <div>
          <input id="tipo3" name="cuentas" type="radio" value="2" />
          <label for="tipo3">Se establece un costo fijo segun asistente</label>
          <article class="ac-large">
            <p>Se distinguen dos valores fijos de costo para cada uno de los tipos de asistentes respectivamente, adultos y menores, tambien independientemente del costo total del evento. </p>
          </article>
        </div>
        <div>
          <input id="tipo4" name="cuentas" type="radio" value="3" />
          <label for="tipo4">Se divide lo gastado en partes iguales</label>
          <article class="ac-large">
            <p>Se divide el costo total del evento entre todos los asistentes sin distincion alguna. </p>
          </article>
        </div>
        <div>
          <input id="tipo5" name="cuentas" type="radio" value="4" />
          <label for="tipo5">Se divide lo gastado segun asistentes</label>
          <article class="ac-large">
            <p>Se establece un valor diferente de costo para cada uno de los tipos de asistentes, adultos y menores, estos valores se calculan a partir del costo total del evento, y el costo
            correspondiente a los asistentes menores, se calculará como un porcentaje del costo de un asistente adulto, segun se lo indique debajo. </p>
          </article>
        </div>
        <div>
          <input id="tipo6" name="cuentas" type="radio" value="5"/>
          <label for="tipo6">Se divide un valor fijo en partes iguales</label>
          <article class="ac-large">
            <p>Se divide un valor fijo que representa el costo total, entre todos los asistentes sin distincion alguna. </p>
          </article>
        </div>
        <div>
          <input id="tipo7" name="cuentas" type="radio" value="6" />
          <label for="tipo7">Se divide un valor fijo segun asistente</label>
          <article class="ac-large">
            <p>Se establece un valor diferente de costo para cada uno de los tipos de asistentes, adultos y menores, estos valores se calculan a partir de un valor fijo que represental costo total del evento, y el costo
            correspondiente a los asistentes menores, se calculará como un porcentaje del costo de un asistente adulto, segun se lo indique debajo.</p>
          </article>
        </div>

      </section>
        

	</div> <!-- divv final cuentas -->

	<hr>

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
            <th><?php echo $form->labelEx($model,'name'); ?></th>
            <th>Organizador</th>
            <th>Asistirá</th>
            <th>Adultos</th>
            <th>Niños</th>
            <th>Costo</th>
            <th>Gastos</th>
            <th>Balance</th>
            <th>Pagó</th>
            <th colspan="2">Acciones</th>
          </tr>
		</thead>
		<tbody>
          <tr>
            <td>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'value'=>'Juan De Los Palotes')); ?>
                <?php echo $form->error($model,'name'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
            <td>
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
            	$
				<?php echo $form->numberField($model,'time', array('onchanged'=>"calcCost();")); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
            	$
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>            <td>
            	$
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed'); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
          	
          	<td class="buttons"><a class="btn btn-default" href="#mailInvitee" title="mail cuentas o invitacion" type=""><i class="icon-envelope"></i></a></td>
            <td class="buttons"><a class="btn btn-danger remove-invitee" href="#removeInvitee" title="remove" type=""><i class="icon-remove"></i></a></td>          </tr>

          <tr>
            <td>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'value'=>'Palo De Los Juanotes')); ?>
                <?php echo $form->error($model,'name'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
            <td>
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
            	$
				<?php echo $form->numberField($model,'time', array('onchanged'=>"calcCost();")); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>
            	$
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>            
            <td>
            	$
				<?php echo $form->numberField($model,'time',array('disabled'=>'true')); ?>
				<?php echo $form->error($model,'time'); ?>
            </td>
            <td>   
				<?php echo $form->checkBox($model,'confirmation_closed'); ?>
				<?php echo $form->error($model,'confirmation_closed'); ?>
            </td>
            <td class="buttons"><a class="btn btn-default" href="#mailInvitee" title="mail cuentas o invitacion" type=""><i class="icon-envelope"></i></a></td>
            <td class="buttons"><a class="btn btn-danger" href="#removeInvitee" title="remove" type=""><i class="icon-remove"></i></a></td>  
          </tr>
        </tbody>
        </table>

		<a class="btn btn-info pull-right btn-invitees" href="#resendInvitation" title="Reenviar invitaciones a no confirmados" type=""><i class="icon-envelope"></i> Reenviar invitaciones</a>
		<a class="btn btn-info pull-right btn-invitees" href="#sendBills" title="Enviar cuentas a confirmados" type=""><i class="icon-envelope"></i> Enviar cuentas</a>
    </div>

	<hr>

	<div class="row">
		<h2>Lista</h2>
	</div>

	<hr>

	<div class="row">
		<h2>Fotos</h2>
	</div>

	<hr>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->