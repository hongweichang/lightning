<?php

/**
 * This is the model class for table "{{credit_grade_settings}}".
 *
 * The followings are the available columns in table '{{credit_grade_settings}}':
 * @property string $id
 * @property integer $level
 * @property integer $start
 * @property integer $end
 * @property string $on_recharge
 * @property string $on_withdraw
 * @property string $on_pay_back
 * @property string $on_over6
 * @property string $on_below6
 * @property string $on_loan
 * @property integer $loanable
 * @property string $label
 */
class CreditGradeSettings extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{credit_grade_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start, on_recharge, on_withdraw, on_pay_back, on_over6, on_below6, on_loan, loanable, label', 'required'),
			array('level, start, end, loanable', 'numerical', 'integerOnly'=>true),
			array('on_recharge, on_withdraw, on_pay_back, on_over6, on_below6, on_loan', 'length', 'max'=>5),
			array('label', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, level, start, end, on_recharge, on_withdraw, on_pay_back, on_over6, on_below6, on_loan, loanable, label', 'safe', 'on'=>'search'),
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
			'level' => 'Level',
			'start' => 'Start',
			'end' => 'End',
			'on_recharge' => 'On Recharge',
			'on_withdraw' => 'On Withdraw',
			'on_pay_back' => 'On Pay Back',
			'on_over6' => 'On Over6',
			'on_below6' => 'On Below6',
			'on_loan' => 'On Loan',
			'loanable' => 'Loanable',
			'label' => 'Label',
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
		$criteria->compare('level',$this->level);
		$criteria->compare('start',$this->start);
		$criteria->compare('end',$this->end);
		$criteria->compare('on_recharge',$this->on_recharge,true);
		$criteria->compare('on_withdraw',$this->on_withdraw,true);
		$criteria->compare('on_pay_back',$this->on_pay_back,true);
		$criteria->compare('on_over6',$this->on_over6,true);
		$criteria->compare('on_below6',$this->on_below6,true);
		$criteria->compare('on_loan',$this->on_loan,true);
		$criteria->compare('loanable',$this->loanable);
		$criteria->compare('label',$this->label,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreditGradeSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
