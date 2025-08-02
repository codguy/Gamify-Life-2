<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_sessions".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $session_start
 * @property string|null $session_end
 * @property int|null $duration_minutes
 * @property int|null $activities_count
 * @property string|null $pages_visited Array of page visits
 * @property string|null $device_info
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class UserSessions extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_end', 'duration_minutes', 'pages_visited', 'device_info', 'ip_address', 'user_agent'], 'default', 'value' => null],
            [['activities_count'], 'default', 'value' => 0],
            [['user_id', 'created_by'], 'required'],
            [['user_id', 'duration_minutes', 'activities_count', 'created_by'], 'integer'],
            [['session_start', 'session_end', 'pages_visited', 'created_at', 'updated_at'], 'safe'],
            [['user_agent'], 'string'],
            [['device_info'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
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
            'session_start' => 'Session Start',
            'session_end' => 'Session End',
            'duration_minutes' => 'Duration Minutes',
            'activities_count' => 'Activities Count',
            'pages_visited' => 'Pages Visited',
            'device_info' => 'Device Info',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
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
