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
			'name' => 'Name',
			'date' => 'Date',
			'time' => 'Time',
			'description' => 'Description',
			'creator' => 'Creator',
			'location_name' => 'Location Name',
			'location_address' => 'Location Address',
			'location_lat' => 'Location Lat',
			'location_long' => 'Location Long',
			'confirmation_closed' => 'Confirmation Closed',
			'cost_mode' => 'Cost Mode',
			'cost_val1' => 'Cost Val1',
			'cost_val2' => 'Cost Val2',
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
