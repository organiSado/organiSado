<?php

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
				'actions'=>array('index','view','create','update','delete'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$creator = Yii::app()->user->id;
		if ($this->loadModel($id)->creator != $creator) 
			throw new CHttpException(404,'The requested page does not exist.');

	
		$this->render('view',array(
			'model'=>$this->loadModel($id),
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

		$this->render('create',array(
			'model'=>$model,
			'inviteesModels'=>$inviteesModels
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
		
		if(isset($_POST['Events'], $_POST['Invitees']))
		{
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

		$this->render('update',array(
			'model'=>$model,
			'inviteesModels'=>$inviteesModels
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
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
		    'criteria'=>array(
		        'condition'=>"creator='$creator'",
		       /* 'order'=>'create_time DESC',
		        'with'=>array('author'),*/
		    ),
	/*	    'countCriteria'=>array(
		        'condition'=>'status=1',
		        // 'order' and 'with' clauses have no meaning for the count query
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),*/
		));
		
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
		return $models;
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
}
