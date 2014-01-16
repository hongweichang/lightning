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
			array('user_id, verification_id, file_type, content, submit_time, status,role', 'required'),
			array('submit_time, status', 'numerical', 'integerOnly'=>true),
			array('user_id, verification_id', 'length', 'max'=>11),
			array('description', 'safe'),
			
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
			'user'=>array(self::BELONGS_TO, 'FrontUser','user_id'),
			'creditSetting'=>array(self::BELONGS_TO,'CreditSettings','verification_id'),
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
