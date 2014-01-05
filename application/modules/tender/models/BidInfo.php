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
 * @property integer $refund
 * @property string $month_rate
 * @property string $start
 * @property string $end
 * @property string $deadline
 * @property integer $repay_deadline
 * @property string $progress
 * @property integer $progress_sum
 * @property string $pub_time
 * @property string $begin_time
 * @property string $repay_time
 * @property string $finish_time
 * @property integer $verify_progress
 * @property string $failed_description
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 * @property BidMeta[] $bidMetas
 */
class BidInfo extends CmsActiveRecord
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
		return array(
			array('user_id, title, description, sum, refund, month_rate, start, end, deadline, repay_deadline', 'required'),
			array('refund, repay_deadline, progress_sum, verify_progress', 'numerical', 'integerOnly'=>true),
			array('user_id, sum, start, end, deadline, progress, pub_time, begin_time, repay_time, finish_time', 'length', 'max'=>11),
			array('sum','numerical','min'=>5000,'integerOnly'=>true,'message'=>'借款金额不合法'),
			array('title', 'length', 'max'=>50),
			array('month_rate', 'length', 'max'=>5),
			array('failed_description', 'safe'),
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
			'refund' => 'Refund',
			'month_rate' => 'Month Rate',
			'start' => 'Start',
			'end' => 'End',
			'deadline' => 'Deadline',
			'repay_deadline' => 'Repay Deadline',
			'progress' => 'Progress',
			'progress_sum' => 'Progress Sum',
			'pub_time' => 'Pub Time',
			'begin_time' => 'Begin Time',
			'repay_time' => 'Repay Time',
			'finish_time' => 'Finish Time',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('refund',$this->refund);
		$criteria->compare('month_rate',$this->month_rate,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('repay_deadline',$this->repay_deadline);
		$criteria->compare('progress',$this->progress,true);
		$criteria->compare('progress_sum',$this->progress_sum);
		$criteria->compare('pub_time',$this->pub_time,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('repay_time',$this->repay_time,true);
		$criteria->compare('finish_time',$this->finish_time,true);
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
	
	public function beforeSave(){
		if ( parent::beforeSave() ){
			$purifier = new CHtmlPurifier();
			$this->attributes = $purifier->purify($this->attributes);
			return true;
		}else {
			return false;
		}
	}
}
