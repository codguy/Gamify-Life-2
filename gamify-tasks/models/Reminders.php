<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%reminders}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $reminder_type
 * @property int|null $related_id ID of related habit/task/goal
 * @property string $title
 * @property string|null $message
 * @property string $reminder_time
 * @property string|null $reminder_days Array of weekdays (0-6, Sunday=0)
 * @property string|null $timezone
 * @property int|null $is_active
 * @property string|null $last_sent_at
 * @property string|null $next_send_at
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class Reminders extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const REMINDER_TYPE_HABIT = 'habit';
    const REMINDER_TYPE_TASK = 'task';
    const REMINDER_TYPE_GOAL = 'goal';
    const REMINDER_TYPE_CUSTOM = 'custom';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reminders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['related_id', 'message', 'reminder_days', 'last_sent_at', 'next_send_at'], 'default', 'value' => null],
            [['timezone'], 'default', 'value' => 'UTC'],
            [['is_active'], 'default', 'value' => 1],
            [['user_id', 'reminder_type', 'title', 'reminder_time', 'created_by'], 'required'],
            [['user_id', 'related_id', 'is_active', 'created_by'], 'integer'],
            [['reminder_type', 'message'], 'string'],
            [['reminder_time', 'reminder_days', 'last_sent_at', 'next_send_at', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 50],
            ['reminder_type', 'in', 'range' => array_keys(self::optsReminderType())],
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
            'reminder_type' => 'Reminder Type',
            'related_id' => 'Related ID',
            'title' => 'Title',
            'message' => 'Message',
            'reminder_time' => 'Reminder Time',
            'reminder_days' => 'Reminder Days',
            'timezone' => 'Timezone',
            'is_active' => 'Is Active',
            'last_sent_at' => 'Last Sent At',
            'next_send_at' => 'Next Send At',
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
     * column reminder_type ENUM value labels
     * @return string[]
     */
    public static function optsReminderType()
    {
        return [
            self::REMINDER_TYPE_HABIT => 'habit',
            self::REMINDER_TYPE_TASK => 'task',
            self::REMINDER_TYPE_GOAL => 'goal',
            self::REMINDER_TYPE_CUSTOM => 'custom',
        ];
    }

    /**
     * @return string
     */
    public function displayReminderType()
    {
        return self::optsReminderType()[$this->reminder_type];
    }

    /**
     * @return bool
     */
    public function isReminderTypeHabit()
    {
        return $this->reminder_type === self::REMINDER_TYPE_HABIT;
    }

    public function setReminderTypeToHabit()
    {
        $this->reminder_type = self::REMINDER_TYPE_HABIT;
    }

    /**
     * @return bool
     */
    public function isReminderTypeTask()
    {
        return $this->reminder_type === self::REMINDER_TYPE_TASK;
    }

    public function setReminderTypeToTask()
    {
        $this->reminder_type = self::REMINDER_TYPE_TASK;
    }

    /**
     * @return bool
     */
    public function isReminderTypeGoal()
    {
        return $this->reminder_type === self::REMINDER_TYPE_GOAL;
    }

    public function setReminderTypeToGoal()
    {
        $this->reminder_type = self::REMINDER_TYPE_GOAL;
    }

    /**
     * @return bool
     */
    public function isReminderTypeCustom()
    {
        return $this->reminder_type === self::REMINDER_TYPE_CUSTOM;
    }

    public function setReminderTypeToCustom()
    {
        $this->reminder_type = self::REMINDER_TYPE_CUSTOM;
    }
}
