<?php

/**
 * This is the model class for table "{{front_user_message_board}}".
 *
 * The followings are the available columns in table '{{front_user_message_board}}':
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $content
 * @property string $add_time
 * @property integer $reply_status
 * @property string $reply_content
 * @property string $reply_time
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 */
class FrontUserMessageBoard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{front_user_message_board}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title, content, add_time, reply_status', 'required'),
			array('reply_status', 'numerical', 'integerOnly'=>true),
			array('user_id, add_time, reply_time', 'length', 'max'=>11),
			array('title', 'length', 'max'=>20),
			array('reply_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, content, add_time, reply_status, reply_content, reply_time', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'content' => 'Content',
			'add_time' => 'Add Time',
			'reply_status' => 'Reply Status',
			'reply_content' => 'Reply Content',
			'reply_time' => 'Reply Time',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('reply_status',$this->reply_status);
		$criteria->compare('reply_content',$this->reply_content,true);
		$criteria->compare('reply_time',$this->reply_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FrontUserMessageBoard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
