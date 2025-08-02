<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_habit_metadata".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string|null $planned_frequency
 * @property int|null $frequency_value How many times per frequency period
 * @property string|null $reminder_time
 * @property int|null $reminder_enabled
 * @property string|null $color_code
 * @property string|null $icon
 * @property int|null $health_update
 * @property int|null $creativity_update
 * @property int|null $knowledge_update
 * @property int|null $happiness_update
 * @property int|null $money_update
 * @property int|null $xp_reward
 * @property int|null $is_active
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property GoalLogs[] $goalLogs
 * @property HabitLogs[] $habitLogs
 * @property HabitStreaks[] $habitStreaks
 * @property QuestLogs[] $questLogs
 * @property Users $user
 * @property Users[] $users
 */
class HabitMetadata extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PLANNED_FREQUENCY_DAILY = 'daily';
    const PLANNED_FREQUENCY_WEEKLY = 'weekly';
    const PLANNED_FREQUENCY_CUSTOM = 'custom';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_habit_metadata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'reminder_time'], 'default', 'value' => null],
            [['planned_frequency'], 'default', 'value' => 'daily'],
            [['is_active'], 'default', 'value' => 1],
            [['color_code'], 'default', 'value' => '#10b981'],
            [['icon'], 'default', 'value' => 'fas fa-check-circle'],
            [['money_update'], 'default', 'value' => 0],
            [['xp_reward'], 'default', 'value' => 5],
            [['user_id', 'name', 'created_by'], 'required'],
            [['user_id', 'frequency_value', 'reminder_enabled', 'health_update', 'creativity_update', 'knowledge_update', 'happiness_update', 'money_update', 'xp_reward', 'is_active', 'created_by'], 'integer'],
            [['description', 'planned_frequency'], 'string'],
            [['reminder_time', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['color_code'], 'string', 'max' => 7],
            [['icon'], 'string', 'max' => 50],
            ['planned_frequency', 'in', 'range' => array_keys(self::optsPlannedFrequency())],
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
            'name' => 'Name',
            'description' => 'Description',
            'planned_frequency' => 'Planned Frequency',
            'frequency_value' => 'Frequency Value',
            'reminder_time' => 'Reminder Time',
            'reminder_enabled' => 'Reminder Enabled',
            'color_code' => 'Color Code',
            'icon' => 'Icon',
            'health_update' => 'Health Update',
            'creativity_update' => 'Creativity Update',
            'knowledge_update' => 'Knowledge Update',
            'happiness_update' => 'Happiness Update',
            'money_update' => 'Money Update',
            'xp_reward' => 'Xp Reward',
            'is_active' => 'Is Active',
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
     * Gets query for [[GoalLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalLogs()
    {
        return $this->hasMany(GoalLogs::class, ['related_habit_id' => 'id']);
    }

    /**
     * Gets query for [[HabitLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitLogs()
    {
        return $this->hasMany(HabitLogs::class, ['habit_id' => 'id']);
    }

    /**
     * Gets query for [[HabitStreaks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitStreaks()
    {
        return $this->hasMany(HabitStreaks::class, ['habit_id' => 'id']);
    }

    /**
     * Gets query for [[QuestLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestLogs()
    {
        return $this->hasMany(QuestLogs::class, ['related_habit_id' => 'id']);
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
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('tbl_habit_streaks', ['habit_id' => 'id']);
    }


    /**
     * column planned_frequency ENUM value labels
     * @return string[]
     */
    public static function optsPlannedFrequency()
    {
        return [
            self::PLANNED_FREQUENCY_DAILY => 'daily',
            self::PLANNED_FREQUENCY_WEEKLY => 'weekly',
            self::PLANNED_FREQUENCY_CUSTOM => 'custom',
        ];
    }

    /**
     * @return string
     */
    public function displayPlannedFrequency()
    {
        return self::optsPlannedFrequency()[$this->planned_frequency];
    }

    /**
     * @return bool
     */
    public function isPlannedFrequencyDaily()
    {
        return $this->planned_frequency === self::PLANNED_FREQUENCY_DAILY;
    }

    public function setPlannedFrequencyToDaily()
    {
        $this->planned_frequency = self::PLANNED_FREQUENCY_DAILY;
    }

    /**
     * @return bool
     */
    public function isPlannedFrequencyWeekly()
    {
        return $this->planned_frequency === self::PLANNED_FREQUENCY_WEEKLY;
    }

    public function setPlannedFrequencyToWeekly()
    {
        $this->planned_frequency = self::PLANNED_FREQUENCY_WEEKLY;
    }

    /**
     * @return bool
     */
    public function isPlannedFrequencyCustom()
    {
        return $this->planned_frequency === self::PLANNED_FREQUENCY_CUSTOM;
    }

    public function setPlannedFrequencyToCustom()
    {
        $this->planned_frequency = self::PLANNED_FREQUENCY_CUSTOM;
    }
}
