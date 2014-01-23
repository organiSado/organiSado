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
        

        

        <div class="container marketing">
            <div class="row">
                <div class="span4 pull-right imgHolder">
                    <img src="img/i/users.png">                
                </div>

                <div class="span6 description">
                    <h2 class="featurette-heading">Puesto<span class="muted"> Joel Quatro.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="span4 pull-left imgHolder">
                    <img src="img/i/users.png">
                </div>
                <div class="span6 description">
                    <h2 class="featurette-heading">Puesto<span class="muted"> Leo Celedon.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>

            <hr>
            
            <div class="row">
                <div class="span4 pull-right imgHolder">
                    <img src="img/i/users.png">
                </div>
                <div class="span6 description">
                    <h2 class="featurette-heading">Puesto<span class="muted"> Martin Matus.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>
            
                        <hr>

            <div class="row">
                <div class="span4 pull-left imgHolder">
                    <img src="img/i/users.png">
                </div>
                <div class="span6 description">
                    <h2 class="featurette-heading">Puesto<span class="muted"> Martin Heredia.</span></h2>
                    <p class="lead ">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
            </div>
        </div>


      
        <!-- jQuery -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <!-- bootstrap -->
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

        <script src="js/intro.js"></script>
    </body>
</html>