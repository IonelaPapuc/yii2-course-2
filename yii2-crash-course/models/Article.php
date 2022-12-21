<?php

namespace app\models;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

class Article extends \yii\db\ActiveRecord

{
    public static function tableName()
    {
        return 'article';
    }
    public function behaviors()
    {
        return [
           TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ],

[
    'class' => SluggableBehavior::class,
    'attribute' => 'title'
]
        ];
    }


    public function rules()
    {
        return [
            [['title', 'body'],'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'created_by'], 'integer'],
            [['title', 'slug'], 'string', 'max'=> 1024],
            [['created_by'], 'exist', 'skipOnError'=> true, 'targetClass'=> User::className()]
            ];

    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'title'=>'Title',
            'slug'=> 'Slug',
            'body'=> 'Body',
            'created_at'=> 'Created At',
            'updated_at'=> 'Updated At',
            'created_by'=> 'Created By',
        ];
    }
public function getCreatedBy()
{
    return $this->hasOne(User::className(), ['id'=> 'created_by']);
}

public function getEncodeBody()
{
    return Html::encode($this->body);
}
}