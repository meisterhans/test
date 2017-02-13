<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $resource
 * @property integer $amount
 * @property integer $created_at
 */
class Data extends \yii\db\ActiveRecord
{
    public $total;
    public $company_id;
    public $company_name;
    public $company_quota;
    public $user_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /*public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'created_at'], 'required'],
            [['user_id', 'amount', 'created_at'], 'integer'],
            [['resource'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Пользователь',
            'resource' => 'Ресурс',
            'amount' => 'Объем',
            'total' => 'Объем',
            'created_at' => 'Дата',
            'company_name' => 'Название компании',
            'company_quota' => 'Квота',
            'user_name' => 'Пользователь'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->innerJoinWith('company');
    }

    public function generateData()
    {
        $users = Users::find()->all();

        foreach($users as $user) {
            $date = \DateTime::createFromFormat('m/d/Y', '08/01/2016');
            $date->setTime(0,0,0);
            while($date->getTimeStamp() < Yii::$app->formatter->asTimestamp("2017-02-01 00:00:01")) {
                $begin_time = $date->getTimeStamp();
                $current_date = $date->add(new \DateInterval('P1M'));

                foreach(Users::getAllUsers() as $user) {
                    for ($i = 0; $i < rand(50, 500); $i++) {
                        $data = new Data();
                        $data->user_id = $user->id;
                        $data->resource = "http://google.com/";
                        $data->amount = rand(100, 1024);
                        $data->created_at = rand($begin_time, $current_date->getTimeStamp());
                        $data->save();
                    }
                }
            }
        }
    }
}
