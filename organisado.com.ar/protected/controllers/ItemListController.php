<?php

class ItemListController extends Controller
{
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index', 'create','update','delete', 'assign', 'unassign'),
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
	
	public function actionIndex()
	{
		echo "TABLA";
	}
	
	public function actionCreate($e, $i, $q)
	{
echo "CREATING event=$e, item=$i, cantidad=$q";
		
		$event = $this->loadEventModel($e);
			
echo "el organizador es ".$event->creator;
		
		// Cargamos modelo de invitados
		$inviteesModels=$this->loadInviteesModels($event->id);
		if (!count($inviteesModels))
			array_push($inviteesModels, new Invitees);
		
		// prevenir acceso/acciones de terceros
		$accessLevel = 0;
		if (Yii::app()->user->id != $event->creator)
		{
			foreach($inviteesModels as $inviteesModel)
			{
				if ($inviteesModel->email == Yii::app()->user->id)
				{
					$accessLevel = 2; // acceso invitado
					break;
				}
			}
		}
		else
		{
			$accessLevel = 1; // acceso organizador
		}
echo "access=$accessLevel\n\n";
		
		if ($accessLevel != 1) // no es organizador
		{
			throw new CHttpException(404,'The requested page does not exist.');				
		}
		
		// creamos el item requerido
		$item = new ItemRequested;
		$item->item = $i;
		$item->event = $event->id;
		$item->quantity = $q;
		
		echo $item->save();
		
		
		
		
		
		
		
		
		
		
		return;
		
		
		
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

	}
	
	public function actionUpdate()
	{
		echo "UPDATE";
	}
	
	public function actionDelete()
	{
		echo "DELETE";
	}
	
	public function actionAssign()
	{
		echo "ASSIGN";
	}
	
	public function actionUnassign()
	{
		echo "UN-ASSIGN";
	}	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadEventModel($id)
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
}