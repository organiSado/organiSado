/* globals */
var default_table_id 		= "table-invitados";
var default_addInvitee_id 	= "add-invitee";
var costMode = -1;

$(document).on("ready",function()
{
	// calcular costos y balance
	startWatchdog($('#'+default_table_id)[0], calcCost);

	// al presionar el botton de agregar invitado
	$('#'+default_addInvitee_id).on("click", function()
	{
		addInvitee();
		return false;
	});

	// Mejorar: anular interaccion si se cierra la confirmacion de asistentes
	$('#Events_confirmation_closed').on("click", function()
	{
		if ( $('#Events_confirmation_closed').prop('checked') )
		{
			$('#'+default_table_id+' input').prop('disabled', true);
			$('#'+default_table_id+' a').prop('disabled', true);
			//$('#'+default_addInvitee_id).prop('disabled', true);
		}
		else
		{
			$('#'+default_table_id+' input').prop('disabled', false);
			$('#'+default_table_id+' a').prop('disabled', false);
			//$('#'+default_addInvitee_id).prop('disabled', false);
		}
	});

	// Mejorar: anular interaccion si se cierra la confirmacion de asistentes
	$('input[name="Events[cost_mode]"]').on("click", function()
	{
		costModeChange($('input[name="Events[cost_mode]"]:checked').val());
	});

	costModeChange($('input[name="Events[cost_mode]"]:checked').val());
 });
 
// eventos dinamicos necesitan un bind distinto
$(document).on('click', 'a[href=#removeInvitee]', function()
{
	removeInvitee(this);
	return false;
});



$(document).on('click', 'a[href=#mailInvitee]', function()  
{


	//$(this).parent().parent().find('#table_invitados tr td[0]');

});



$(document).on('click', 'a[href=#resendInvitation]', function()  //funcion que devuelve los 3 parametros para la funcion mailer 
{																//para enviar invitacion
	var asunto;
	asunto = "Invitacion a un Evento";

	var cuerpo; //anda
	cuerpo = "usted ha sido invitado al siguiente evento :"+($('input[name="Events[name]"]').val());	

	var destino;
	destino = " ";


	$('#table-invitados tr td:nth-of-type(1) input').each(function(index)		
	{
		destino = $(this).val(); //anda

		$('#table-invitados tr td:nth-of-type(3) input[type="checkbox"]').each(function(index2)
		{
			if (index==index2)
			{
				if($(this).prop('checked')==false)
				{
					alert("se manda");
					//mailer(destino, asunto, cuaerpo)

					$.ajax({type:"POST",url:"php/mailer.php",data:{t:destino,s:asunto,b:cuerpo},success: function()

					{
						alert("algo");
					}

				});
					
				}
			}
				
		});

	});
	
});



