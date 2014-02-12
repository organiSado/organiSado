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
 * @property string $location
 * @property string $gmaps_lat
 * @property string $gmaps_long
 * @property integer $confirmation_closed
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
			array('name, date, time, creator, location', 'required'),
			array('confirmation_closed', 'numerical', 'integerOnly'=>true),
			array('name, creator, location', 'length', 'max'=>255),
			array('time, gmaps_lat, gmaps_long', 'length', 'max'=>45),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, date, time, description, creator, location, gmaps_lat, gmaps_long, confirmation_closed', 'safe', 'on'=>'search'),
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
			'location' => 'Location',
			'gmaps_lat' => 'Gmaps Lat',
			'gmaps_long' => 'Gmaps Long',
			'confirmation_closed' => 'Confirmation Closed',
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
		$criteria->compare('location',$this->location,true);
		$criteria->compare('gmaps_lat',$this->gmaps_lat,true);
		$criteria->compare('gmaps_long',$this->gmaps_long,true);
		$criteria->compare('confirmation_closed',$this->confirmation_closed);

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
