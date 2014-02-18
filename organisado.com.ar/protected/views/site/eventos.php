<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' | eventos';
$this->breadcrumbs=array(
        'eventos',
);
?>

        
       
        
<div class="container marketing" align="left">
  <div class="content">
    <div class="row">
     	<div>     		   	
      	<h2>Evento</h2>
      	<form action="">
       		<fieldset>

        	  <div class="control-group">
        	    <label>Nombre Evento</label>
              <input type="text" placeholder="Nombre Evento">
         	  </div>

         	  <div class="control-group">
         	    <label>Nombre del Lugar</label>
           	  <input type="text" placeholder="Lugar">
              <?php require_once "gmap.php" ?>
              </div>
          	</div>

            <div class="control-group">
              <label>Fecha y Hora</label>
           	  <input type="date" placeholder="Fecha">           	      	
           	  <input type="time" placeholder="Hora">
          	</div>

            <div class="control-group">
              <label>Descripción del Evento</label>
           	  <textarea style="width:360px;height:150px"></textarea>
          	</div> 

          </fieldset>
        </form>

        <h2>Invitados</h2> 
        <form action="">
       		<fieldset>			
						<table class="table table-striped table-bordered">
							<tbody data-bind="foreach: pagedList">

							  <tr>
							  	<th>Invitado</th>
							    <th>Tipo</th>
							    <th><a class="btn btn-success"  data-bind="click: $root.add" data-toggle="modal" href="#addInvited" title="add" ><i class="icon-plus"></i></a></th>							            
							  </tr>

							  <tr>
							    <td data-bind="text: invitado">Pepe</td>
							    <td data-bind="text: tipo">Invitado</td>
							    <td class="buttons">
							      <a class="btn btn-danger" data-bind="click: $root.remove" href="#" title="remove"><i class="icon-remove"></i></a>
							    </td>  
							  </tr>

							  <tr>
							    <td data-bind="text: invitado">Lola</td>
							    <td data-bind="text: tipo">Organizador</td>
							    <td class="buttons">
							      <a class="btn btn-danger" data-bind="click: $root.remove" href="#" title="remove" type=""><i class="icon-remove"></i></a>
							    </td>  
							  </tr>

							</tbody>
						</table>					
          </fieldset>
        </form>

      </div>
    </div>
  </div>  	

  		         	      		         	                 	                                        	
    </fieldset>
  </form>
  		   


  <div class="control-group">
    <label>Cuentas</label> 
    <?php require_once "cuentas.php" ?>
    </div>
  </div>


</div> <!-- /container -->

				

        <!-- jQuery -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <!-- bootstrap -->
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

        <script src="js/intro.js"></script>
        
        <!--Script para solicitar el mapa de google -->
        <script type="text/javascript" src="http://www.google.com/jsapi?key=AIzaSyBcmpHYQTbZ_nWo7y78zRWe7-IbP-6rWUg"></script>


<!-- POPUP NUEVO INVITADO-->
<div class="modal hide" id="addInvited" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Nuevo Invitado</h4>
			</div> <!-- div header-->
				<div class="modal-body">
					<div class="control-group">
	        	      		<label>Email o Nombre</label>
	               	  		<input type="text" placeholder="email o nombre">
	         	    </div>	         
				    <div class="input-group">
				      Organizador   
				      <span class="input-group-addon">
				        <input type="checkbox">
				      </span>
				    </div>		  
					<div class="modal-footer">
						<a href="#" class="btn btn-danger" onclick="closeDialog();">Cancelar</a>
						<a href="#" class="btn btn-primary" onclick="okClicked();">Guardar</a>
					</div>
         	   </div> <!-- div body-->
		</div> <!-- div content-->
	</div> <!-- div dialog-->	
</div>  <!-- div fade-->    


        
<script type="text/javascript">
		google.load('maps', '2' {callback:simple3});var map;	
		function simple3(){	
		if (GBrowserIsCompatible()) { 
		function createMarker(point,html) {
		var marker = new GMarker(point);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(html);});
		return marker;}			
		var map = new GMap2(document.getElementById("map3"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());	  
		map.setCenter(new GLatLng(23.1311,-82.3726),13);}	  
		var point = new GLatLng(23.1351,-82.3598);
		var marker = createMarker(point,'<div style="width:240px">El Capitolio de la Habana <a href="http://norfipc.com">Pagina web<\/a> con mas información<\/div>')
		map.addOverlay(marker);
		var point = new GLatLng(23.1368,-82.3816);
		var marker = createMarker(point,'La Universidad de la Habana')
		map.addOverlay(marker);}
		window.onload=function(){simple3();}
		
</script>

        
        
