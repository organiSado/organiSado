/* globals */
var default_table_id 		= "table-invitados";
var default_addInvitee_id 	= "add-invitee";
var costMode = -1;

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
	// al presionar el botton de agregar invitado
	$('#'+default_addInvitee_id).on("click", function()
	{
		calcCost();
		return false;
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