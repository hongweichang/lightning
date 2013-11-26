<?php

/**
 * This is the model class for table "{{front_user_icon}}".
 *
 * The followings are the available columns in table '{{front_user_icon}}':
 * @property string $id
 * @property string $user_id
 * @property string $file_name
 * @property string $size
 * @property integer $file_size
 * @property integer $in_using
 *
 * The followings are the available model relations:
 * @property FrontUser $user
 */
class FrontUserIcon extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{front_user_icon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, file_name, file_size', 'required'),
			array('file_size, in_using', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('file_name', 'length', 'max'=>255),
			array('size', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, file_name, size, file_size, in_using', 'safe', 'on'=>'search'),
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
			'file_name' => 'File Name',
			'size' => 'Size',
			'file_size' => 'File Size',
			'in_using' => 'In Using',
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
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('in_using',$this->in_using);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FrontUserIcon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
