<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap (http://www.bootstrapcdn.com, resposive + icons)-->
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

	<!-- blueprint CSS framework -->
	<!-- rompe el slide link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" / -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<!-- contiene css del CMenu link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" / -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/theme.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php if ($_SERVER['SERVER_ADDR'] == "::1") echo "<div style='position:fixed;top:0;left:0;padding:0 2px;color:white;background:red;z-index:99999;'>MODE: localhost (".$_SERVER['SERVER_ADDR'].")</div>"; ?>
	<!--header-->
	<div id="header">
		<div class="wrapped">
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/" id="logo" class="pull-left">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/logo_small.png">
			</a>

			<div id="mainmenu" class="navbar">
			<?php $this->widget('zii.widgets.CMenu',array(
				'activateParents'=> true,
				'items'=>array(
					array('label'=>'inicio', 'url'=>array('/site/index')),
					array('label'=>'crear evento', 'url'=>array('/events/create'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'mis eventos', 'url'=>array('/events/'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'crear usuario', 'url'=>array('/users/create'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'contacto', 'url'=>array('/site/contact')),
					array('label'=>'nosotros', 'url'=>array('/site/nosotros'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'¿qué es?', 'url'=>array('/site/about'),  'visible'=>Yii::app()->user->isGuest),

					array('label'=>'salir ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				),
				'encodeLabel' => false,
				'htmlOptions' => array(
					'class'=>'nav pull-right',
				),
				'submenuHtmlOptions' => array(
					'class' => 'dropdown-menu',
				),
				)); ?>

				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a id="menuToggle" class="btn-navbar pull-right" data-toggle="collapse" data-target=".nav-collapse">
					<span class="jQ-i-bar"></span>
					<span class="jQ-i-bar"></span>
					<span class="jQ-i-bar"></span>
				</a>
			</div>
		</div>
	</div><!-- header -->


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	
	<?php
		if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index')
		{
			echo $content;
		}
		else
		{
			echo '<div class="container marketing">'.$content.'</div>';
		}
	?>
	

	<div id="footer-clear"></div>

	<div id="footer">
		<!-- FOOTER -->
        <footer id="mainFooter">
            <div class="wrapped">
                <p class="pull-right"><a id="goTop" href="#">^</a></p>
                <p>© 2013 organiSado  ·  <a href="<?php echo $this->createUrl('/site/terminos') ?>">privacidad y términos</a> · Seguinos en
                	<a href="http://facebook.com">Facebook</a> y en <a href="http://twitter.com">Twitter</a>.
                </p>
            </div>
        </footer>
	</div><!-- footer -->
</body>
</html>
