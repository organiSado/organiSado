<?php

include_once("php/tools.php");

/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Eventos'=>array('index'),
	$model->name,
);

/*$this->menu=array(
	array('label'=>'Lista de Eventos', 'url'=>array('index')),
	array('label'=>'Crear Evento', 'url'=>array('create')),
	array('label'=>'Actualizar Evento', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Evento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que quieres borrar este evento?')),
	//array('label'=>'Manage Events', 'url'=>array('admin')),
);*/



/*	$this->renderPartial('_form', array('model'=>$model, 'inviteesModels'=>$inviteesModels));
echo '<script>$(window).on("click, keyup, change", function(){return false;});</script>';

return;*/

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
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/events-view.js');

	$cs->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3&sensor=false');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/gmap.js');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/blueimp-gallery.min.js');


	$base_path = Yii::app()->request->baseUrl;
?>

<h1><?php echo $model->name; ?></h1>
<br>

<?php
$modes=$model->costModes();

 $this->widget('zii.widgets.CDetailView', array(
	'htmlOptions'=>array('class' => 'table table-striped', 'id' => 'detalle-eventos'),
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'name',
		'date',
		'time',
		'description',
		'creator',
		'location_name',
		'location_address',
		/*'location_lat',
		'location_long',*/
		//'',
		array(
			'value'=>($model->confirmation_closed==1? 'Sí' : 'No'),
			'name'=>'confirmation_closed'
		),
		array(
			'value'=>$modes[$model->cost_mode]['label'],
			'name'=>'cost_mode'
		),
		/*'cost_val1',
		'cost_val2',*/
	),
));

?>
<br>

<hr>
<h2>Mapa</h2>
<div id="map"></div>
<br>

<hr>
<h2>Muro de Mensajes</h2>
<div id='chat'></div>
<?php 
    $this->widget('YiiChatWidget',array(
        'chat_id'=>$model->id,                   // a chat identificator
        'identity'=>Yii::app()->user->id,
        'selector'=>'#chat',                // were it will be inserted
        'minPostLen'=>2,                    // min and
        'maxPostLen'=>80,                   // max string size for post
        'model'=>new ChatHandler(),    // the class handler. **** FOR DEMO, READ MORE LATER IN THIS DOC ****
        'data'=>'any data',                 // data passed to the handler
        // success and error handlers, both optionals.
        'onSuccess'=>new CJavaScriptExpression(
            "function(code, text, post_id){   }"),
        'onError'=>new CJavaScriptExpression(
            "function(errorcode, info){  }"),
    ));
?>
<br>
<hr>
<h2>Invitados</h2>
<?php 
$labels=$inviteesModels[0]->attributeLabels();
if (isset($inviteesModels) && is_array($inviteesModels) && count($inviteesModels)): ?>
<table id="table-invitados" class="table table-striped">
<thead>
  <tr>
    <th><?php echo $labels['email']; ?><?php //echo $model,'name'); ?></th>
    <th><?php echo $labels['admin']; ?></th>
    <th><?php echo $labels['confirmed']; ?></th>
    <th><?php echo $labels['adults']; ?></th>
    <th><?php echo $labels['kids']; ?></th>
    <th><?php echo $labels['cost']; ?></th>
    <th><?php echo $labels['spent']; ?></th>
    <th>Balance</th>
    <th><?php echo $labels['money_ok']; ?></th>
  </tr>
</thead>
<tbody>
<?php  foreach($inviteesModels as $i=>$inviteesModel): ?>
	<tr>
            <td>
				<?php echo $inviteesModel->email; ?>
            </td>
            <td>
				<?php echo ($inviteesModel->admin==1? 'Sí' : 'No'); ?>
			</td>
            <td>
				<?php echo ($inviteesModel->confirmed==1? 'Sí' : 'No'); ?>
			</td>
            <td>
				<?php if(!isset($inviteesModel->adults)) $inviteesModel->adults = 0;
					  echo $inviteesModel->adults; ?>
			</td>
            <td>
				<?php if(!isset($inviteesModel->kids)) $inviteesModel->kids = 0;
					  echo $inviteesModel->kids; ?>
			</td>
            <td>
            	$
				<?php echo $inviteesModel->cost; ?>
			</td>
            <td>
            	$
				<?php echo $inviteesModel->spent; ?>
				</td>
			<td>
            	$
				<span id="balance"></span>
			</td>
            <td>
            	<?php echo ($inviteesModel->money_ok==1? 'Sí' : 'No'); ?>
			</td>
            
	</tr>
	<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

<br>
<hr>
<h2>Fotos</h2>
<?php  if(is_array($gallery) && count($gallery) ): ?>

<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<div id="links">
    <?php  foreach($gallery as $photo): ?>
		<?php
			$url =  $base_path.$photo->url;
			$photo_path = explode("/", $photo->url);
			$thumb_url =  $base_path.implode("/", array_insert("thumbs", count($photo_path)-1, $photo_path) );
		?>
		<a href="<?php echo $url; ?>" title="<?php //echo $photo->name; ?>">
        	<img src="<?php echo $thumb_url; ?>" alt="<?php echo $photo->name; ?>">
		</a>
	<?php endforeach; ?>
</div>

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
<?php  else: ?>
	<p>Este evento no posee fotos todavía.</p>
<?php  endif; ?>
<br>
<br>