$(document).on('click', 'a[href=#sendBills]', function()  //funcion que devuelve los 3 parametros para la funcion mailer
{														 //envia el balance personal de las cuentas a todos	
	var asunto;
	asunto = "Saldo Pendiente en Evento";

	var destino;
	destino = " ";

	var cuerpo; //anda
	cuerpo = "Correspondiente al evento, "+($('input[name="Events[name]"]').val())+", usted posee un saldo de: ";

	var cuerposal;
	cuerposal= " ";

	var saldo;
	saldo = " ";

	$('#table-invitados tr td:nth-of-type(1) input').each(function(index)		
	{
		destino = $(this).val(); //anda

		$('#table-invitados tr td:nth-of-type(8) input').each(function(index2)
		{
			if (index==index2)
			{
				saldo = $(this).val(); //anda
				cuerposal = cuerpo+saldo; //anda
				//mailer(destino, asunto, cuerposal);
				$.ajax({type:"POST",url:"php/mailer.php",data:{t:destino,s:asunto,b:cuerposal},success: function()

					{
						alert("algo");
					}
			}
				
		});

	});
		
});


/*! \brief 
*/
function costModeChange(toMode)
{
	if (toMode && toMode!=costMode)
	{
		costMode = toMode;

		switch(costMode)
		{
			case '0':
			{
				$('input[name*="Events[cost_val"]').hide();
				$('label[for*="Events_cost_val"]').hide();
			}
			break;

			case '1':
			{
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Costo por Persona');

				$('input[name="Events[cost_val2]"]').hide();
				$('label[for="Events_cost_val2"]').hide();
			}
			break;

			case '2':
			{
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Costo por Adulto');

				$('input[name="Events[cost_val2]"]').show();
				$('label[for="Events_cost_val2"]').show();
				$('label[for="Events_cost_val2"]').text('Costo por Menor');
			}
			break;

			case '3':
			{
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Costo total a dividir');

				$('input[name="Events[cost_val2]"]').hide();
				$('label[for="Events_cost_val2"]').hide();
			}
			break;

			case '4':  //aca hay que hacer algo mas, porque por como lo definimos, val 2 es en funcion de val 1, a demas 
			{			//tal vez se necesite un campo mas, para poner cual es el valor que se va a dividir entre esos porcentajes
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Porcentaje Adulto');

				$('input[name="Events[cost_val2]"]').show();
				$('label[for="Events_cost_val2"]').show();
				$('label[for="Events_cost_val2"]').text('Porcentaje Menor');
			}
			break;

			case '5':
			{
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Costo fijo a dividir');

				$('input[name="Events[cost_val2]"]').hide();
				$('label[for="Events_cost_val2"]').hide();
			}
			break;

			case '6':  //aca hay que hacer algo mas, porque por como lo definimos, val 2 es en funcion de val 1, a demas
			{			//tal vez se necesite un campo mas, para poner cual es el valor que se va a dividir entre esos porcentajes
				$('input[name="Events[cost_val1]"]').show();
				$('label[for="Events_cost_val1"]').show();
				$('label[for="Events_cost_val1"]').text('Porcentaje Adulto');

				$('input[name="Events[cost_val2]"]').show();
				$('label[for="Events_cost_val2"]').show();
				$('label[for="Events_cost_val2"]').text('Porcentaje Menor');
			}
			break;

			default:
			{
				$('input[name*="Events[cost_val"]').show();
				$('label[for*="Events_cost_val"]').show();
				$('label[for*="Events_cost_val"]').text('');
			}
			break;
		}
	}
}

/*! \brief Elimina invitado
*/
function removeInvitee(obj)
{
	$(obj).closest("tr").remove();
}

/*! \brief Agrega invitado
*/
function addInvitee(table_id)
{
	if (!table_id) table_id = default_table_id;

	var rowId = $('#'+table_id+' tbody tr').size();
	$('#'+table_id+' tr:last').after('\
	<tr>\
		<td>\
			<input size="60" maxlength="255" name="Invitees['+rowId+'][email]" id="Invitees_'+rowId+'_email" type="text">\
			<div class="errorMessage" id="Invitees_email_em_" style="display:none"></div>\
		</td>\
        <td>\
        	<input id="ytInvitees_'+rowId+'_admin" type="hidden" value="0" name="Invitees['+rowId+'][admin]">\
        	<input class="inline" name="Invitees['+rowId+'][admin]" id="Invitees_'+rowId+'_admin" type="checkbox">\
        	<div class="errorMessage" id="Invitees_admin_em_" style="display:none"></div>\
        </td>\
        <td>\
			<input id="ytInvitees_'+rowId+'_confirmed" type="hidden" value="0" name="Invitees['+rowId+'][confirmed]">\
			<input class="inline" name="Invitees['+rowId+'][confirmed]" id="Invitees_'+rowId+'_confirmed" type="checkbox">\
			<div class="errorMessage" id="Invitees_confirmed_em_" style="display:none"></div>\
		</td>\
        <td>\
			<input class="inline" name="Invitees['+rowId+'][adults]" id="Invitees_'+rowId+'_adults" type="number">\
			<div class="errorMessage" id="Invitees_adults_em_" style="display:none"></div>\
		</td>\
        <td>\
			<input class="inline" name="Invitees['+rowId+'][kids]" id="Invitees_'+rowId+'_kids" type="number">\
			<div class="errorMessage" id="Invitees_kids_em_" style="display:none"></div>\
		</td>\
        <td>\
        	$\
			<input class="inline" name="Invitees['+rowId+'][cost]" id="Invitees_'+rowId+'_cost" type="number">\
			<div class="errorMessage" id="Invitees_cost_em_" style="display:none"></div>\
		</td>\
        <td>\
        	$\
			<input class="inline" name="Invitees['+rowId+'][spent]" id="Invitees_'+rowId+'_spent" type="number">\
			<div class="errorMessage" id="Invitees_spent_em_" style="display:none"></div>\
		</td>\
		<td>\
        	$\
			<input disabled="disabled" id="Invitees_time" type="number">\
		</td>\
        <td>\
        	<input id="ytInvitees_'+rowId+'_money_ok" type="hidden" value="0" name="Invitees['+rowId+'][money_ok]">\
        	<input class="inline" name="Invitees['+rowId+'][money_ok]" id="Invitees_'+rowId+'_money_ok" value="1" type="checkbox">\
        	<div class="errorMessage" id="Invitees_money_ok_em_" style="display:none"></div>\
        </td>\
        <td class="buttons">\
        	<a class="btn btn-default" href="#mailInvitee" title="mail cuentas o invitacion">\
        		<i class="icon-envelope"></i>\
        	</a>\
        </td>\
        <td class="buttons">\
        	<a class="btn btn-danger remove-invitee" href="#removeInvitee" title="remove">\
        		<i class="icon-remove"></i>\
        	</a>\
        </td>\
	</tr>\
	');

}

/*! \brief 
*/
function calcBalance(table_id)
{
	if (!table_id) table_id = default_table_id;

	var val = 100;

	var table = document.getElementById(table_id);
	for (var i = 0, row; row = table.rows[i]; i++)
	{
		//iterate through rows
		//rows would be accessed using the "row" variable assigned in the for loop
		for (var j = 0, col; col = row.cells[j]; j++)
		{
			//iterate through columns
			//columns would be accessed using the "col" variable assigned in the for loop
			row.cells[j].inputs[0].value = val;
		}  
	}
}

/*! \brief function call scheduler, anti overwhelm
*/
function calcCost(table/*table_id*/)
{
	table=0;
	if (!table) table = $('#'+default_table_id)[0];

		alert('WATCHDOG TRIGGERED');


	var updateNeeded = false;

	//var table = document.getElementById(table_id);
	for (var i = 0, row; row = table.rows[i]; i++)
	{
		//iterate through rows
		//rows would be accessed using the "row" variable assigned in the for loop
		for (var j = 0, col; col = row.cells[j]; j++)
		{
			//iterate through columns
			//columns would be accessed using the "col" variable assigned in the for loop
			var nuval = 99;

			if (row.cells[j].inputs[0].value != nuval)
			{
				updateNeeded = true;
				row.cells[j].input[0].value = nuval;
			}
		}  
	}

	if (updateNeeded) calcBalance();
}