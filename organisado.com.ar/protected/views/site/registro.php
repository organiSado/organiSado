<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' | registro';
$this->breadcrumbs=array(
        'registro',
);
?>

<div class="row">
  <div class="login-form">
    <h1>Registrarse</h1>
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
          <select class="selectpicker">
            <option>Masculino</option>
            <option>Femenino</option>
          </select>
        </div>
        <div class="control-group">
          <input type="text" placeholder="Email">
        </div>
        <div class="control-group">
          <input type="Password" placeholder="Contraseña">
        </div>
        <a class="btn btn-success" id="mostrar">Registrarse</a>
      </fieldset>
    </form>
  </div>
</div>


        <!-- jQuery -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <!-- bootstrap -->
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

        <script src="js/intro.js"></script>

        <script type="text/javascript">
          $(function() {
            $("#mostrar").click(function(e) {
            e.preventDefault();
            $("#condiciones").modal('show');
            });
          });
        </script>


<!--popup condiciones -->
<div class="modal hide" id="condiciones">
  <div class="modal-header">
    <h2> Términos y condiciones </h2>
  </div>
  <div class="modal-body">
    <p> lorum lorem etc etc etc</p>
  </div>
  <div class="modal-footer">
    <div>
    <a href="#" data-dismiss="modal" class="btn">Declinar</a>
    <a href="#" class="btn btn-primary">Aceptar</a>
    </div>
  </div>
</div>  