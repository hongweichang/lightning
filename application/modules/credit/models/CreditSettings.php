<?php


class CreditSettings extends CmsActiveRecord
{
	
	public function tableName()
	{
		return '{{credit_settings}}';
	}

	public function rules()
	{
	
		return array(
			array('verification_name,  verification_type', 'required'),
			array('verification_name, verification_type', 'length', 'max'=>10),
			array('id, verification_name, description, verification_type', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		
		return array(
			'CreditRole'=>array(self::HAS_MANY,'CreditRole','verification_id'),
			'FrontCredit'=>array(self::HAS_MANY,'FrontCredit','verification_id')
		);
	}

	

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'verification_name' => 'Verification Name',
			'description' => 'Description',
			'verification_type' => 'Verification Type',
		);
	}

	
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('verification_name',$this->verification_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('verification_type',$this->verification_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
