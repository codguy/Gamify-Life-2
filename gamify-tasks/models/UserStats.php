<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_stats}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $physical_health
 * @property int|null $creativity
 * @property int|null $knowledge
 * @property int|null $happiness
 * @property int|null $money
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class UserStats extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_stats}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['money'], 'default', 'value' => 0],
            [['user_id', 'created_by'], 'required'],
            [['user_id', 'physical_health', 'creativity', 'knowledge', 'happiness', 'money', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'physical_health' => 'Physical Health',
            'creativity' => 'Creativity',
            'knowledge' => 'Knowledge',
            'happiness' => 'Happiness',
            'money' => 'Money',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
