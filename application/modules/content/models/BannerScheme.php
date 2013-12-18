<?php

/**
 * This is the model class for table "{{banner_scheme}}".
 *
 * The followings are the available columns in table '{{banner_scheme}}':
 * @property string $id
 * @property string $scheme_name
 * @property string $file_names
 * @property string $description
 * @property integer $is_using
 * @property integer $add_time
 * @property integer $banner_type
 */
class BannerScheme extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{banner_scheme}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('scheme_name, file_names, add_time, banner_type', 'required'),
			array('is_using, add_time, banner_type', 'numerical', 'integerOnly'=>true),
			array('scheme_name', 'length', 'max'=>255),
			array('description', 'safe'),
		);
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'scheme_name' => 'Scheme Name',
			'file_names' => 'File Names',
			'description' => 'Description',
			'is_using' => 'Is Using',
			'add_time' => 'Add Time',
			'banner_type' => 'Banner Type',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BannerScheme the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
