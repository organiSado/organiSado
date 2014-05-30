<?php

include("php/img_process.php");

class EventsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete', 'upload', 'deleteuploaded'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionUpload()
    {
	    Yii::import( "xupload.models.XUploadForm" );
	    //Here we define the paths where the files will be stored temporarily
	    $path = realpath( Yii::app( )->getBasePath( )."/../appdata/tmp/" )."/";
	    $publicPath = Yii::app( )->getBaseUrl( )."/appdata/tmp/";
	 
	    //This is for IE which doens't handle 'Content-type: application/json' correctly
	    header( 'Vary: Accept' );
	    if( isset( $_SERVER['HTTP_ACCEPT'] ) 
	        && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
	        header( 'Content-type: application/json' );
	    } else {
	        header( 'Content-type: text/plain' );
	    }
	 
	    //Here we check if we are deleting and uploaded file
	    if( isset( $_GET["_method"] ) ) {
	        if( $_GET["_method"] == "delete" )
	        {
	        	if( $_GET["file"][0] !== '.' )
	        	{
	        		$file = $path.$_GET["file"];
	                if( is_file( $file ) )
	                {
	                    unlink( $file );
	                }
	                
	        		// miniatura
	        		include_once("php/tools.php");
					$photo_path = explode("/", $file);
					$thumb_url =  implode("/", array_insert("thumbs", count($photo_path)-1, $photo_path) );					
	                if( is_file( $thumb_url ) )
	                {
	                    unlink( $thumb_url );
	                }
	            }
	            echo json_encode( true );
	        }
	    } else {
	        $model = new XUploadForm;
	        $model->file = CUploadedFile::getInstance( $model, 'file' );
	        //We check that the file was successfully uploaded
	        if( $model->file !== null ) {
	            //Grab some data
	            $model->mime_type = $model->file->getType( );
	            $model->size = $model->file->getSize( );
	            $model->name = $model->file->getName( );
	            //(optional) Generate a random name for our file
	            $filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
	            $filename .= ".".$model->file->getExtensionName( );
	            if( $model->validate( ) ) {
	                //Move our file to our temporary dir
	                $model->file->saveAs( $path.$filename );
	                chmod( $path.$filename, 0777 );
	                //here you can also generate the image versions you need 
	                //using something like PHPThumb
	 
	 
	                //Now we need to save this path to the user's session
	                if( Yii::app( )->user->hasState( 'images' ) ) {
	                    $userImages = Yii::app( )->user->getState( 'images' );
	                } else {
	                    $userImages = array();
	                }
	                 $userImages[] = array(
	                    "path" => $path.$filename,
	                    //the same file or a thumb version that you generated
	                    "thumb" => $path.$filename,
	                    "filename" => $filename,
	                    'size' => $model->size,
	                    'mime' => $model->mime_type,
	                    'name' => $model->name,
	                );
	                Yii::app( )->user->setState( 'images', $userImages );
	                
	                // creamos miniaturas
					$pic_name = $path.$filename;
					//$pic_type = strtolower(strrchr($pic_name,"."));
					if (true !== ($pic_error = @image_resize($pic_name, $path."thumbs/".$filename, 75, 75, 1)))
					{
						unlink($pic_name);
						throw new CHttpException( 500, "Could not resize file" );
					}
	 
	                //Now we need to tell our widget that the upload was succesfull
	                //We do so, using the json structure defined in
	                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
	                echo json_encode( array( array(
	                        "name" => $model->name,
	                        "type" => $model->mime_type,
	                        "size" => $model->size,
	                        "url" => $publicPath.$filename,
	                        "thumbnail_url" => $publicPath."thumbs/$filename",
	                        "delete_url" => $this->createUrl( "upload", array(
	                            "_method" => "delete",
	                            "file" => $filename
	                        ) ),
	                        "delete_type" => "POST"
	                    ) ) );
	            } else {
	                //If the upload failed for some reason we log some data and let the widget know
	                echo json_encode( array( 
	                    array( "error" => $model->getErrors( 'file' ),
	                ) ) );
	                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
	                    CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" 
	                );
	            }
	        } else {
	            throw new CHttpException( 500, "Could not upload file" );
	        }
	    }
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionDeleteUploaded($url)
	{
		// galeria model
/*	    $table = Gallery::model()->tableName();
	    $sql = "SELECT * FROM $table WHERE url='$url';";*/
	    $photo = Gallery::model()->findByPk($url);
	    if($photo===null)
			throw new CHttpException(404,'The requested page does not exist.');

	    // event model
	    $event = $this->loadModel($photo->event);
	    
	    // prevenir acceso/acciones de terceros
		$accessLevel = 0;
		if (Yii::app()->user->id == $photo->creator // si es el creador de la foto
			|| $event->creator == Yii::app()->user->id ) // o si es el organizador del evento
		{
			$accessLevel = 1;
		}
		
		if (!$accessLevel)
		{
			throw new CHttpException(404,'The requested page does not exist.');				
		}
				
        if($accessLevel == 1)
		{
			$real_path = realpath( Yii::app( )->getBasePath( )."/../" );

			// miniatura
			$photo_path = explode("/", $photo->url);
			$thumb_url =  implode("/", array_insert("thumbs", count($photo_path)-1, $photo_path) );

	        if( is_file( $real_path.$photo->url ) && is_file( $real_path.$thumb_url ) )
	        {
	        	unlink( $real_path.$photo->url );
	        	unlink( $real_path.$thumb_url );
	        }
	        
	        $photo->delete();
	    }
	}
	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model=$this->loadModel($id);
		
		// Cargamos modelo de invitados
		$inviteesModels=$this->loadInviteesModelsFromPost($id);
		
		// prevenir acceso/acciones de terceros
		$accessLevel = 0;
		if (Yii::app()->user->id != $model->creator)
		{
			foreach($inviteesModels as $inviteesModel)
			{
				if ($inviteesModel->email == Yii::app()->user->id)
				{
					$accessLevel = 2;
					break;
				}
			}
		}
		else
		{
			$accessLevel = 1;
		}
			
		if (!$accessLevel)
		{
			throw new CHttpException(404,'The requested page does not exist.');				
		}
		
		// galeria model
		$table = Gallery::model()->tableName();
		$gallery = Gallery::model()->findAllBySql("SELECT * FROM $table WHERE event=$id;");
		/*if($photos===null)
			throw new CHttpException(404,'The requested page does not exist.');*/
	
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'inviteesModels'=>$inviteesModels,
			'gallery' => $gallery,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Events;
		$inviteesModels[]=new Invitees;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array($model, $inviteesModels));
		
		if(isset($_POST['Events'], $_POST['Invitees']))
		{
			$inviteesModels = $this->loadInviteesModelsFromPost(-1);

			// add changes to event model
			$model->attributes=$_POST['Events'];
			
			// prevenir crear a nombre de otro
			$model->creator = Yii::app()->user->id;
			
			// save changes to model
			if ($model->save())
	        {
	        	// add changes to invitees models
				$validInvitees = true;
				foreach($inviteesModels as $i=>$inviteesModel)
				{
				    if(isset($_POST['Invitees'][$i]))
				    {
				    	$inviteesModel->attributes = $_POST['Invitees'][$i];
						$inviteesModel->event = $model->id;
				    }
				    
				    $validInvitees = $inviteesModel->validate() && $validInvitees;
				}
	        
	        	if($validInvitees)
				{
					// save changes to invitees models
					foreach($inviteesModels as $inviteesModel)
					{
						$inviteesModel->save(false);
					}
	
					$this->redirect(array('view','id'=>$model->id));
				}
				else
				{
					$model->delete();
				} 
			}
		}
		
		// xupload model, contenedor para subir las fotos al modelo
		Yii::import( "xupload.models.XUploadForm" );
	    $xupload = new XUploadForm;
		

		$this->render('create',array(
			'model'=>$model,
			'inviteesModels'=>$inviteesModels,
			'xupload' => $xupload,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		// Cargamos modelo de invitados
		$inviteesModels=$this->loadInviteesModelsFromPost($id);
		if (!count($inviteesModels))
			array_push($inviteesModels, new Invitees);// le puede faltar event
/* 	var_dump($inviteesModels);			 */
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array/*_merge*/($model, $inviteesModels));
		
		// si borro o agrego otros invitados
		$removed_or_added_invitees = false;
		if ( isset($_POST['Invitees']) && count($_POST['Invitees']) != count($this->loadInviteesModels($model->id)) )
		{
			$this->redirect(array('view','id'=>$model->id));
		}
		
		// prevenir acceso/acciones de terceros
		$accessLevel = 0;
		if (Yii::app()->user->id != $model->creator)
		{
			foreach($inviteesModels as $inviteesModel)
			{
				if ($inviteesModel->email == Yii::app()->user->id)
				{
					$accessLevel = 2;
					break;
				}
			}
		}
		else
		{
			$accessLevel = 1;
		}
		
		if (!$accessLevel)
		{
			throw new CHttpException(404,'The requested page does not exist.');				
		}
		
		if(isset($_POST['Events'], $_POST['Invitees']))
		{
			// prevenir phishing
			if (isset($_POST['Events']['creator'])
				&& $accessLevel == 2) // es invitado
			{
				throw new CHttpException(404,'The requested page does not exist.');
			}
			
			// prevenir cambios no autorizados de invitados	
			if ( ($accessLevel==2 && $model->confirmation_closed) ) // la confirmacion esta cerrada
			{
				$this->redirect(array('view','id'=>$model->id));
			}
			else if ($accessLevel==2) // es invitado
			{
				// eliminar cambios sobre evento
				foreach($_POST['Events'] as $i=>$attribute)
				{
					unset($_POST['Events'][$i]);
				}
				
				// eliminar cambios sobre invitados					
				foreach($_POST['Invitees'] as $i=>$invitee)
				{
					if ($removed_or_added_invitees ||
						$invitee['email']!=Yii::app()->user->id)
					{	
						unset($_POST['Invitees'][$i]);
					}
					else
					{
						// sobre atributos propios pero no modificables por invitados
						$admin_fields = array("email", "admin", "cost", "cost", "money_ok");
						foreach($invitee as $j=>$attribute)
						{
							if (in_array($j, $admin_fields))
							{
								unset($_POST['Invitees'][$i][$j]);
							}
						}
					}
				}				
			}

			// add changes to event model
			$model->attributes=$_POST['Events'];

			// add changes to invitees models
			$validInvitees = true;
			foreach($inviteesModels as $i=>$inviteesModel)
			{
			    if(isset($_POST['Invitees'][$i]))
			    {
/* echo $_POST['Invitees'][$i]["email"]; */
			    	$inviteesModel->attributes = $_POST['Invitees'][$i];
			    }
			    
			    $validInvitees = $inviteesModel->validate() && $validInvitees;
			}
			
			// save changes
            if($model->validate() && $validInvitees)
			{
				// to event model
				$model->save(false);
				
				// delete removed and duplicates
				$deleteCandidates = $this->loadInviteesModels($id);
/*
var_dump($_POST['Invitees']);			
echo "deleteCandidates count ".count($deleteCandidates);

				echo "\ninviteesModels count ".count($inviteesModels);
*/
				foreach($deleteCandidates as $deleteCandidate)
				{
/* echo "\n\n\ncandidate ".$deleteCandidate->email; */
					$delete = true;
					foreach($inviteesModels as $inviteesModel)
					{
/* echo "\ninviteesModel ".$inviteesModel->email; */
						if ($deleteCandidate->email == $inviteesModel->email)
						{
							unset($inviteesModel);
							$delete = false;
							break;
						}
					}
					
					if ($delete)
					{
/*
					echo "\n\ndeleting ";
					echo $deleteCandidate->email;
*/
						$deleteCandidate->delete();
					}
				}
				
				// to invitees models
				foreach($inviteesModels as $inviteesModel)
				{
					$inviteesModel->save(false);
				}

				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		// xupload model, contenedor para subir las fotos al modelo
		Yii::import( "xupload.models.XUploadForm" );
	    $xupload = new XUploadForm;
	    
	    // galeria model
	    $table = Gallery::model()->tableName();
	    $sql = "SELECT * FROM $table WHERE event=$id AND creator='".Yii::app()->user->id."';";
	    if ($accessLevel == 1) // es organizador
		{
			$sql = "SELECT * FROM $table WHERE event=$id;";
		}
		$gallery = Gallery::model()->findAllBySql($sql);
		/*if($g===null)
			throw new CHttpException(404,'The requested page does not exist.');*/
	    
	
		$this->render('update',array(
			'model'=>$model,
			'inviteesModels'=>$inviteesModels,
			'accessLevel'=> $accessLevel,
			'gallery' => $gallery,
			'xupload' => $xupload,
		));

		//mensaje de update de evento en el log
		$idlog = $model->id;
		$mensaje = "Se realizo un cambio en el evento";
		$this->logEvent($idlog, $mensaje);		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if ($model->creator != Yii::app()->user->id)
		{
			trigger_error("Usted no tiene permisos para borrar este evento, necesita ser el creador!");
		}
		
		$model->delete();
		$inviteesModels = $this->loadInviteesModels($id);
		foreach($inviteesModels as $inviteesModel)
		{
			$inviteesModel->delete();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	
		$creator = Yii::app()->user->id;
		$dataProvider=new CActiveDataProvider('Events', array(
/*		    'criteria'=>array(
		        'with'=>array('invitees'),
		        'condition'=>"( creator='$creator' OR email='$creator' )",
		        'together'=>true,
*/				'criteria'=>array(
					//'join' => 'INNER JOIN invitees i ON t.id=i.event',
			        'condition'=>"( creator='$creator' OR email='$creator' )",
			        'together'=>true,
			        'with'=>array('invitees'),
		    ),
	/*	    'countCriteria'=>array(
		        'condition'=>'status=1',
		        // 'order' and 'with' clauses have no meaning for the count query
		    ),*/
		    /*'pagination'=>array(
		        'pageSize'=>5,
		    ),*/
		));
		
		/*$sql = "SELECT *
				FROM events INNER JOIN invitees ON events.id=invitees.event
				WHERE ( creator='$creator' OR email='$creator' ) GROUP BY events.id";
		$rawData=Yii::app()->db->createCommand($sql)->queryAll();
				
		// or using: $rawData=User::model()->findAll();
		$dataProvider=new CArrayDataProvider($rawData, array(
		    /*'id'=>'user',
		    'sort'=>array(
		        'attributes'=>array(
		             'id', 'username', 'email',
		        ),
		    ),* /
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		*/

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadInviteesModels($id)
	{
		$table = Invitees::model()->tableName();
		$models = Invitees::model()->findAllBySql("SELECT * FROM $table WHERE event=$id;");
		if($models===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		return $models;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadInviteesModelsFromPost($id)
	{
		$models = array();
		
		$table = Invitees::model()->tableName();
		
		if (isset($_POST['Invitees']) && is_array($_POST['Invitees']))
		{
			$_POST['Invitees'] = array_values($_POST['Invitees']); // rearrange
			/*$inviteesModels = $this->loadInviteesModels($id);
			foreach($inviteesModels as $inviteesModel)
			{
				$inviteesModel->delete();
			}*/
			
			foreach ($_POST['Invitees'] as $invitee)
			{
				if ( array_key_exists('email', $invitee) )
				{
					// read invitee from database 
					$inviteesModel = Invitees::model()->findBySql("SELECT * FROM $table WHERE email='".$invitee['email']."' AND event=$id;");
														
					// if it does not exist... create a new invitee record 
					if($inviteesModel===null)
					{
						$inviteesModel = new Invitees();
						$inviteesModel->email = $invitee['email'];
						$inviteesModel->event = $id;
					}

					$models[] = $inviteesModel;
				}
			}
		}
		else
		{
			$models = $this->loadInviteesModels($id);
		}
		
/*
		if($models===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
*/
		return $this->uniqueObjectArrayBy($models, 'email');
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function removeDuplicatesByEmail($items)
	{
		$index = array();
		
		foreach($items as $item)
		{
			if (in_array($item->email, $index))
			{
				unset($item);
			}
			else
			{
				$index[]=$item->email;
			}
		}
	}
	
	public function uniqueObjectArrayBy($items, $attr)
	{
		$out = array();
		
		foreach($items as $candidate)
		{
			$insert = true;
			foreach($out as $outItem)
			{
				if ($candidate[$attr] == $outItem[$attr])
				{
					$insert = false;
					break;
				}
			}
			
			if(!count($out) || $insert)
			{
				$out[]=$candidate;
			}
		}
		
		return $out;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

		public function logEvent($chatid, $text)
	{

		$modelchat = new YiichatPost;
		$modelchat->chat_id = $chatid;			
		$modelchat->id = hash('sha1',$modelchat->chat_id.time().rand(1000,9999));      
		$modelchat->post_identity = "info@organisado.com.ar";
		$modelchat->owner = "organiSado";
		$modelchat->text = $text;
		$modelchat->created = strtotime("now");
		$modelchat->save();

	}
}
