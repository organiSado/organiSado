<?php

class UsersController extends Controller
{
	/**
	 * @var string html content to show in sidebar. See 'protected/views/layouts/column2.php'.
	 */
	public $toSideBar;

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('recover', 'complete'),
				'users'=>array('?'), // ? not authenticated
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create'),
				'users'=>array('?', 'admin'), // ? not authenticated
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','update', 'userexists', 'usersearch'),
				'users'=>array('@', 'admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete'),
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
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->email));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$user = Yii::app()->user->id;
		$model=$this->loadModel($user);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->email = $user;
			if($model->save())
				$this->redirect(array('events/index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionRecover()
	{
		$model=new Users;

		$recoverStatus = 0;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];

			$model=Users::model()->findByPk($_POST['Users']['email']);
			if($model===null)
			{
				$recoverStatus = 1;
				$model=new Users;
				$model->attributes=$_POST['Users'];
				// $info = "email no encontrado...";
			}
			else
			{
				$code = md5(uniqid(rand(), true));
				$model->password = $code;
				if ($model->save())
				{
					$t = $model->email;
					$s = "Recuperar contraseña en organisado.com.ar";
					$link = "http://organisado.com.ar/index.php?r=users/recover&e=$t&c=".$code;
					$b = "Para reestablecer su contraseña ingrese al siguiente link: ".$link;

					if ( mail($t, $s, $b) )
					{
						$recoverStatus = 3; //$info = "Enviado a ".$t;
					}
					else
					{
						$recoverStatus = 2;// reintentar $info = "No se pudo enviar a ".$t;
					}
				}
			}
		}
		else if (isset($_GET['e'],$_GET['c']))
		{
			$model=Users::model()->findByPk($_GET['e']);
			if($model===null)
			{
				$recoverStatus = 4;
				$model=new Users;
				$model->email=$_GET['e'];
				// $info = "email no encontrado...";
			}
			else
			{
				if($model->password == $_GET['c'])
				{
					//login user
					$login=new LoginForm;
					$login->username = $model->email;
					$login->password = $model->password;
					if($login->validate() && $login->login())
					{
						// go to update
						$this->redirect(array('update','id'=>$model->email));
					}
				}
				else
				{
					$recoverStatus = 4;
				}
			}
		}

		$this->render('recover',array(
			'model'=>$model,
			'status'=>$recoverStatus,
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionUserSearch()
	{
		$model=new Users;

		if(isset($_POST['Users'], $_POST['Users']['email']) && strlen($_POST['Users']['email']))
		{
			$model->attributes=$_POST['Users'];

			$table = Users::model()->tableName();
			$models = Users::model()->findAllBySql("SELECT * FROM $table WHERE (email LIKE '%".$_POST['Users']['email']."%' OR  first_name LIKE '%".$_POST['Users']['email']."%' OR  last_name LIKE '%".$_POST['Users']['email']."%');");
			if($models===null)
			{
				//echo $_POST['Users']['email'];
			}
			else
			{
				$out = array();
				foreach($models as $i=>$model)
				{
					if ($i==5) break;
					$out[] = $model->first_name." ".$model->last_name." (".$model->email.")";
				}
				echo implode(", ", $out);
			}
		}
	}


	public function actionUserExists()
	{
		$model=new Users;

		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];

			$model=Users::model()->findByPk($_POST['Users']['email']);
			if($model===null)
			{
				echo $_POST['Users']['email'];
			}
			else
			{
				echo $model->first_name." ".$model->last_name;
			}
		}
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionComplete()
	{
		$model=new Users;

		$recoverStatus = 0;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];

			$model=Users::model()->findByPk($_POST['Users']['email']);
			if($model===null)
			{
				$code = md5(uniqid(rand(), true));
				$model->password = $code;
				if ($model->save())
				{
					$t = $model->email;
					$s = "Recuperar contraseña en organisado.com.ar";
					$link = "http://organisado.com.ar/index.php?r=users/recover&e=$t&c=".$code;
					$b = "Para reestablecer su contraseña ingrese al siguiente link: ".$link;

					if ( mail($t, $s, $b) )
					{
						$recoverStatus = 3; //$info = "Enviado a ".$t;
					}
					else
					{
						$recoverStatus = 2;// reintentar $info = "No se pudo enviar a ".$t;
					}
				}
			}
			else
			{
				$recoverStatus = 1;
				$model=new Users;
				$model->attributes=$_POST['Users'];
				// $info = "email no encontrado...";
			}
		}
		else if (isset($_GET['e'],$_GET['c']))
		{
			$model=Users::model()->findByPk($_GET['e']);
			if($model===null)
			{
				$recoverStatus = 4;
				$model=new Users;
				$model->email=$_GET['e'];
				// $info = "email no encontrado...";
			}
			else
			{
				if($model->password == $_GET['c'])
				{
					//login user
					$login=new LoginForm;
					$login->username = $model->email;
					$login->password = $model->password;
					if($login->validate() && $login->login())
					{
						// go to update
						$this->redirect(array('update','id'=>$model->email));
					}
				}
				else
				{
					$recoverStatus = 4;
				}
			}
		}

		$this->render('recover',array(
			'model'=>$model,
			'status'=>$recoverStatus,
		));
	}
*/
}
