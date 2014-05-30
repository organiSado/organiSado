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
				'actions'=>array('view', 'create','update','delete', 'assignToMe', 'assign', 'unassign', 'emailItemList'),
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
		// evento
		$e = -1; // por defecto ninguno
		if ( isset($_POST['e'], $_POST['m']) )
		{
			$e = $_POST['e'];
			$m = $_POST['m'];
			
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
			
			/*if($items_requested===null)
				throw new CHttpException(404,'The requested page does not exist.');*/
		}
		
		// cargamos items requeridos
		$tb = ItemRequested::model()->tableName();
		$items_requested = ItemRequested::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e;"); // si falla por evento indefinido el resultado es vacio nada mas

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
					if($m!='read-only')
					{
						$email_html .= "<a class='' href='#unassign' title='Eliminar Asignado'>
				            				<i class='icon-remove'></i>
										</a>";
					}
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
						<td>".($pending_quantity < 0?"Se pasaron!":($pending_quantity==0?"Ya estamos!":$pending_quantity))."</td>";
			
			if($m!='read-only')
			{
				$rows .= "<td class='buttons'>
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
			            </td>";
			}
						
			$rows .= "</tr>";
		}
		
		// labels unidos
		$item_requested = new ItemRequested;
		$item_assigned = new ItemAssigned;
		$labels = array_merge($item_assigned->attributeLabels(), $item_requested->attributeLabels());
		echo "<table id='table-items' class='table table-striped'>
		        <thead>
		          <tr>
		            <th>".$labels['item']."</th>
		            <th>".$labels['email']."</th>
		            <th>".$labels['quantity']."</th>
		            <th>Faltan</th>";
		
		if($m!='read-only')
		{
			echo "<th colspan='3'>Acciones</th>";
		}
			
		echo     "</tr>
				</thead>
				<tbody>
					$rows
				</tbody>
			</table>";
	}
	
	public function actionCreate(/*$e, $i, $q*/)
	{
		$e = -1; // por defecto ninguno
		if ( isset($_POST['e']) )  $e = $_POST['e'];

		$i = ""; // por defecto ninguno
		if ( isset($_POST['i']) )  $i = $_POST['i'];
		
		$q = -1; // por defecto ninguno
		if ( isset($_POST['q']) )  $q = $_POST['q'];

//echo "CREATING event=$e, item=$i, cantidad=$q";return;

		// validación básica
		if (!is_numeric($e))
		{
			echo "ERROR: evento no válido!";
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
			echo "ERROR: no tienes permiso para agregar items a la lista!";
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
		
		// validacion basica
		if (!is_numeric($q) || $q <= 0 )
		{
			echo "ERROR: cantidad no válida!";
			return;
		}

		$item->save(false);
	}
	
	public function actionUpdate()
	{
		echo "UPDATE";
	}
	
	public function actionDelete()
	{		
		if ( isset($_POST['e'],$_POST['i']) )
		{
			$e = $_POST['e'];
			$i = $_POST['i'];
			
			// validación básica
			/*if (!is_numeric($e))
			{
				echo "ERROR: evento no válido!";
				return;
			}
			
			if (!count($i))
			{
				echo "ERROR: cantidad no válida!";
				return;
			}*/
			
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
				echo "ERROR: no tienes permiso para eliminar items de la lista!";
				return;			
			}

			// cargamos items requeridos
			$tb = ItemRequested::model()->tableName();
			$item_requested = ItemRequested::model()->findBySql("SELECT * FROM $tb WHERE event=$e AND item='$i';");
			if ($item_requested!==null)
			{
				$tb = ItemAssigned::model()->tableName();
				$items_assigned = ItemAssigned::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e AND item='$i';");
				if (isset($items_assigned) && is_array($items_assigned))
				{
					foreach ($items_assigned as $item_assigned)
					{
						$item_assigned->delete();
					}
				}
		
				$item_requested->delete();
			}
		}
	}
	
	public function actionAssignToMe()
	{
		$_POST['u'] = Yii::app()->user->id;
		$this->actionAssign();
	}
	
	public function actionAssign()
	{		
		//e:event_id,i:item,q:quantity,u:user },
		if ( isset($_POST['e'], $_POST['i'], $_POST['q'], $_POST['u']) )
		{
			$e = $_POST['e'];
			$i = $_POST['i'];
			$q = $_POST['q'];
			$u = $_POST['u'];
			
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
			
			if ($accessLevel != 1 && ($accessLevel == 2 && Yii::app()->user->id != $u)) // no es organizador y no se esta asignando a si mismo
			{
				echo "ERROR: no tienes permiso para asignar items a este usuario!";
				return;			
			}
			
			// cargamos item requerido
			$tb = ItemRequested::model()->tableName();
			$item_requested = ItemRequested::model()->findBySql("SELECT * FROM $tb WHERE event=$e AND item='$i';");
			if ($item_requested!==null)
			{
				$tb = ItemAssigned::model()->tableName();
				$item_assigned = ItemAssigned::model()->findBySql("SELECT * FROM $tb WHERE event=$e AND item='$i' AND email='$u';");
				if ($item_assigned!==null)
				{
					echo "ERROR: ya se asignó este item a este usuario!";
					return;
				}
				else
				{
					// creamos el item asignado
					$item = new ItemAssigned;
					$item->item = $i;
					$item->event = $e;
					$item->email = $u;
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
					
					// prevenir asignaciones de no invitados
					$isInvitee = false;
					foreach($inviteesModels as $inviteesModel)
					{
						if ($inviteesModel->email == $u)
						{
							$isInvitee = true; // es invitado
							break;
						}
					}
					
					if (!$isInvitee && $u != $event->creator) // no es organizador y no se esta asignando a si mismo
					{
						echo "ERROR: el usuario que se quiere asignar no es un invitado del evento. Asegurese de guardar los cambios al agregar invitados nuevos, antes de asignarle items!";
						return;			
					}
			
					$item->save(false);
				}
			}
		}
	}
	
	public function actionUnassign()
	{		
		if ( isset($_POST['e'],$_POST['i'],$_POST['u']) )
		{
			$e = $_POST['e'];
			$i = $_POST['i'];
			$u = $_POST['u'];
			
			// validación básica
			/*if (!is_numeric($e))
			{
				echo "ERROR: evento no válido!";
				return;
			}
			
			if (!count($i))
			{
				echo "ERROR: cantidad no válida!";
				return;
			}*/
			
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
			
			if ($accessLevel != 1 && ($accessLevel == 2 && Yii::app()->user->id != $u)) // no es organizador
			{
				echo "ERROR: no tienes permiso para desasignar items de este usuario!";
				return;			
			}

			// cargamos items requeridos
			$tb = ItemRequested::model()->tableName();
			$item_requested = ItemRequested::model()->findBySql("SELECT * FROM $tb WHERE event=$e AND item='$i';");
			if ($item_requested!==null)
			{
				$tb = ItemAssigned::model()->tableName();
				$item_assigned = ItemAssigned::model()->findBySql("SELECT * FROM $tb WHERE event=$e AND item='$i' AND email='$u';");
				if ($item_assigned!==null)
				{
					$item_assigned->delete();
				}
			}
		}
	}
	
	public function actionEmailItemList()
	{
		$e = -1; // por defecto ninguno
		if ( isset($_POST['e']) ) 
		{
			$e = $_POST['e'];
			
			// validación básica
			if (!is_numeric($e))
			{
				echo "ERROR: evento no válido!";
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
				echo "ERROR: no tienes permiso para enviar la lista de items por email!";
				return;
			}
			
			// obtenemos todos los usuarios con asignaciones en este evento
			$tb = ItemAssigned::model()->tableName();
			$items_assigned_gb_emails = ItemAssigned::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e GROUP BY email;");
			$emailed = array();
			$not_emailed = array();
			if (isset($items_assigned_gb_emails) && is_array($items_assigned_gb_emails))
			{
				foreach ($items_assigned_gb_emails as $item_assigned_gb_email)
				{
					$link = "http://organisado.com.ar/index.php?r=events/view&id=".$e;
					$t = $item_assigned_gb_email->email;
					$s = "Lista de items para llevar a $event->name";
				
					// obtenemos todos los items de este evento para este usuario
					$tb = ItemAssigned::model()->tableName();
					$items_assigned = ItemAssigned::model()->findAllBySql("SELECT * FROM $tb WHERE event=$e AND email='$item_assigned_gb_email->email';");
					if (isset($items_assigned) && is_array($items_assigned))
					{
						$b = "Te asignaron los siguientes items en $event->name (".$link.").\n\n";
						$b .= "Tenés que llevar los siguientes items:\n";
						foreach($items_assigned as $assigned_item)
						{
							$b .= "\t- ".$assigned_item->item." (".$assigned_item->quantity.")";
						}
					}
					
					// si obtuve bien la info enviar
					if (count($b))
					{
						if ( mail($t, $s, $b) )
						{
							$emailed []= $t;
						}
						else
						{
							$not_emailed []= $t;
						}
					}
				}
			}
			
			if ( count($not_emailed) )
			{
				echo "ERROR: no se pudo enviar la lista a ".implode(", ", $not_emailed);
			}
			else if ( count($emailed) )
			{
				echo "Lista de items enviada con éxito a todos los usuarios!";
			}
		}		
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