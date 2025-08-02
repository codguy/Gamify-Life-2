<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $title
 * @property string|null $message
 * @property string|null $data Additional notification data
 * @property int|null $is_read
 * @property string|null $read_at
 * @property string|null $expires_at
 * @property string|null $priority
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class Notifications extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TYPE_REMINDER = 'reminder';
    const TYPE_ACHIEVEMENT = 'achievement';
    const TYPE_SOCIAL = 'social';
    const TYPE_SYSTEM = 'system';
    const TYPE_QUEST = 'quest';
    const TYPE_FRIEND_REQUEST = 'friend_request';
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'data', 'read_at', 'expires_at'], 'default', 'value' => null],
            [['is_read'], 'default', 'value' => 0],
            [['priority'], 'default', 'value' => 'medium'],
            [['user_id', 'type', 'title', 'created_by'], 'required'],
            [['user_id', 'is_read', 'created_by'], 'integer'],
            [['type', 'message', 'priority'], 'string'],
            [['data', 'read_at', 'expires_at', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['type', 'in', 'range' => array_keys(self::optsType())],
            ['priority', 'in', 'range' => array_keys(self::optsPriority())],
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
            'type' => 'Type',
            'title' => 'Title',
            'message' => 'Message',
            'data' => 'Data',
            'is_read' => 'Is Read',
            'read_at' => 'Read At',
            'expires_at' => 'Expires At',
            'priority' => 'Priority',
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


    /**
     * column type ENUM value labels
     * @return string[]
     */
    public static function optsType()
    {
        return [
            self::TYPE_REMINDER => 'reminder',
            self::TYPE_ACHIEVEMENT => 'achievement',
            self::TYPE_SOCIAL => 'social',
            self::TYPE_SYSTEM => 'system',
            self::TYPE_QUEST => 'quest',
            self::TYPE_FRIEND_REQUEST => 'friend_request',
        ];
    }

    /**
     * column priority ENUM value labels
     * @return string[]
     */
    public static function optsPriority()
    {
        return [
            self::PRIORITY_LOW => 'low',
            self::PRIORITY_MEDIUM => 'medium',
            self::PRIORITY_HIGH => 'high',
        ];
    }

    /**
     * @return string
     */
    public function displayType()
    {
        return self::optsType()[$this->type];
    }

    /**
     * @return bool
     */
    public function isTypeReminder()
    {
        return $this->type === self::TYPE_REMINDER;
    }

    public function setTypeToReminder()
    {
        $this->type = self::TYPE_REMINDER;
    }

    /**
     * @return bool
     */
    public function isTypeAchievement()
    {
        return $this->type === self::TYPE_ACHIEVEMENT;
    }

    public function setTypeToAchievement()
    {
        $this->type = self::TYPE_ACHIEVEMENT;
    }

    /**
     * @return bool
     */
    public function isTypeSocial()
    {
        return $this->type === self::TYPE_SOCIAL;
    }

    public function setTypeToSocial()
    {
        $this->type = self::TYPE_SOCIAL;
    }

    /**
     * @return bool
     */
    public function isTypeSystem()
    {
        return $this->type === self::TYPE_SYSTEM;
    }

    public function setTypeToSystem()
    {
        $this->type = self::TYPE_SYSTEM;
    }

    /**
     * @return bool
     */
    public function isTypeQuest()
    {
        return $this->type === self::TYPE_QUEST;
    }

    public function setTypeToQuest()
    {
        $this->type = self::TYPE_QUEST;
    }

    /**
     * @return bool
     */
    public function isTypeFriendrequest()
    {
        return $this->type === self::TYPE_FRIEND_REQUEST;
    }

    public function setTypeToFriendrequest()
    {
        $this->type = self::TYPE_FRIEND_REQUEST;
    }

    /**
     * @return string
     */
    public function displayPriority()
    {
        return self::optsPriority()[$this->priority];
    }

    /**
     * @return bool
     */
    public function isPriorityLow()
    {
        return $this->priority === self::PRIORITY_LOW;
    }

    public function setPriorityToLow()
    {
        $this->priority = self::PRIORITY_LOW;
    }

    /**
     * @return bool
     */
    public function isPriorityMedium()
    {
        return $this->priority === self::PRIORITY_MEDIUM;
    }

    public function setPriorityToMedium()
    {
        $this->priority = self::PRIORITY_MEDIUM;
    }

    /**
     * @return bool
     */
    public function isPriorityHigh()
    {
        return $this->priority === self::PRIORITY_HIGH;
    }

    public function setPriorityToHigh()
    {
        $this->priority = self::PRIORITY_HIGH;
    }
}
