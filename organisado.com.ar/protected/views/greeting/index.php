<?php
/* @var $this GreetingController */

$this->breadcrumbs=array(
	'Saludos',
);
?>
<h1><? echo $content ?></h1>

<p>
	<? echo $this->message ?>
	<br>
	<?php echo $this->id . '/' . $this->action->id; ?>
</p>
