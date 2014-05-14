<?php

/**
 * This is the model class for table "invitees".
 *
 * The followings are the available columns in table 'invitees':
 * @property string $email
 * @property integer $event
 * @property integer $admin
 * @property integer $confirmed
 * @property integer $adults
 * @property integer $kids
 * @property integer $cost
 * @property integer $spent
 * @property integer $money_ok
 */
class Invitees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invitees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, event', 'required'),
			array('event, adults, kids, cost, spent', 'numerical', 'integerOnly'=>true),
			array('admin, confirmed, money_ok', 'length', 'max'=>1),
			array('email', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('email, event, admin, confirmed, adults, kids, cost, spent, money_ok', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'event' => 'Event',
			'admin' => 'Organizador',
			'confirmed' => 'Asistirá',
			'adults' => 'Adultos',
			'kids' => 'Niños',
			'cost' => 'Costo',
			'spent' => 'Gastó',
			'money_ok' => 'Saldado',
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

		$criteria->compare('email',$this->email,true);
		$criteria->compare('event',$this->event);
		$criteria->compare('admin',$this->admin);
		$criteria->compare('confirmed',$this->confirmed);
		$criteria->compare('adults',$this->adults);
		$criteria->compare('kids',$this->kids);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('spent',$this->spent);
		$criteria->compare('money_ok',$this->money_ok);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invitees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
