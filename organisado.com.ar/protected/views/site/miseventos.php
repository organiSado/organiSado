<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' | mis eventos';
$this->breadcrumbs=array(
        'mis eventos',
);
?>

<div>
	<h2>Mis Eventos</h2> 
	<form action="">
		<fieldset>			
			<table class="table table-striped table-bordered">

				<tbody data-bind="foreach: pagedList">

				<tr>
					<th>Nombre</th>
					<th>Lugar</th>
					<th>Fecha</th>
					<th>Organizador</th>
					<th>Invitados Confirmados</th>							            
				</tr>

			    <tr>
			      <td data-bind="text: Nombre">cumpleaños</td>
			      <td data-bind="text: Lugar">calle</td>
			 	  <td data-bind="text: Fecha">01/02/1988</td>
			      <td data-bind="text: Organizador">no</td>
			      <td data-bind="text: Invitador Confirmados">25/84</td>  
			    </tr>


			    </tbody>
			</table>	

	    </fieldset>
	</form>



</div>