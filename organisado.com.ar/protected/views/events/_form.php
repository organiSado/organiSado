<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */


	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/accordion.css');

	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/imageuploeader.css');

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

		//js del uploader de imagenes
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/imgup-jquery-1.10.2.min.js');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/imgup-jquery.form.min.js');

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

		<?php
			$this->Widget('zii.widgets.jui.CJuiAccordion', array(
				'panels'=>array(

					'El organizador invita' => '<input type=radio name=cuentas value=c1 checked=true >El evento no tiene costo alguno para los invitados</br>',

					'Se establece un costo fijo' => '<input type=radio name=cuentas value=c2>El costo del evento para todos los invitados sera 
													igual a un valor fijo, independientemente del costo total del evento.

													<input type="text" name="valorfijo" placeholder="ingrese el valor">',

					'Se establece un costo fijo segun asistente' => '<input type=radio name=cuentas value=c3>Se distinguen dos valores fijos de 
																	 costo para cada uno de los tipos de asistentes respectivamente, adultos y
																	 menores, tambien independientemente del costo total del evento.</br>

																	 <input type="text" name="valorfijomayor" placeholder="mayor">
																	 <input type="text" name="valorfijomenor" placeholder="menor">',

					'Se divide lo gastado en partes iguales' => '<input type=radio name=cuentas value=c4>Se divide el costo total del evento 
																 entre todos los asistentes sin distincion alguna.</br>',

					'Se divide lo gastado segun asistentes' => '<input type=radio name=cuentas value=c5>Se establece un valor diferente de costo 
																para cada uno de los tipos de asistentes, adultos y menores, estos valores se  
																calculan a partir del costo total del evento, y el costo correspondiente a los 
																asistentes  menores, se calculará como un porcentaje del costo de un asistente  
																adulto, segun se lo indique debajo.</br>',

					'Se divide un valor fijo en partes iguales' => '<input type=radio name=cuentas value=c6>Se divide un valor fijo que representa 
																	el costo total, entre todos los asistentes sin distincion alguna.</br>',

					'Se divide un valor fijo segun asistente' => '<input type=radio name=cuentas value=c7>Se establece un valor diferente de costo 
																  para cada uno de los tipos de asistentes, adultos y menores, estos valores se 
																  calculan a partir de un valor fijo que represental costo total del evento, y el 
																  costo correspondiente a los asistentes menores, se calculará como un porcentaje 
																  del costo de un asistente adulto, segun se lo indique debajo.</br>',
				),

				'options'=>array(
					'collapsible'=>true,
					'active'=>0,
					'animated'=>'bounceslide',

				),

				'htmlOptions'=>array(
					'style'=>'width:600px',

				),




			));
		?>

        

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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => "btn")); ?>
	</div>

<?php $this->endWidget(); ?><div class="row">
		<h2>Lista</h2>
	</div>

	<hr>

	<div class="row">
		<h2>Fotos</h2>

	<script type="text/javascript"> // ver si podemos meter este scrtip en un .js aparte.

		$(document).ready(function() { 
			var options = { 
				target:   '#output',   // target element(s) to be updated with server response 
				beforeSubmit:  beforeSubmit,  // pre-submit callback 
				success:       afterSuccess,  // post-submit callback 
				resetForm: true        // reset the form after successful submit 
			}; 
		
	 		$('#MyUploadForm').submit(function() { 
				$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
				return false; 
			}); 
		}); 

		function afterSuccess()
		{
			$('#submit-btn').show(); //hide submit button
			$('#loading-img').hide(); //hide submit button

		}

		//function to check file size before uploading.
		function beforeSubmit(){
   			 //check whether browser fully supports all File API
   			if (window.File && window.FileReader && window.FileList && window.Blob)
			{
		
				if( !$('#imageInput').val()) //check empty input filed
				{
					$("#output").html("Are you kidding me?");
					return false
				}
		
				var fsize = $('#imageInput')[0].files[0].size; //get file size
				var ftype = $('#imageInput')[0].files[0].type; // get file type
		
				//allow only valid image file types 
				switch(ftype)
        		{
            		case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                	break;
            		default:
                	$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
					return false
        		}
		
				//Allowed file size is less than 1 MB (1048576)
				if(fsize>1048576) 
				{
					$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
					return false
				}
				
				$('#submit-btn').hide(); //hide submit button
				$('#loading-img').show(); //hide submit button
				$("#output").html("");  
			}
			else
			{
			//Output error to older unsupported browsers that doesn't support HTML5 File API
				$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
				return false;
			}
		}

		//function to format bites bit.ly/19yoIPO
		function bytesToSize(bytes) {
   			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   			if (bytes == 0) return '0 Bytes';
   			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   			return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
		}

	</script> <!-- finaliza el script del uploader de fotos -->


	<div id="upload-wrapper">
		<div align="center">
		<h3>Uploader de Fotos</h3>
		<form action="<?php echo Yii::app()->request->baseUrl; ?>/php/processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
			<input name="ImageFile" id="imageInput" type="file" />
			<input type="submit"  id="submit-btn" value="Upload" />
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/loadgif/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
		</form>
		<div id="output"></div>
		</div>
	</div>


	</div>



</div><!-- form -->