/* globals */
var full_path = 'appdata/walls/';
var thumb_path = full_path+'thumb_';

var flagAutoDelete;

$(document).ready(function()
{
	// workaround yii form submit
	$( "#yii-submit-btn" ).click(function()
	{
		flagAutoDelete = false;
		$( "#wall-form" ).submit();
	});

	// upload attachment
	var options = { 
		//target:   '#Wall_attachment_url',   // target element(s) to be updated with server response 
		dataType: 'json',
		beforeSubmit:  beforeSubmit,  // pre-submit callback 
		success:       afterSuccess,  // post-submit callback 
		resetForm: false        // reset the form after successful submit 
	}; 

	$('#upload').click(function()
	{ 
		$('#uploadForm').ajaxSubmit(options);

		// always return false to prevent standard browser submit and page navigation 
		return false; 
	});

	// delete
	$('#delete').click(function()
	{ 
		if ( $('#Wall_attachment_url').val() )
		{
			deleteAttachment( $('#Wall_attachment_url').val() );
		}

		// always return false to prevent standard browser submit and page navigation 
		return false; 
	});

	$( window ).on( "unload beforeunload", function()
	{
		if ( flagAutoDelete && $('#Wall_attachment_url').val() )
		{
			deleteAttachment( $('#Wall_attachment_url').val() );
		}
	}); 

	// show manager/uploader
	if ( $('#Wall_attachment_url').val() )
	{
		flagAutoDelete = false;
		$('#output').html('<img src="'+thumb_path+$('#Wall_attachment_url').val()+'">');
		$('#uploader').hide();
		$('#manager').show();
	}
	else
	{
		flagAutoDelete = true;
		$('#manager').hide();
		$('#uploader').show();
	}
}); 

function afterSuccess(json)
{
	flagAutoDelete = true;
	$('#Wall_attachment_url').val(json.name);
	$('#output').html('<img src="'+thumb_path+json.name+'">');
	$('#upload').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#uploader').hide();
	$('#manager').show();
}

//function to check file size before uploading.
function beforeSubmit()
{
	//check whether browser fully supports all File API
	if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		if( !$('#imageInput').val()) //check empty input filed
		{
			$("#text-output").html("No seleccionaste ningún archivo para subir!");
			return false;
		}

		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type

		//allow only valid image file types 
		switch(ftype)
		{
    		case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
        	break;
    		default:
        	$("#text-output").html("<b>"+ftype+"</b> Tipo de archivo no soportado! Formatos posibles: PNG, GIF y JPEG.");
			return false
		}

		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#text-output").html("<b>"+bytesToSize(fsize) +"</b> El archivo es demasiado grande! <br />Por favor, reducí el tamaño de la foto con un editor de imágenes. El máximo permitido es <b>"+bytesToSize(1048576) +"</b>.");
			return false
		}
		
		$('#upload').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#text-output").html("");  

		// borrar anterior
		if ( $('#Wall_attachment_url').val() )
		{
			deleteAttachment( $('#Wall_attachment_url').val() );
		}
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#text-output").html("Por favor, actualiza tu navegador para poder subir fotos!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes)
{
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	if (bytes == 0) return '0 Bytes';
	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

//function to check file size before uploading.
function deleteAttachment(url)
{
	//alert('DUMMY: DELETE PHOTO');
	//$('#loading-img').show(); //hide submit button
	$("#text-output").html(""); 

	// Actualizamos la url
	$('#Wall_attachment_url').val('');
	$('#output').html('');

	$('#manager').hide();
	$('#uploader').show();
}