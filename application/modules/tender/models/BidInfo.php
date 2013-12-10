<?php

/**
 * This is the model class for table "{{bid}}".
 *
 * The followings are the available columns in table '{{bid}}':
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $description
 * @property string $sum
 * @property string $month_rate
 * @property string $start
 * @property string $end
 * @property string $deadline
 * @property string $progress
 * @property integer $verify_progress
 * @property string $failed_description
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 * @property BidMeta[] $bidMetas
 */
class BidInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bid}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title, description, sum', 'required'),
			array('month_rate,start,end,pub_time,deadline,progress,sum', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			//month_rate 5-20
			//deadline:1-36
			array('month_rate','numerical','max'=>20,'min'=>5),
			array('deadline','numerical','max'=>36,'min'=>1),
			array('failed_description,refund', 'safe'),
			// The following rule is used by search().
			array('id, user_id, title, description, sum, month_rate, start, end, deadline, progress, verify_progress, failed_description', 'safe', 'on'=>'search'),
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
			'bidMeta' => array(self::HAS_MANY, 'BidMeta', 'bid_id'),
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
			'title' => 'Title',
			'description' => 'Description',
			'sum' => 'Sum',
			'month_rate' => 'Month Rate',
			'start' => 'Start',
			'end' => 'End',
			'deadline' => 'Deadline',
			'progress' => 'Progress',
			'verify_progress' => 'Verify Progress',
			'failed_description' => 'Failed Description',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('month_rate',$this->month_rate,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('progress',$this->progress,true);
		$criteria->compare('verify_progress',$this->verify_progress);
		$criteria->compare('failed_description',$this->failed_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BidInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
