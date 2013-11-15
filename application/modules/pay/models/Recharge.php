<?php

/**
 * This is the model class for table "{{recharge}}".
 *
 * The followings are the available columns in table '{{recharge}}':
 * @property string $id
 * @property string $user_id
 * @property string $sum
 * @property string $time
 * @property string $serial_number
 * @property string $fee
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 */
class Recharge extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{recharge}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, sum, time, serial_number, fee', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('id, user_id, sum, time', 'length', 'max'=>11),
			array('serial_number', 'length', 'max'=>64),
			array('fee', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, sum, time, serial_number, fee, status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'FrontUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'sum' => 'Sum',
			'time' => 'Time',
			'serial_number' => 'Serial Number',
			'fee' => 'Fee',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('fee',$this->fee,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recharge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function onBeginPay($user,$charge,$fee){
		$this->attributes = array(
			'id' => '',
			'user_id' => $user,
			'sum' => $charge * 100,
			'fee' => round($fee * 100),
			'time' => time(),
			'serial_number' => '',
			'status' => 0 // 正在处理 - 等待支付
		);
		
		if($this->save()){
			return $this->getPrimaryKey();
		}else{
			return false;
		}
	}
	
	public function onAfterPay($id,$serial){
		$record = self::model()->findByPk($id);
		
		$record = array(
			'serial_number' => $serial,
		);
		
		return $record->save();
	}
}
