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
        <link rel="stylesheet" type="text/css" href="theme.css" />
    </head>
    <body>
        <!--header-->
        <div id="header">
            <div class="wrapped">
                <a href="/" id="logo">
                    <img src="logo_small.png">
                </a>

                <ul id="menu" class="nav nav-pills pull-right hidden-phone">
                    <li class="active"><a href="#">inicio</a></li>
                    <li><a href="#">login</a></li>
                    <li><a href="#">registro</a></li>
                    <li><a href="#">contacto</a></li>
                </ul>

                <a id="menuToggle" class="btn btn-small pull-right visible-phone" href="#"></a>
            </div>
        </div>


        <!-- slider -->
        <?
        if (count($photos)) {
            shuffle($photos);
            ?>
            <div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?
                    foreach ($photos as $photo) {
                        ?>
                        <div class="item<? echo ($photo == $photos[0] ? ' active' : ''); ?>">
                            <!--<img src="" alt="">-->
                            <div class="imgContainer" style="background-image:url('<? echo $headerImgPath . $photo ?>');"></div>
                            <div class="container">
                                <div class="carousel-caption">
                                    <h1>Un aplauso para el organizador...</h1>
                                    <p class="lead">Ahora, vas a poder descansar y ahorrar tiempo, mucho tiempo!</p>
                                    <br>
                                    <a class="btn btn-large btn-primary" href="#">registrate</a>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
            </div>
            <?
        }
        ?>


        <div class="container marketing">
            <div class="row">
                <div class="span4 pull-right imgHolder">
                    <img src="img/i/clock.png">                
                </div>

                <div class="span6 description">
                    <h2 class="featurette-heading">Organizá<span class="muted"> fácil y rápido.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="span4 pull-left imgHolder">
                    <img src="img/i/users.png">
                </div>
                <div class="span6 description">
                    <h2 class="featurette-heading">Invitá<span class="muted"> y hacé un seguimiento.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="span4 pull-right imgHolder">
                    <img src="img/i/wine.png">
                </div>
                <div class="span6 description">
                    <h2 class="featurette-heading">Relajate<span class="muted">, nosotros hacemos el resto.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>
        </div>


        <!-- FOOTER -->
        <footer id="mainFooter">
            <div class="wrapped">
                <p class="pull-right"><a id="goTop" href="#">⌃</a></p>
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