<?php


class BidMeta extends CActiveRecord
{
	
	public function tableName()
	{
		return '{{bid_meta}}';
	}

	public function rules()
	{
	
		return array(
			array('user_id,bid_id,sum,buy_time', 'required'),
			array('user_id,bid_id,sum', 'numerical','integerOnly'=>true),
		);
	}


	public function relations()
	{
		
		return array(
			'user'=>array(self::BELONGS_TO, 'FrontUser', 'user_id'),
			'bid'=>array(self::HAS_ONE, 'BidInfo', 'bid_id'),
		);
	}

	

	public function attributeLabels()
	{
		return array(
			'user_id' => 'User Id',
			'bid_id' => 'Bid Id',
			'sum' => 'Sum Money',
		);
	}

	
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('bid_id',$this->description,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('buy_time',$this->buy_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
