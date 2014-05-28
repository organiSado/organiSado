<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span><?php echo $this->t('1#Elegir Archivos|0#Elegir Archivo', $this->multiple); ?></span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <?php if ($this->multiple) { ?>
		<button type="submit" class="btn btn-primary start">
			<i class="icon-upload icon-white"></i>
			<span>Iniciar subida</span>
		</button>
		<button type="reset" class="btn btn-warning cancel">
			<i class="icon-ban-circle icon-white"></i>
			<span>Cancelar subida</span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<i class="icon-trash icon-white"></i>
			<span>Eliminar</span>
		</button>
		<input type="checkbox" class="toggle">
        <?php } ?>
	</div>
	<div class="span5">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<!--div id="links"-->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
		<?php  if(is_array($this->gallery) && count($this->gallery) ): ?>
			<?php
				$base_path = Yii::app()->request->baseUrl;
			?>
		    <?php  foreach($this->gallery as $photo): ?>
				<?php
					$url =  $base_path.$photo->url;
					$photo_path = explode("/", $photo->url);
					$thumb_url =  $base_path.implode("/", array_insert("thumbs", count($photo_path)-1, $photo_path) );
				?>
				
				<tr class="template-download fade in" style="height: 77px;">
					<td class="preview">
						<a href="<?php echo $url; ?>" title="<?php //echo $photo->name; ?>">
				        	<img src="<?php echo $thumb_url; ?>" alt="<?php echo $photo->name; ?>">
						</a>
				    </td>

			        <td class="name">
			            <a href="<?php echo $url; ?>" title="<?php //echo $photo->name; ?>">
				        	<?php echo $photo->name; ?>
						</a>
			        </td>
			        <td class="size"><span><?php echo @filesize($url); ?></span></td>
			        <td colspan="2"></td>
				    
				    <td class="delete">
				        <button class="btn btn-danger" data-type="POST" data-url="<?php echo $base_path; ?>/index.php?r=events/deleteuploaded&url=<?php echo $photo->url; ?>">
				            <i class="icon-trash icon-white"></i>
				            <span>Eliminar</span>
				        </button>
				        <input type="checkbox" name="delete" value="1">
				    </td>
				</tr>
			<?php endforeach; ?>
		<?php  endif; ?>
	</tbody>
</table>
<!--/div-->
<?php if ($this->showForm) echo CHtml::endForm();?>
