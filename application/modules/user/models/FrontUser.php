<?php

/**
 * This is the model class for table "{{front_user}}".
 *
 * The followings are the available columns in table '{{front_user}}':
 * @property string $id
 * @property string $pay_password
 * @property string $balance
 * @property string $nickname
 * @property string $realname
 * @property integer $gender
 * @property integer $age
 * @property string $mobile
 * @property string $email
 * @property string $address
 * @property string $identity_id
 * @property string $bank
 * @property string $role
 * @property integer $credit_acceptable
 * @property integer $credit_grade
 *
 * The followings are the available model relations:
 * @property Bid[] $bs
 * @property BidMeta[] $bidMetas
 * @property FrontCredit[] $frontCredits
 * @property User $id0
 * @property FrontUserIcon[] $frontUserIcons
 * @property FrontUserMessageBoard[] $frontUserMessageBoards
 * @property FundFlowInternal[] $fundFlowInternals
 * @property FundFlowInternal[] $fundFlowInternals1
 * @property Message[] $messages
 * @property NotificationSettings[] $notificationSettings
 * @property Recharge[] $recharges
 * @property Withdraw[] $withdraws
 */
class FrontUser extends SingleInheritance
{
	protected $_parentRelation = "baseUser";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{front_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_password, nickname, realname, mobile, email, identity_id, bank, role, credit_grade', 'required'),
			array('gender, age, credit_acceptable, credit_grade', 'numerical', 'integerOnly'=>true),
			array('balance, mobile', 'length', 'max'=>11),
			array('pay_password', 'length', 'max'=>60),
			array('nickname, role', 'length', 'max'=>15),
			array('realname', 'length', 'max'=>10),
			array('email', 'length', 'max'=>50),
			array('identity_id', 'length', 'max'=>18),
			array('bank', 'length', 'max'=>20),
			array('id,address', 'safe'),
			array('mobile, email','unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pay_password, balance, nickname, realname, gender, age, mobile, email, address, identity_id, bank, role, credit_acceptable, credit_grade', 'safe', 'on'=>'search'),
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
			'bs' => array(self::HAS_MANY, 'Bid', 'user_id'),
			'bidMetas' => array(self::HAS_MANY, 'BidMeta', 'user_id'),
			'frontCredits' => array(self::HAS_MANY, 'FrontCredit', 'user_id'),
			'baseUser' => array(self::BELONGS_TO, 'User', 'id'),
			'frontUserIcons' => array(self::HAS_MANY, 'FrontUserIcon', 'user_id'),
			'frontUserMessageBoards' => array(self::HAS_MANY, 'FrontUserMessageBoard', 'user_id'),
			'fundFlowInternals' => array(self::HAS_MANY, 'FundFlowInternal', 'from_user'),
			'fundFlowInternals1' => array(self::HAS_MANY, 'FundFlowInternal', 'to_user'),
			'messages' => array(self::HAS_MANY, 'Message', 'user_id'),
			'notificationSettings' => array(self::HAS_MANY, 'NotificationSettings', 'user_id'),
			'recharges' => array(self::HAS_MANY, 'Recharge', 'user_id'),
			'withdraws' => array(self::HAS_MANY, 'Withdraw', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pay_password' => 'Pay Password',
			'balance' => 'Balance',
			'nickname' => 'Nickname',
			'realname' => 'Realname',
			'gender' => 'Gender',
			'age' => 'Age',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'address' => 'Address',
			'identity_id' => 'Identity',
			'bank' => 'Bank',
			'role' => 'Role',
			'credit_acceptable' => 'Credit Acceptable',
			'credit_grade' => 'Credit Grade',
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
		$criteria->compare('pay_password',$this->pay_password,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('age',$this->age);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('identity_id',$this->identity_id,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('credit_acceptable',$this->credit_acceptable);
		$criteria->compare('credit_grade',$this->credit_grade);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FrontUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
