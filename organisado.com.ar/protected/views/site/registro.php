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