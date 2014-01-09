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
        <meta charset="utf-8">
        <title>organiSado</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Organizá tus asados, GRATIS!">
        <meta name="author" content="Joel Quatrocchi">

        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Bootstrap (http://www.bootstrapcdn.com, resposive + icons)-->
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/theme.css" />
    </head>
    <body>
        <!--header-->
        <div id="header">
            <div class="wrapped">
                <a href="/" id="logo" class="pull-left">
                    <img src="logo_small.png">
                </a>

                <div class="navbar">
                    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                    <a id="menuToggle" class="btn-navbar pull-right" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="jQ-i-bar"></span>
                        <span class="jQ-i-bar"></span>
                        <span class="jQ-i-bar"></span>
                    </a>

                    <div class="nav-collapse collapse">
                        <ul id="menu" class="nav nav-pills pull-right">
                            <li><a href="index.php">inicio</a></li>
                            <li class="active"><a href="login.php">login</a></li>
                            <li><a href="registro.php">registro</a></li>
                            <li><a href="contacto.php">contacto</a></li>
                            <li><a href="nosotros.php">nosotros</a></li>
                            <li><a href="about.php">¿qué es?</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        
       
        
        
        
 		<div class="container marketing" align="center">
  	 	 <div class="content">
    	 	<div class="row">
     		   <div class="login-form">
      		     <h2>Iniciar Sesión</h2>
      		  	  <form action="">
       		      <fieldset>
        	      <div class="control-group">
               	  <input type="text" placeholder="Email">
         	      </div>
         	      <div class="control-group">
           	      <input type="text" placeholder="Contraseña">
          	      </div>
                  <button class="btn btn-primary" type="submit">Enviar</button>
             	
           		  </fieldset>
         		  </form>
      		   </div>
     		  </div>
  		   </div>
 	    </div> <!-- /container -->



        <!-- FOOTER -->
        <footer id="mainFooter">
            <div class="wrapped">
                <p class="pull-right"><a id="goTop" href="#">^</a></p>
                <p>© 2013 organiSado  ·  <a href="#">privacidad y términos</a></p>
            </div>
        </footer>

        <!-- jQuery -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <!-- bootstrap -->
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

        <script src="js/intro.js"></script>
    </body>
</html>