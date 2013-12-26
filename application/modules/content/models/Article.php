<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $admin_name
 * @property string $add_time
 * @property string $category
 * @property integer $art_type
 * @property integer $click
 *
 * The followings are the available model relations:
 * @property ArticleCategory $category0
 */
class Article extends CmsActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, content, admin_name, add_time, category', 'required'),
			array('click', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('admin_name', 'length', 'max'=>30),
			array('add_time, category', 'length', 'max'=>11),
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
			'category' => array(self::BELONGS_TO, 'ArticleCategory', 'category'),
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
			'content' => 'Content',
			'admin_name' => 'Admin Name',
			'add_time' => 'Add Time',
			'category' => 'Category',
			'art_type' => 'Art Type',
			'click' => 'Click',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
