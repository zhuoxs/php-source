<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%district}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $citycode
 * @property string $adcode
 * @property string $name
 * @property string $lng
 * @property string $lat
 * @property string $level
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%district}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['citycode', 'adcode', 'name', 'lng', 'lat', 'level'], 'required'],
            [['citycode', 'adcode', 'name', 'lng', 'lat', 'level'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'citycode' => 'Citycode',
            'adcode' => 'Adcode',
            'name' => 'Name',
            'lng' => '经度',
            'lat' => '纬度',
            'level' => 'Level',
        ];
    }

    public function getCity()
    {
        return $this->hasMany(District::className(), ['parent_id'=>'id'])->where(['level'=>'city']);
    }
}
