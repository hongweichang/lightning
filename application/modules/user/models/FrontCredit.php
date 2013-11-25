<?php

/**
 * This is the model class for table "{{front_credit}}".
 *
 * The followings are the available columns in table '{{front_credit}}':
 * @property string $id
 * @property string $user_id
 * @property string $verification_id
 * @property string $file_type
 * @property string $content
 * @property integer $submit_time
 * @property integer $status
 * @property string $description
 */
class FrontCredit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{front_credit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, verification_id, file_type, content, submit_time, status', 'required'),
			array('submit_time, status', 'numerical', 'integerOnly'=>true),
			array('user_id, verification_id', 'length', 'max'=>11),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, verification_id, file_type, content, submit_time, status, description', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'verification_id' => 'Verification',
			'file_type' => 'File Type',
			'content' => 'Content',
			'submit_time' => 'Submit Time',
			'status' => 'Status',
			'description' => 'Description',
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
		$criteria->compare('verification_id',$this->verification_id,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('submit_time',$this->submit_time);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Credit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
