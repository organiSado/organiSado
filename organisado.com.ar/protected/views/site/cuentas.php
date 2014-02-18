<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' | GMap';
$this->breadcrumbs=array(
        'GMap',
);

	$cs = Yii::app()->getClientScript();

	$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/accordion.css');

  var_dump($_REQUEST);



?>     
         
    
    

    <form action="eventos" method="get">
      <section class="ac-container">
        <div>
          <input id="tipo1" name="cuentas" type="radio" value="0" <?php echo ($_REQUEST['cuentas']==0? 'checked':'')?> />
          <label for="tipo1">El organizador invita</label>
          <article class="ac-small">
            <p>El evento no tiene costo alguno para los invitados</p>
          </article>
        </div>
        <div>
          <input id="tipo2" name="cuentas" type="radio" value="1" <?php echo ($_REQUEST['cuentas']==1? 'checked':'')?> />
          <label for="tipo2">Se establece un costo fijo</label>
          <article class="ac-medium">
            <p>El costo del evento para todos los invitados sera igual a un valor fijo, independientemente del costo total del evento. </p>
          </article>
        </div>
        <div>
          <input id="tipo3" name="cuentas" type="radio" value="2" <?php echo ($_REQUEST['cuentas']==2? 'checked':'')?> />
          <label for="tipo3">Se establece un costo fijo segun asistente</label>
          <article class="ac-large">
            <p>Se distinguen dos valores fijos de costo para cada uno de los tipos de asistentes respectivamente, adultos y menores, tambien independientemente del costo total del evento. </p>
          </article>
        </div>
        <div>
          <input id="tipo4" name="cuentas" type="radio" value="3" <?php echo ($_REQUEST['cuentas']==3? 'checked':'')?>/>
          <label for="tipo4">Se divide lo gastado en partes iguales</label>
          <article class="ac-large">
            <p>Se divide el costo total del evento entre todos los asistentes sin distincion alguna. </p>
          </article>
        </div>
        <div>
          <input id="tipo5" name="cuentas" type="radio" value="4" <?php echo ($_REQUEST['cuentas']==4? 'checked':'')?> />
          <label for="tipo5">Se divide lo gastado segun asistentes</label>
          <article class="ac-large">
            <p>Se establece un valor diferente de costo para cada uno de los tipos de asistentes, adultos y menores, estos valores se calculan a partir del costo total del evento, y el costo
            correspondiente a los asistentes menores, se calculará como un porcentaje del costo de un asistente adulto, segun se lo indique debajo. </p>
          </article>
        </div>
        <div>
          <input id="tipo6" name="cuentas" type="radio" value="5" <?php echo ($_REQUEST['cuentas']==5? 'checked':'')?>/>
          <label for="tipo6">Se divide un valor fijo en partes iguales</label>
          <article class="ac-large">
            <p>Se divide un valor fijo que representa el costo total, entre todos los asistentes sin distincion alguna. </p>
          </article>
        </div>
        <div>
          <input id="tipo7" name="cuentas" type="radio" value="6" <?php echo ($_REQUEST['cuentas']==6? 'checked':'')?>/>
          <label for="tipo7">Se divide un valor fijo segun asistente</label>
          <article class="ac-large">
            <p>Se establece un valor diferente de costo para cada uno de los tipos de asistentes, adultos y menores, estos valores se calculan a partir de un valor fijo que represental costo total del evento, y el costo
            correspondiente a los asistentes menores, se calculará como un porcentaje del costo de un asistente adulto, segun se lo indique debajo.</p>
          </article>
        </div>

      </section>
        </div>

        <input type="submit">
    </form>
    



        
        
