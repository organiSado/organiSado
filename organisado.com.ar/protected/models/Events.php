<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property string $name
 * @property string $date
 * @property string $time
 * @property string $description
 * @property string $creator
 * @property string $location_name
 * @property string $location_address
 * @property string $location_lat
 * @property string $location_long
 * @property string $confirmation_closed
 * @property integer $cost_mode
 * @property integer $cost_val1
 * @property integer $cost_val2
 */
class Events extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date, time, creator, location_name, location_lat, location_long'/*, cost_mode'*/, 'required'),
			array('cost_mode, cost_val1, cost_val2', 'numerical', 'integerOnly'=>true),
			array('name, creator, location_name, location_address', 'length', 'max'=>255),
			array('time, location_lat, location_long', 'length', 'max'=>45),
			array('confirmation_closed', 'length', 'max'=>1),
			array('description', 'safe'),
			array('date', 'date', 'format'=>'yyyy-MM-dd'),
			array('time', 'type', 'type'=>'time', 'timeFormat'=>'hh:mm'), //se debe introducir en formato 24 hs, hay que aclarrlo.
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, date, time, description, creator, location_name, location_address, location_lat, location_long, confirmation_closed, cost_mode, cost_val1, cost_val2', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array cost modes.
	 */
	public function costModes()
	{
		return array(
				array('label'=>'El organizador invita',
					  'description'=>'El evento no tiene costo alguno para los invitados'),

				array('label'=>'Se establece un costo fijo',
					  'description'=>'El costo del evento para todos los invitados sera igual a un valor fijo, 
					  				  independientemente del costo total del evento.'),

				array('label'=>'Se establece un costo fijo segun asistente',
					  'description'=>'Se distinguen dos valores fijos de costo para cada uno de los tipos de 
					  				  asistentes respectivamente, adultos y menores, tambien independientemente
					  				  del costo total del evento.'),

				array('label'=>'Se divide lo gastado en partes iguales',
					  'description'=>'Se divide el costo total del evento entre todos los asistentes sin distincion alguna.'),

				array('label'=>'Se divide lo gastado segun asistentes',
					  'description'=>  'Se establece un valor diferente de costo para cada uno de los tipos de
										asistentes, adultos y menores, estos valores se calculan a partir del 
										costo total del evento, y un porcentaje de este correspondiente a los asistentes menores, segun se lo
										indique debajo.'), 

				array('label'=>'Se divide un valor fijo en partes iguales',
						'description'=>'Se divide un valor fijo que representa 
										el costo total, entre todos los asistentes sin distincion alguna.'),

				array('label'=>'Se divide un valor fijo segun asistente',
						'description'=>'Se establece un valor diferente de costo 
									  	para cada uno de los tipos de asistentes, adultos y menores, estos valores se 
									 	 calculan a partir de un valor fijo que represental costo total del evento, y el 
									 	 costo correspondiente a los asistentes menores, se calculará como un porcentaje 
									 	 del costo de un asistente adulto, segun se lo indique debajo.') 
			);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nombre',
			'date' => 'Fecha',
			'time' => 'Hora',
			'description' => 'Descripción',
			'creator' => 'Creador',
			'location_name' => 'Ubicación del Evento',
			'location_address' => 'Dirección',
			'location_lat' => 'Latitud de Ubicación',
			'location_long' => 'Longitud de Ubicacion',
			'confirmation_closed' => 'Confirmación Cerrada',
			'cost_mode' => 'Modo de Costo',
			'cost_val1' => 'Primer Valor de Costo',
			'cost_val2' => 'Segundo Valor de Costo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('location_name',$this->location_name,true);
		$criteria->compare('location_address',$this->location_address,true);
		$criteria->compare('location_lat',$this->location_lat,true);
		$criteria->compare('location_long',$this->location_long,true);
		$criteria->compare('confirmation_closed',$this->confirmation_closed,true);
		$criteria->compare('cost_mode',$this->cost_mode);
		$criteria->compare('cost_val1',$this->cost_val1);
		$criteria->compare('cost_val2',$this->cost_val2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
