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

	$('#'+table_id+' tr:last').after('\
		<tr>\
            <td>\
                <input size="60" maxlength="255" value="" name="Events[name]" id="Events_name" type="text">\
            </td>\
            <td>\
				<input id="ytEvents_confirmation_closed" type="hidden" value="0" name="Events[confirmation_closed]"><input disabled="disabled" name="Events[confirmation_closed]" id="Events_confirmation_closed" value="1" checked="checked" type="checkbox">\
			</td>\
            <td>\
				<input id="ytEvents_confirmation_closed" type="hidden" value="0" name="Events[confirmation_closed]"><input disabled="disabled" name="Events[confirmation_closed]" id="Events_confirmation_closed" value="1" checked="checked" type="checkbox">\
			</td>\
            <td>\
				<input disabled="disabled" name="Events[time]" id="Events_time" type="number" value="13:29">\
			</td>\
            <td>\
				<input disabled="disabled" name="Events[time]" id="Events_time" type="number" value="13:29">\
			</td>\
            <td>\
            	$\
				<input onchanged="calcCost();" name="Events[time]" id="Events_time" type="number" value="13:29">\
			</td>\
            <td>\
            	$\
				<input disabled="disabled" name="Events[time]" id="Events_time" type="number" value="13:29">\
			</td>\
			<td>\
            	$\
				<input disabled="disabled" name="Events[time]" id="Events_time" type="number" value="13:29">\
			</td>\
            <td>\
				<input id="ytEvents_confirmation_closed" type="hidden" value="0" name="Events[confirmation_closed]">\
				<input name="Events[confirmation_closed]" id="Events_confirmation_closed" value="1" checked="checked" type="checkbox">\
			</td>\
            <td class="buttons">\
            	<a class="btn btn-default" href="#mailInvitee" title="mail cuentas o invitacion">\
            		<i class="icon-envelope"></i>\
            	</a>\
            </td>\
            <td class="buttons">\
            	<a class="btn btn-danger remove-invitee" href="#removeInvitee" title="remove" >\
            		<i class="icon-remove"></i>\
            	</a>\
            </td>  \
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