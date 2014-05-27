/* globals */
var default_table_id 		= "table-invitados";
var default_addInvitee_id 	= "add-invitee";
var costMode = -1;

// eventos dinamicos necesitan un bind distinto
$(document).on('click', 'a[href=#removeInvitee]', function()
{
	removeInvitee(this);
	
	calcCost();
	
	return false;
});

// balance
$(document).on('change', 'input[name*="[cost]"], input[name*=spent]', function()
{
	calcBalance();
});

// costo
$(document).on('change', 'input[name*=confirmed], input[name*=cost_val], input[name*=adult], input[name*=kids], input[name*=spent]', function()
{	
	calcCost();
});

$(document).on("ready",function()
{
	// map
	$('input[name*=location_address]').on("keyup", function()
	{
		scheduleCall(this, findAddressInEditorMap);
		return false;
	});
	
	// al presionar el botton de agregar invitado
	$('#'+default_addInvitee_id).on("click", function()
	{
		addInvitee();
		calcCost();
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
	$('input[name*=cost_mode]').on("click", function()
	{
		costModeChange($('input[name="Events[cost_mode]"]:checked').val());
	});
	
	costModeChange($('input[name="Events[cost_mode]"]:checked').val());
 });
 

function mailUser(destino, asunto, cuerpo)
{
	$.ajax({type:"POST",
			url:"php/mailer.php",
			data:{t:destino,s:asunto,b:cuerpo},
			success: function()
			{
				alert("Correo enviado!");
			}
	});
}

$(document).on('click', 'a[href=#mailInvitee]', function()  
{
	mailUser($(this).closest('tr').find('td:nth-of-type(1) input').val(),
			 "Invitacion a un Evento",
			 "usted ha sido invitado al siguiente evento :"+($('input[name="Events[name]"]').val()) );
			 
	
	return false;
});

//funcion que devuelve los 3 parametros para la funcion mailer
//para enviar invitacion
$(document).on('click', 'a[href=#resendInvitation]', function()   
{																
	$('#table-invitados tr td:nth-of-type(1) input').each(function(index)		
	{
		var destino = $(this).val(); //anda

		$('#table-invitados tr td:nth-of-type(3) input[type="checkbox"]').each(function(index2)
		{
			if (index==index2 && $(this).prop('checked')==false)
			{
				mailUser(destino,
						 "Invitacion a un Evento", 
						 "usted ha sido invitado al siguiente evento :"+($('input[name="Events[name]"]').val()) );
			}	
		});

	});
	
});

//funcion que devuelve los 3 parametros para la funcion mailer
//envia el balance personal de las cuentas a todos	
$(document).on('click', 'a[href=#sendBills]', function()
{														 
	$('#table-invitados tr td:nth-of-type(1) input').each(function(index)		
	{
		var destino = $(this).val(); //anda

		$('#table-invitados tr td:nth-of-type(8) input').each(function(index2)
		{
			if (index==index2)
			{
				mailUser(destino,
						 "Saldo Pendiente en Evento", 
						 "Correspondiente al evento, "+($('input[name="Events[name]"]').val())+", usted posee un saldo de: "+$(this).val() );
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
				$('input[name="Events[cost_val1]"]').hide();
				$('label[for="Events_cost_val1"]').hide();
				$('label[for="Events_cost_val1"]').text('Costo total a dividir');

				$('input[name="Events[cost_val2]"]').hide();
				$('label[for="Events_cost_val2"]').hide();
			}
			break;

			case '4':  //aca hay que hacer algo mas, porque por como lo definimos, val 2 es en funcion de val 1, a demas 
			{			//tal vez se necesite un campo mas, para poner cual es el valor que se va a dividir entre esos porcentajes
				$('input[name="Events[cost_val1]"]').hide();
				$('label[for="Events_cost_val1"]').hide();
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
				$('label[for="Events_cost_val1"]').text('Costo fijo a dividir');

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
		
		calcCost();
	}
}

/*! \brief 
*/
function findUserByEmail(obj)
{
	var userInput = $(obj);
	var user = userInput.val();

	$.ajax({type:"POST",
			url:"index.php?r=users/usersearch",
			data:{ Users:{email:user} },
			success: function(data, textStatus, jqXHR )
			{
				userInput.after( "<p>"+data+"</p>" );
			}
	});
}


$(document).on('keyup', 'input[name*="[email]"]', function()
{
	scheduleCall(this, findUserByEmail, true);
});




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
        	<input class="inline" name="Invitees['+rowId+'][admin]" id="Invitees_'+rowId+'_admin" value="1" type="checkbox">\
        	<div class="errorMessage" id="Invitees_admin_em_" style="display:none"></div>\
        </td>\
        <td>\
			<input id="ytInvitees_'+rowId+'_confirmed" type="hidden" value="0" name="Invitees['+rowId+'][confirmed]">\
			<input class="inline" name="Invitees['+rowId+'][confirmed]" id="Invitees_'+rowId+'_confirmed" value="1" type="checkbox">\
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
function sumColumn(col)
{
	sum = 0;
	
	$('#'+default_table_id+' tbody tr td:nth-of-type('+col+')').each(function()
	{
		sum += parseInt( $(this).find('input').val() ) || 0;
	});
	
	return sum;
}

/*! \brief 
*/
function calcInvitees(type)
{
	sum = 0;
	
	$('#'+default_table_id+' tbody tr').each(function()
	{
		var will_assist = $(this).closest('tr').find('td:nth-of-type(3) input[type="checkbox"]').prop('checked');
		if(will_assist)
		{
			// adults
			if (type == 'adults' || type == 'both') sum += parseInt( $(this).find('td:nth-of-type(4) input').val() ) || 0;
			
			// kids
			if (type == 'kids' || type == 'both') sum += parseInt( $(this).find('td:nth-of-type(5) input').val() ) || 0;
			
			// invitees (sin tener en cuenta acompa;antes)
			if (type == 'groups') sum += 1;
		}
	});
	
	return sum;
}

/*! \brief 
*/
function calcBalance()
{
	$('#'+default_table_id+' tbody tr td:nth-of-type(8)').each(function()
	{
		var cost = $(this).closest('tr').find('td:nth-of-type(6) input').val();
		var spent = $(this).closest('tr').find('td:nth-of-type(7) input').val();
		$(this).closest('tr').find('td:nth-of-type(8) input').val(spent-cost);
	});
}

/*! \brief function call scheduler, anti overwhelm
*/
function calcCost()
{
	var cost1 = parseInt($('#Events_cost_val1').val()) || 0;
	var cost2 = parseInt($('#Events_cost_val2').val()) || 0;
	
	var totalGroups = calcInvitees('groups');
	var totalAdults = calcInvitees('adults');
	var totalKids = calcInvitees('kids');
	var totalInvitees = totalAdults + totalKids;
	
	var totalSpent = sumColumn(7); // contempla casos donde invitados que no asistan colaboren con las compras
	
	$('#'+default_table_id+' tbody tr td:nth-of-type(6)').each(function()
	{
		var adults = parseInt( $(this).closest('tr').find('td:nth-of-type(4) input').val() ) || 0;
		var kids = parseInt( $(this).closest('tr').find('td:nth-of-type(5) input').val() ) || 0;

		var will_assist = $(this).closest('tr').find('td:nth-of-type(3) input[type="checkbox"]').prop('checked');
		
		var cost = 0;

		if(will_assist)
		{
			switch(costMode)
			{
				case '0':
				{
					// organizador invita
					cost = 0;
				}
				break;
	
				case '1':
				{
					// costo fijo por persona
					cost = cost1 * (adults+kids);
				}
				break;
	
				case '2':
				{
					// costo segun adulto/niño
					cost = cost1 * adults + cost2 * kids;
				}
				break;
	
				case '3':
				{
					// costo total entre todos los asistentes sin distincion
					/*var cost_per_person = cost1 / totalInvitees;
					cost = cost_per_person * (adults+kids);*/
					
					/*var cost_per_person = totalSpent / totalInvitees;
					cost = cost_per_person * (adults+kids);*/
					
					cost = totalSpent / totalGroups;
				}
				break;
	
				case '4':
				{
					if (cost2 < 0 || cost2 > 100)
					{
						alert('Porcentaje Menor Fuera de Rango!');
						break;	
					}
					
					// costo total entre todos los asistentes segun adulto o ni;o
					var cost_on_kids = cost2/100 * totalSpent;
					var cost_on_adults = totalSpent - cost_on_kids;
					
					var cost_per_kid = 0;
					var cost_per_adult = 0;
					if (totalKids==0)
					{
						cost_per_adult = totalSpent/totalAdults;
					}
					else if (totalAdults==0)
					{
						cost_per_kid = totalSpent/totalKids;
					}
					else
					{
						cost_per_kid = cost_on_kids/totalKids;
						cost_per_adult = cost_on_adults/totalAdults;
					}

					cost = cost_per_adult * adults + cost_per_kid * kids;
				}
				break;
	
				case '5':
				{
					// costo fijo entre todos los asistentes por grupos
					cost = cost1 / totalGroups;
				}
				break;
	
				case '6':
				{
					if (cost2 < 0 || cost2 > 100)
					{
						alert('Porcentaje Menor Fuera de Rango!');
						break;	
					}
					
					// costo total entre todos los asistentes segun adulto o ni;o
					var cost_on_kids = cost2/100 * cost1;
					var cost_on_adults = cost1 - cost_on_kids;
					
					var cost_per_kid = 0;
					var cost_per_adult = 0;
					if (totalKids==0)
					{
						cost_per_adult = cost1/totalAdults;
					}
					else if (totalAdults==0)
					{
						cost_per_kid = cost1/totalKids;
					}
					else
					{
						cost_per_kid = cost_on_kids/totalKids;
						cost_per_adult = cost_on_adults/totalAdults;
					}

					cost = cost_per_adult * adults + cost_per_kid * kids;				
				}
				break;
	
				default:
				{
					alert('Modo invalido!');
				}
				break;
			}
		}
				
		$(this).find('input').val(cost);
	});
	
	calcBalance();
}