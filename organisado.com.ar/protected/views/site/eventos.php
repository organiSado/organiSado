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
           	      <!--MAPA -->
           	  <div id="map3" style="width:360px;height:200px;border:2px solid skyblue;">
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
  		   
  <h2>Cuentas</h2>
  <form action="">
    <fieldset>
      <div class="btn-group" data-toggle="buttons-radio">
   
   	    <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#orginvita">El organizador invita
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#valorfijo">Se establece un valor fijo
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#valorfijoasis">Se establece un valor fijo por asistente<br>
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#divgast">Se divide lo gastado en partes iguales<br>
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#divgastasis">Se divide lo gastado segun asistentes<br>
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#divval">Se divide un valor arbitrario en partes iguales<br>
        </label><br />
        <label class="btn btn-default">
      	<input type="radio" data-toggle="modal" href="#divvalasis">Se divide un valor arbitrario segun asistentes<br>
        </label><br />

        </div>	
  	         	      						         	      
     	<div class="modal hide" id="valorfijo" align="center" >
  			<div class="modal-content">
  				<div class="modal-body">
  		 			<div class="control-group">
      								<label>Costo por invitado</label>
     	  								<input type="text">
     	  								<a href="#" class="btn btn-primary">Aceptar</a>
       			 	</div>
       			</div>
       		</div>
  	  </div>

      <div class="modal hide" id="valorfijoasis" align="center">
  		  <div class="modal-content">
  				<div class="modal-body">
  			 		<div class="control-group">
        								<label>Costo por asistente</label>
       	  								<input type="text" placeholder="Adultos"><input type="text" placeholder="Niños">               	  					
       	  								<a href="#" class="btn btn-primary">Aceptar</a>
  	     			</div>
  	     		</div>
  	     	</div>
  		</div>

  	  <div class="modal hide" id="divgast" align="center">
  			<div class="modal-content">
  				<div class="modal-body">
  		 			<div class="control-group">
      								<label>Dividir lo gastado en partes iguales</label>               	  								              	  					
     	  								<a href="#" class="btn btn-primary">Aceptar</a>
  			 				</div>
  			 			</div>
  			 		</div>
  	  </div>

  	  <div class="modal hide" id="divgastasis" align="center">
  			<div class="modal-content">
  				<div class="modal-body">
  		 			<div class="control-group">
      				<label>Se dividi lo gastado segun asistentes</label>
      				<div class="well">
      					<div class="slider slider-horizontal" style="width: 140px">
      						<div class="slider-track">
      							<div class="slider-selection" style="left: 0%; width: 100%;"></div>
  									<div class="slider-handle round" style="left: 100%;"></div>
  									<div class="slider-handle round hide" style="left: 0%;"></div>
      						</div>
      					</div>
      				</div>   
      								   
      				<a href="#" class="btn btn-primary">Aceptar</a>
       			 	</div>
       			</div>
       		</div>
  	  </div>

  		         	      		         	                 	                                        	
    </fieldset>
  </form>
		<fieldset>			
			<table class="table table-striped table-bordered">

				<tbody data-bind="foreach: pagedList">

				<tr>
					<th>Que hace falta?</th>
					<th>Quién trae? </th>
					<th>Cuantos?</th>
					<th>Acciones</th>							            
				</tr>
				
				<tr>
			      <td data-bind="text: Que hace falta?">Pan xKg</td>
			      <td data-bind="text: Quién trae?">Juan Perez</td>
			 	  <td data-bind="text: Cuantos?">01/5</td>
			      <td data-bind="text: Acciones">no</td>
			   </tr> 

			    </tbody>
			</table>	

	    </fieldset>
  		   
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

        
        
