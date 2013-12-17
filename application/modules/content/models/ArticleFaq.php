<?php

/**
 * This is the model class for table "{{article_faq}}".
 *
 * The followings are the available columns in table '{{article_faq}}':
 * @property string $id
 * @property string $fid
 * @property string $title
 * @property string $content
 * @property string $user_id
 * @property string $add_ip
 * @property integer $faq_type
 * @property string $add_time
 */
class ArticleFaq extends CmsActiveRecord
{
	public function getUser(){
		$type = intval($this->faq_type);
		if ( $type === 0 || $type === 2 ){
			return $this->getRelated('publisher');
		}elseif ( $type === 1 || $type === 3 ){
			return $this->getRelated('replier');
		}
		return null;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article_faq}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('content, user_id, add_ip, faq_type, add_time', 'required'),
			array('fid','safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
				'publisher' => array(self::BELONGS_TO,'FrontUser','user_id'),
				'replier' => array(self::BELONGS_TO,'Administrators','user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fid' => 'Fid',
			'title' => 'Title',
			'content' => 'Content',
			'user_id' => 'User',
			'add_ip' => 'Add Ip',
			'faq_type' => 'Faq Type',
			'add_time' => 'Add Time',
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
		$criteria->compare('fid',$this->fid,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('add_ip',$this->add_ip,true);
		$criteria->compare('faq_type',$this->faq_type);
		$criteria->compare('add_time',$this->add_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleFaq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
