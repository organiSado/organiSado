<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
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
                </div>
            </div>
        </div>
		
		
		
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Inicio', 'url'=>array('/site/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Registro', 'url'=>array('/site/registro')),
				array('label'=>'Contacto', 'url'=>array('/site/contact')),
				array('label'=>'Nosotros', 'url'=>array('/site/Nosotros')),
				array('label'=>'¿que es?', 'url'=>array('/site/about')),
				
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<!-- FOOTER -->
        <footer id="mainFooter">
            <div class="wrapped">
                <p class="pull-right"><a id="goTop" href="#">^</a></p>
                <p>© 2013 organiSado  ·  <a href="#">privacidad y términos</a></p>
            </div>
        </footer>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
