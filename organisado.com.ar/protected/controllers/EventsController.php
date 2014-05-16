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
	
	public function getItemsToUpdate($id) {
        // Create an empty list of records
        $items = array();
 
        // Iterate over each item from the submitted form
        if (isset($_POST['Invitees']) && is_array($_POST['Invitees'])) {
            foreach ($_POST['Invitees'] as $item) {
                // If item id is available, read the record from database 
                if ( array_key_exists('email', $item) && $id/* $id  *//* array_key_exists('id', $item) */ ){
                    //$items[] = Invitees::model()->findByPk($item['id']);
                    //$items[] = Invitees::model()->findByPk(array($item['email'], $id));
                    //$items[] = $this->loadInviteesModel(/* $id */"23");
/*$table = Invitees::model()->tableName();
		$items[] = Invitees::model()->findAllBySql("SELECT * FROM $table WHERE event=$id;");
		*/
					$table = Invitees::model()->tableName();
					$items[] = Invitees::model()->findBySql("SELECT * FROM $table WHERE email='".$item['email']."' AND event=$id;");
		
                }
                // Otherwise create a new record
                else {
                echo "NEW";return;
                    $items[] = new Invitees;
                }
            }
        }
        return $items;
    }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Cargamos modelo de invitados
		$inviteesModels=$this->loadInviteesModels($id);
		if (!count($inviteesModels))
			array_push($inviteesModels, new Invitees);
			
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array/*_merge*/($model, $inviteesModels));

/* var_dump($_POST['Invitees']);return ; */

$items=$this->getItemsToUpdate($id);

		if(isset($_POST['Events'], $_POST['Invitees']))
		{
			$model->attributes=$_POST['Events'];
			//$inviteesModels->attributes=$_POST['Invitees'];


//var_dump($items);return ;
/*
			echo '$items';
	    var_dump($items);
*/
$valid=true;
foreach($items as $i=>$item)
{

    if(isset($_POST['Invitees'][$i]))
    {
        $item->attributes=$_POST['Invitees'][$i];
    }
    
    $valid=$item->validate() && $valid;
}

if($valid)
{
/* $items->save(); */
   foreach($items as $i=>$item)
    {
    	$item->save();
    }
}
var_dump($items);return ;

			// validate BOTH $a and $b
            if($model->validate() && $inviteesModels->validate())
			{
				$model->save(false);
				$inviteesModels->save(false);

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'inviteesModels'=>$inviteesModels
		));
	}
	
	
	
	
	
	








	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Events;
		$inviteesModel=new Invitees;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array($model, $inviteesModel));

		if(isset($_POST['Events'], $_POST['Invitees']))
		{
			$model->attributes=$_POST['Events'];
			$inviteesModel->attributes=$_POST['Invitees'];

			// validate BOTH $a and $b
	        if ($model->save())
	        {
	            $inviteesModel->event = $model->id;
	            if($inviteesModel->save())
				{
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
			'inviteesModel'=>$inviteesModel
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Cargamos modelo de invitados
		$inviteesModel=$this->loadInviteesModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array($model, $inviteesModel));

		if(isset($_POST['Events'], $_POST['Invitees']))
		{
			$model->attributes=$_POST['Events'];
			$inviteesModel->attributes=$_POST['Invitees'];

			// validate BOTH $a and $b
            if($model->validate() && $inviteesModel->validate())
			{
				$model->save(false);
				$inviteesModel->save(false);

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'inviteesModel'=>$inviteesModel
		));
	}*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		$this->loadInviteesModel($id)->delete();

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
/*	public function loadInviteesModel($id)
	{
		$table = Invitees::model()->tableName();
		$model = Invitees::model()->findBySql("SELECT * FROM $table WHERE event=$id;");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/

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
