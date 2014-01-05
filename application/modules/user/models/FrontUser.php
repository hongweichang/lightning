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
		return array(
			array('nickname, mobile, email', 'required','message'=>'请填写{attribute}'),
			array('age', 'numerical', 'integerOnly'=>true),
// 			array('balance, mobile', 'length', 'max'=>11),
// 			array('pay_password', 'length', 'max'=>60),
// 			array('nickname, role', 'length', 'max'=>15),
// 			array('realname', 'length', 'max'=>10),
// 			array('email', 'length', 'max'=>50),
// 			array('identity_id', 'length', 'max'=>18),
// 			array('bank', 'length', 'max'=>20),
			array('id,address', 'safe'),
			array('pay_password,realname,identity_id,bank,role,email_passed,email_verify_code,mobile_passed,mobile_verify_code','safe','on'=>'register'),
			array('mobile, email','unique','message'=>'{attribute}已经被注册'),
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
			'icons' => array(self::HAS_MANY, 'FrontUserIcon', 'user_id'),
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
			'pay_password' => '支付密码',
			'balance' => '余额',
			'nickname' => '昵称',
			'realname' => '姓名',
			'gender' => '性别',
			'age' => '年龄',
			'mobile' => '手机号码',
			'email' => '邮箱地址',
			'address' => '详细住址',
			'identity_id' => '身份证号码',
			'bank' => '银行卡号',
			'role' => '社会角色',
			'credit_acceptable' => '',
			'credit_grade' => '信用积分',
			'email_verify_code' => '邮箱验证码',
			'mobile_verify_code' => '手机验证码'
		);
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


	public static function getRoleName($role){
		if(isset($role)){
			switch ($role) {
				case 'wddz':
					return '网店店主';
					break;
				
				case 'gxjc':
					return '工薪阶层';
					break;

				case 'qyz':
					return '企业主';
					break;

				default:
					return '暂未设置';
					break;
			}
		}
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
