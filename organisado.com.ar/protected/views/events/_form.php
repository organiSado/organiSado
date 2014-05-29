<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */

	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/accordion.css');

	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/blueimp-gallery.min.css');

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

	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/blueimp-gallery.min.js');

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,

    //This is very important when uploading files
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary(array_merge(array($model), $inviteesModels)); ?>
	
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
				<?php if (!$model->creator) echo $form->hiddenField($model,'creator',array('value'=> Yii::app()->user->id )); ?>
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
				<?php echo $form->textField($model,'location_address',array('size'=>60,'maxlength'=>255)); ?>
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
			</div>
		</div>
	</div>

	<hr>






	<div class="row">
		<h2>Cuentas</h2>
		<?php
			/* Auto-Generador de accordion by organiSado Dev Team corp. inc. */
			$cost_modes = $model->costModes();

			echo '<ul class="accordion">';
			for ($i=0; isset($cost_modes) && $i < count($cost_modes); $i++)
			{
				echo '<li class="nav-dropdown">';
				echo '<input type="radio" class="accordion_label" id="accordion_label_'.$i.'" name="Events[cost_mode]"'.($model->cost_mode == $i || ($i==0 && !$model->cost_mode)? ' checked="true"' : '').' value="'.$i.'" />';
				echo '<label for="accordion_label_'.$i.'">'.$cost_modes[$i]['label'].'</label>';
				echo '<div><p>'.$cost_modes[$i]['description'].'</p></div>';
				//echo '<div><p>'.'DEBUG,'.$model->cost_mode.', ==$i:'.($model->cost_mode == $i? 'true':'false').'==0 && !$model->cost_mode'.($i==0 && !$model->cost_mode? 'true':'false').'</p></div>';
				echo '</li>';
			}
			echo '</ul>';
		?>
	</div> <!-- div final cuentas -->
	
	<div class="row">
		<?php echo $form->labelEx($model,'cost_val1'); ?>
		<?php echo $form->textField($model,'cost_val1'); ?>
		<?php //echo $form->error($model,'cost_val1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost_val2'); ?>
		<?php echo $form->textField($model,'cost_val2'); ?>
		<?php //echo $form->error($model,'cost_val2'); ?>
	</div>

	<hr>

	<div class="row">
		<h2 class="inline">Invitados <a id="add-invitee" class="btn btn-success" href="#addInvitee"><i class="icon-plus"></i></a></h2>

		<div class="inline pull-right">
			<?php echo $form->labelEx($model,'confirmation_closed', array('class'=>'inline')); ?>
			<?php echo $form->checkBox($model,'confirmation_closed', array('class'=>'inline')); ?>
			<?php echo $form->error($model,'confirmation_closed'); ?>
		</div>
		
		<datalist id="suggest">
		</datalist>

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
		                
						<?php echo $form->textField($inviteesModel,"[$i]email",array('size'=>60,'maxlength'=>255, 'list'=>'suggest', 'autocomplete'=>'off')); ?>
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

	<div class="row">
		<h2 class="inline">Lista de items <a id="add-item" class="btn btn-success" href="#addItem"><i class="icon-plus"></i></a> <a id="refresh-items" class="btn btn-info" href="#refresh-items"><i class="icon-refresh"></i></a></h2>
        <div id="table-items-progress">
        		<div class="progress progress-striped active">
            		<div class="bar" style="width: 100%;"></div>
				</div>
		</div>
        <div id="table-items-container" style="opacity:0;"></div>
        <div id="message-board"></div>


		<a class="btn btn-info pull-right btn-invitees" href="#sendItemList" title="Enviar cuentas a confirmados" type=""><i class="icon-envelope"></i> Enviar Lista de items</a>
    </div>
<br>
<hr>
<h2>Fotos</h2>
	<!-- Other Fields... -->
	<div class="row">
	    <?php //echo $form->labelEx($model,'photos'); ?>
	    <div id="blueimp-gallery" class="blueimp-gallery">
		    <div class="slides"></div>
		    <h3 class="title"></h3>
		    <a class="prev">‹</a>
		    <a class="next">›</a>
		    <a class="close">×</a>
		    <a class="play-pause"></a>
		    <ol class="indicator"></ol>
		</div>
		
	    <?php
	    $this->widget( 'xupload.XUpload', array(
	        'url' => Yii::app( )->createUrl( "/events/upload"),
	        //our XUploadForm
	        'model' => $xupload,
	        //We set this for the widget to be able to target our own form
	        'htmlOptions' => array('id'=>'events-form'),
	        'attribute' => 'file',
	        'multiple' => true,
	        //Note that we are using a custom view for our widget
	        //Thats becase the default widget includes the 'form' 
	        //which we don't want here
			'formView' => 'application.extensions.xupload.views.form_es',
			'showForm' => false, // esto hace que no imprima el tag form y rompa el formulario padre
	        'gallery' => isset($gallery)? $gallery : new Gallery,
	        )    
	    );
	    ?>

	    <script>
			document.getElementById('links').onclick = function (event) {
			    event = event || window.event;
			    var target = event.target || event.srcElement,
			        link = target.src ? target.parentNode : target,
			        options = {index: link, event: event},
			        links = this.getElementsByTagName('a');
			    blueimp.Gallery(links, options);
			};
		</script>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget(); ?><div class="row">
	</div>

</div><!-- form -->