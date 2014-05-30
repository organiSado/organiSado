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
				'actions'=>array('view', 'create','update','delete', 'assign', 'unassign'),
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
	
	public function actionView()
	{
		// modelos vacios por defecto
		$items_requested []= new ItemRequested;
		$items_assigned []= new ItemAssigned;
		
		// labels unidos
		$labels = array_merge($items_assigned[0]->attributeLabels(), $items_requested[0]->attributeLabels());
		
		// evento
		$e = -1; // por defecto ninguno
		if ( isset($_POST['e']) )
		{
			$e = $_POST['e'];
			
			$event = Events::model()->findByPk($e);

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
			
			if (!$accessLevel)
			{
				throw new CHttpException(404,'The requested page does not exist.');				
			}
			
			// cargamos items requeridos
			$tb = ItemRequested::model()->tableName();
			$items_requested = ItemRequested::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e;");
			/*if($items_requested===null)
				throw new CHttpException(404,'The requested page does not exist.');*/
		}
		
		// filas a imprimir
		$rows = "";
		foreach ($items_requested as $item)
		{
			$tb = ItemAssigned::model()->tableName();
			$items_assigned = ItemAssigned::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e AND item='".$item->item."';");
			/*if($items_assigned===null)
				throw new CHttpException(404,'The requested page does not exist.');*/
			$assigned_emails = array();
			$total_assigned_quantity = 0;
			if (isset($items_assigned) && is_array($items_assigned))
			{
				foreach($items_assigned as $assigned_item)
				{
					$email_html = "<div class='item-assignee'>";
					$email_html .= $assigned_item->email." (".$assigned_item->quantity.")";
					$email_html .= "<a class='' href='#unassign' title='Eliminar Asignado'>
			            				<i class='icon-remove'></i>
									</a>";
					$email_html .= "</div>";
					
					$assigned_emails []= $email_html;
					$total_assigned_quantity += $assigned_item->quantity;
				}
			}
			
			$pending_quantity = $item->quantity-$total_assigned_quantity;
				
			$rows .= "<tr>
						<td>".$item->item."</td>
						<td>".(count($assigned_emails)? implode("", $assigned_emails):"No se han asignado invitados a este item todavía.")."</td>
						<td>".$total_assigned_quantity."/".$item->quantity."</td>
						<td>".($pending_quantity < 0?"Se pasaron!":($pending_quantity==0?"Ya estamos!":$pending_quantity))."</td>
						<td class='buttons'>
			            	<a class='btn btn-default' href='#assignToMe' title='Yo llevo!'>
			            		<i class='icon-check'></i>
			            	</a>
			            </td>
			            <td class='buttons'>
			            	<a class='btn btn-default' href='#assignItem' title='Asignar'>
			            		<i class='icon-hand-left'></i>
			            	</a>
			            </td>
			            <td class='buttons'>
			            	<a class='btn btn-danger remove-invitee' href='#removeItem' title='Eliminar'>
			            		<i class='icon-remove'></i>
			            	</a>
			            </td>
					  </tr>";
		}
		
		echo "<table id='table-items' class='table table-striped'>
		        <thead>
		          <tr>
		            <th>".$labels['item']."</th>
		            <th>".$labels['email']."</th>
		            <th>".$labels['quantity']."</th>
		            <th>Faltan</th>
		            <th colspan='3'>Acciones</th>
		          </tr>
				</thead>
				<tbody>
					$rows
				</tbody>
			</table>";
	}
	
	public function actionCreate($e, $i, $q)
	{
		//$e = -1; // por defecto ninguno
		//if ( isset($_POST['e']) )  $e = $_POST['e'];

//echo "CREATING event=$e, item=$i, cantidad=$q";

		// validación básica
		if (!is_numeric($e))
		{
			echo "ERROR: evento no válido!";
			return;
		}
		
		if (!is_numeric($q) || $q <= 0 )
		{
			echo "ERROR: cantidad no válida!";
			return;
		}
		
		
		$event = $this->loadEventModel($e);
					
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
		
		if ($accessLevel != 1) // no es organizador
		{
			echo "ERROR: no tienes permiso para agregar items requeridos!";
			return;			
		}
		
		// creamos el item requerido
		$item = new ItemRequested;
		$item->item = $i;
		$item->event = $event->id;
		$item->quantity = $q;
		
		if (!$item->validate())
		{
			// get errors, de a uno
			$errors = $item->getErrors();
			$errStr = "";
			foreach ($errors as $attr_errors)
			{
				$errStr .= implode(", ", $attr_errors); // o todos?
				if (count($errStr))
				{
					echo "ERROR: $errStr";
					return;
				}
			}
		}

		$item->save(false);
		
		
		
		
		
		
		
		
		
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