<?php

/**
 * This is the model class for table "{{fund_flow_internal}}".
 *
 * The followings are the available columns in table '{{fund_flow_internal}}':
 * @property string $id
 * @property string $to_user
 * @property string $from_user
 * @property string $sum
 * @property string $time
 * @property string $fee
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property FrontUser $fromUser
 * @property FrontUser $toUser
 */
class FundFlowInternal extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fund_flow_internal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sum, time, fee', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('fee, to_user, from_user, sum, time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, to_user, from_user, sum, time, fee, status', 'safe', 'on'=>'search'),
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
			'fromUser' => array(self::BELONGS_TO, 'FrontUser', 'from_user'),
			'toUser' => array(self::BELONGS_TO, 'FrontUser', 'to_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'to_user' => 'To User',
			'from_user' => 'From User',
			'sum' => 'Sum',
			'time' => 'Time',
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
		$criteria->compare('to_user',$this->to_user,true);
		$criteria->compare('from_user',$this->from_user,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('time',$this->time,true);
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
	 * @return FundFlowInternal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
