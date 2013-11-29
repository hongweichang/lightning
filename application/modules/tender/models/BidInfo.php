<?php
class BidInfo extends CActiveRecord
{
	
	public function tableName()
	{
		return '{{bid}}';
	}

	public function rules()
	{
	
		return array(
			array('title,description,sum,month_rate,start,end,user_id,deadline', 'required'),
			array('sum, month_rate', 'numerical'),
		);
	}


	public function relations()
	{
		
		return array(
			'user'=>array(self::BELONGS_TO, 'FrontUser', 'user_id'),
			'bidMeta'=>array(self::HAS_ONE, 'BidMeta', 'bid_id'),
		);
	}

	

	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'description' => 'Description',
			'sum' => 'Sum Money',
			'month_rate' => 'Month Rate',
			'start' => 'Start Date',
			'end' => 'End Date',
		);
	}

	
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('month_rate',$this->month_rate,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
