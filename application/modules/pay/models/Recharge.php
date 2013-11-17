<?php

/**
 * This is the model class for table "{{recharge}}".
 *
 * The followings are the available columns in table '{{recharge}}':
 * @property string $id
 * @property string $user_id
 * @property string $sum
 * @property string $fee
 * @property string $raise_time
 * @property string $trade_no
 * @property string $subject
 * @property string $buyer_email
 * @property string $buyer_id
 * @property string $pay_time
 * @property string $finish_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 */
class Recharge extends CActiveRecord
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
			array('user_id, sum, fee, raise_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, sum, raise_time, finish_time', 'length', 'max'=>11),
			array('fee', 'length', 'max'=>5),
			array('trade_no', 'length', 'max'=>64),
			array('subject, buyer_email, buyer_id', 'length', 'max'=>255),
			array('pay_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, sum, fee, raise_time, trade_no, subject, buyer_email, buyer_id, pay_time, finish_time, status', 'safe', 'on'=>'search'),
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
			'fee' => 'Fee',
			'raise_time' => 'Raise Time',
			'trade_no' => 'Trade No',
			'subject' => 'Subject',
			'buyer_email' => 'Buyer Email',
			'buyer_id' => 'Buyer',
			'pay_time' => 'Pay Time',
			'finish_time' => 'Finish Time',
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
		$criteria->compare('fee',$this->fee,true);
		$criteria->compare('raise_time',$this->raise_time,true);
		$criteria->compare('trade_no',$this->trade_no,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('buyer_email',$this->buyer_email,true);
		$criteria->compare('buyer_id',$this->buyer_id,true);
		$criteria->compare('pay_time',$this->pay_time,true);
		$criteria->compare('finish_time',$this->finish_time,true);
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
}
