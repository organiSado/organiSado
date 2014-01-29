<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;


/* slider */
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
    
if (count($photos))
{
    shuffle($photos);
?>
<div id="jQSlide" class="carousel slide">
    <div class="carousel-inner">
<?php
        foreach ($photos as $photo)
        {
?>
            <div class="item<?php echo ($photo == $photos[0] ? ' active' : ''); ?>">
                <div class="imgContainer" style="background-image:url('<? echo $headerImgPath . $photo ?>');"></div>
                <div class="carousel-caption">
                    <h1>Un aplauso para el organizador...</h1>
                    <p class="lead">Ahora, vas a poder descansar y ahorrar tiempo, mucho tiempo!</p>
                    <br>
                    <a class="btn btn-large btn-primary" href="<?php echo $this->createUrl('/site/registro') ?>">registrate</a>
                </div>
            </div>
<?php
        }
?>
    </div>
    <a class="left carousel-control" href="#jQSlide" data-slide="prev">‹</a>
    <a class="right carousel-control" href="#jQSlide" data-slide="next">›</a>
</div>
<?php
}
?>
		
<div id="login-container">
	<!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-header" id="modlogin">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
       <h3 id="myModalLabel">Iniciar Seción</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                
                <div class="controls">
                    <input type="text" id="inputEmail" placeholder="Email" onfocus="#F60" >
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputPassword">Contraseña</label>
                
                <div class="controls">
                    <input type="password" id="inputPassword" placeholder="Contraseña">
                </div>
            </div>
        
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox"> Recordarme
                    </label>
        
                    <button id="bttn-entrar" type="submit" class="btn btn-large">Entrar</button>
                </div>
            </div>
        </form>
    </div>
</div>



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



<!-- jQuery -->
<script src="http://code.jquery.com/jquery.js"></script>
<!-- bootstrap -->
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

<script src="js/intro.js"></script>