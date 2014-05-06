<?php
/* @var $this EventsController */
/* @var $data Events */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_name')); ?>:</b>
	<?php echo CHtml::encode($data->location_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('location_address')); ?>:</b>
	<?php echo CHtml::encode($data->location_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_lat')); ?>:</b>
	<?php echo CHtml::encode($data->location_lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location_long')); ?>:</b>
	<?php echo CHtml::encode($data->location_long); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmation_closed')); ?>:</b>
	<?php echo CHtml::encode($data->confirmation_closed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_mode')); ?>:</b>
	<?php echo CHtml::encode($data->cost_mode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_val1')); ?>:</b>
	<?php echo CHtml::encode($data->cost_val1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_val2')); ?>:</b>
	<?php echo CHtml::encode($data->cost_val2); ?>
	<br />

	*/ ?>

</div>