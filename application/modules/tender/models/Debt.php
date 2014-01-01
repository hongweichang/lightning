<?php

/**
 * This is the model class for table "{{debt}}".
 *
 * The followings are the available columns in table '{{debt}}':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $incomeWay
 * @property string $start
 * @property string $end
 * @property string $condition
 * @property integer $deadline
 * @property string $charge
 * @property string $protection
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property DebtUser[] $debtUsers
 */
class Debt extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{debt}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, Debt_master,description, incomeWay, start, end, condition, deadline, charge, protection, remark', 'required'),
			array('deadline', 'numerical', 'integerOnly'=>true),
			array('title, protection', 'length', 'max'=>30),
			array('description', 'length', 'max'=>200),
			array('incomeWay, condition, charge, remark', 'length', 'max'=>50),
			array('start, end,Debt_master', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, incomeWay, start, end, condition, deadline, charge, protection, remark', 'safe', 'on'=>'search'),
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
			'debtUsers' => array(self::HAS_MANY, 'DebtUser', 'did'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'incomeWay' => 'Income Way',
			'start' => 'Start',
			'end' => 'End',
			'condition' => 'Condition',
			'deadline' => 'Deadline',
			'charge' => 'Charge',
			'protection' => 'Protection',
			'remark' => 'Remark',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('incomeWay',$this->incomeWay,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('condition',$this->condition,true);
		$criteria->compare('deadline',$this->deadline);
		$criteria->compare('charge',$this->charge,true);
		$criteria->compare('protection',$this->protection,true);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Debt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
