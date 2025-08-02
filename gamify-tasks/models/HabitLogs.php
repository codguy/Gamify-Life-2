<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_habit_logs".
 *
 * @property int $id
 * @property int $habit_id
 * @property string $log_date
 * @property string $log_time
 * @property string|null $completion_status
 * @property string|null $notes
 * @property int|null $mood_rating Optional mood rating 1-5
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property HabitMetadata $habit
 */
class HabitLogs extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const COMPLETION_STATUS_COMPLETED = 'completed';
    const COMPLETION_STATUS_PARTIAL = 'partial';
    const COMPLETION_STATUS_SKIPPED = 'skipped';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_habit_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes', 'mood_rating'], 'default', 'value' => null],
            [['completion_status'], 'default', 'value' => 'completed'],
            [['habit_id', 'log_date', 'log_time', 'created_by'], 'required'],
            [['habit_id', 'mood_rating', 'created_by'], 'integer'],
            [['log_date', 'log_time', 'created_at', 'updated_at'], 'safe'],
            [['completion_status', 'notes'], 'string'],
            ['completion_status', 'in', 'range' => array_keys(self::optsCompletionStatus())],
            [['habit_id', 'log_date'], 'unique', 'targetAttribute' => ['habit_id', 'log_date']],
            [['habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => HabitMetadata::class, 'targetAttribute' => ['habit_id' => 'id']],
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
            'habit_id' => 'Habit ID',
            'log_date' => 'Log Date',
            'log_time' => 'Log Time',
            'completion_status' => 'Completion Status',
            'notes' => 'Notes',
            'mood_rating' => 'Mood Rating',
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
     * Gets query for [[Habit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabit()
    {
        return $this->hasOne(HabitMetadata::class, ['id' => 'habit_id']);
    }


    /**
     * column completion_status ENUM value labels
     * @return string[]
     */
    public static function optsCompletionStatus()
    {
        return [
            self::COMPLETION_STATUS_COMPLETED => 'completed',
            self::COMPLETION_STATUS_PARTIAL => 'partial',
            self::COMPLETION_STATUS_SKIPPED => 'skipped',
        ];
    }

    /**
     * @return string
     */
    public function displayCompletionStatus()
    {
        return self::optsCompletionStatus()[$this->completion_status];
    }

    /**
     * @return bool
     */
    public function isCompletionStatusCompleted()
    {
        return $this->completion_status === self::COMPLETION_STATUS_COMPLETED;
    }

    public function setCompletionStatusToCompleted()
    {
        $this->completion_status = self::COMPLETION_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isCompletionStatusPartial()
    {
        return $this->completion_status === self::COMPLETION_STATUS_PARTIAL;
    }

    public function setCompletionStatusToPartial()
    {
        $this->completion_status = self::COMPLETION_STATUS_PARTIAL;
    }

    /**
     * @return bool
     */
    public function isCompletionStatusSkipped()
    {
        return $this->completion_status === self::COMPLETION_STATUS_SKIPPED;
    }

    public function setCompletionStatusToSkipped()
    {
        $this->completion_status = self::COMPLETION_STATUS_SKIPPED;
    }
}
