<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;


$cs = Yii::app()->getClientScript();

$cs->registerScriptFile('http://code.jquery.com/jquery.js');
$cs->registerScriptFile('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/intro.js');


/*
<!-- jQuery -->
<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
<!-- bootstrap -->
<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/intro.js"></script>
*/


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
                <div class="imgContainer" style="background-image:url('<?php echo Yii::app()->request->baseUrl."/".$headerImgPath . $photo ?>');"></div>
                <div class="carousel-caption">
                    <h1>Un aplauso para el organizador...</h1>
                    <p class="lead">Ahora, vas a poder descansar y ahorrar tiempo, mucho tiempo!</p>
                    <br>
                    <a class="btn btn-large btn-primary" href="<?php echo $this->createUrl('/users/create') ?>">registrate</a>
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

<div class="container marketing">
    <div class="row">
        <div class="span4 pull-right imgHolder">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/i/clock.png">                
        </div>

        <div class="span6 description">
            <h2 class="featurette-heading">Organizá<span class="muted"> fácil y rápido.</span></h2>
            <p class="lead ">¿Por qué vas a estar anotando y haciendo cuentas en un papel cuando lo podemos hacer nosotros por vos? No pierdas más tiempo, no esperes más!</p>
            <p class="lead">Ya podés <a href="<?php echo $this->createUrl('/users/create') ?>">comenzar...</a></p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="span4 pull-left imgHolder">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/i/users.png">
        </div>
        <div class="span6 description">
            <h2 class="featurette-heading">Invitá<span class="muted"> y hacé un seguimiento.</span></h2>
            <p class="lead ">¿Estás cansado de buscar las direcciones de e-mail y tener que mandar a cada uno lo que tiene que traer? ¿Y después quién tiene que estar preguntando si van a asistir o tratando de recalcular todo por lo que otros no llevan? Vos, ¿no? </p>
            <p class="lead"><a href="<?php echo $this->createUrl('/users/create') ?>">Registrate</a> ahora, vas a poder invitarlos a todos con 1 solo click y ellos te van a avisar a vos!</p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="span4 pull-right imgHolder">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/i/wine.png">
        </div>
        <div class="span6 description">
            <h2 class="featurette-heading">Relajate<span class="muted">, nosotros hacemos el resto.</span></h2>
            <p class="lead ">Olvidate de todo lo que tenías que hacer antes para organizar un buen asado con los amigos, en organiSado ya tenemos todo cocinado. Bueno, todo menos el asado...</p>
            <p class="lead">¿La vas a seguir pensando? <a href="<?php echo $this->createUrl('/users/create') ?>">Registrate!</a></p>
        </div>
    </div>
</div>