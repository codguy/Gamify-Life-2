<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%habit_streaks}}".
 *
 * @property int $id
 * @property int $habit_id
 * @property int $user_id
 * @property int|null $current_streak
 * @property int|null $longest_streak
 * @property string|null $last_completion_date
 * @property string|null $streak_start_date
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property HabitMetadata $habit
 * @property Users $user
 */
class HabitStreaks extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%habit_streaks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_completion_date', 'streak_start_date'], 'default', 'value' => null],
            [['longest_streak'], 'default', 'value' => 0],
            [['habit_id', 'user_id', 'created_by'], 'required'],
            [['habit_id', 'user_id', 'current_streak', 'longest_streak', 'created_by'], 'integer'],
            [['last_completion_date', 'streak_start_date', 'created_at', 'updated_at'], 'safe'],
            [['habit_id', 'user_id'], 'unique', 'targetAttribute' => ['habit_id', 'user_id']],
            [['habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => HabitMetadata::class, 'targetAttribute' => ['habit_id' => 'id']],
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
            'habit_id' => 'Habit ID',
            'user_id' => 'User ID',
            'current_streak' => 'Current Streak',
            'longest_streak' => 'Longest Streak',
            'last_completion_date' => 'Last Completion Date',
            'streak_start_date' => 'Streak Start Date',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
