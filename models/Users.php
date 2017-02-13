<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $email
 */
class Users extends \yii\db\ActiveRecord
{
    public $company_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'name', 'email'], 'required'],
            ['email', 'email'],
            [['company_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Название компании',
            'name' => 'ФИО',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllUsers()
    {
        return Users::find()->all();
    }
}
