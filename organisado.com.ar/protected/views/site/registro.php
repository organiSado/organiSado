<?
$imgPath = "img/";
$headerImgPath = $imgPath . "header/";
// obtenemos todas las fotos subidas a la carpeta dedicada header
$entries = scandir($headerImgPath);
$photos = array();
foreach ($entries as $entry) {
    if (is_file($headerImgPath . $entry)) {
        if (preg_match("/\.(jpe?g|png|gif)$/", $entry)) {
            $photos[] = $entry;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        

        <!-- Bootstrap (http://www.bootstrapcdn.com, resposive + icons)-->
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/theme.css" />
    </head>
    <body>
        
        
        
 		<div class="container marketing" align="center">
  	 	 <div class="content">
    	 	<div class="row">
     		   <div class="login-form">
      		     <h2>Registrarse</h2>
      		  	  <form action="">
       		      <fieldset>
        	      <div class="control-group">
               	  <input type="text" placeholder="Nombre">
         	      </div>
         	      <div class="control-group">
           	      <input type="text" placeholder="Apellido">
          	      </div>
                  <div class="control-group">
           	      <input type="date" placeholder="Fecha de nacimiento">
          	      </div>
                  <div class="control-group">
           	      <input type="text" placeholder="Sexo">
          	      </div>
                 
                  
                  <div class="control-group">
           	      <input type="text" placeholder="Email">
          	      </div>
                  <div class="control-group">
           	      <input type="Password" placeholder="Contraseña">
          	      </div>
             	  <button class="btn btn-primary" type="submit">Enviar</button>
             	
           		  </fieldset>
         		  </form>
      		   </div>
     		  </div>
  		   </div>
 	    </div> <!-- /container -->



        

        <!-- jQuery -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <!-- bootstrap -->
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

        <script src="js/intro.js"></script>
    </body>
</html>