<?php

/**
 * This is the model class for table "{{administrators}}".
 *
 * The followings are the available columns in table '{{administrators}}':
 * @property string $id
 * @property string $nickname
 * @property string $account
 *
 * The followings are the available model relations:
 * @property User $id0
 */
class Administrators extends SingleInheritance
{
	protected $_parentRelation = 'baseUser';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{administrators}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('nickname, account', 'required'),
			array('nickname', 'length', 'max'=>20,'message'=>'昵称请不要大于20字'),
			array('account', 'length', 'max'=>20,'message' => '帐号请不要大于20位'),
			array('account', 'unique' ,'message' => '帐号已存在'),
			array('id','safe')
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
			'baseUser' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nickname' => 'Nickname',
			'account' => 'Account',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Administrators the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
