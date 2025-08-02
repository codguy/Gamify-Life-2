<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_daily_stats".
 *
 * @property int $id
 * @property int $user_id
 * @property string $stat_date
 * @property int|null $tasks_completed
 * @property int|null $habits_completed
 * @property int|null $quests_progress
 * @property int|null $journal_entries
 * @property int|null $xp_gained
 * @property int|null $level_at_end_of_day
 * @property int|null $physical_health
 * @property int|null $creativity
 * @property int|null $knowledge
 * @property int|null $happiness
 * @property int|null $money
 * @property int|null $active_streaks
 * @property int|null $longest_streak_today
 * @property int|null $social_interactions
 * @property int|null $achievements_earned
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class DailyStats extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_daily_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['achievements_earned'], 'default', 'value' => 0],
            [['level_at_end_of_day'], 'default', 'value' => 1],
            [['user_id', 'stat_date', 'created_by'], 'required'],
            [['user_id', 'tasks_completed', 'habits_completed', 'quests_progress', 'journal_entries', 'xp_gained', 'level_at_end_of_day', 'physical_health', 'creativity', 'knowledge', 'happiness', 'money', 'active_streaks', 'longest_streak_today', 'social_interactions', 'achievements_earned', 'created_by'], 'integer'],
            [['stat_date', 'created_at', 'updated_at'], 'safe'],
            [['user_id', 'stat_date'], 'unique', 'targetAttribute' => ['user_id', 'stat_date']],
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
            'stat_date' => 'Stat Date',
            'tasks_completed' => 'Tasks Completed',
            'habits_completed' => 'Habits Completed',
            'quests_progress' => 'Quests Progress',
            'journal_entries' => 'Journal Entries',
            'xp_gained' => 'Xp Gained',
            'level_at_end_of_day' => 'Level At End Of Day',
            'physical_health' => 'Physical Health',
            'creativity' => 'Creativity',
            'knowledge' => 'Knowledge',
            'happiness' => 'Happiness',
            'money' => 'Money',
            'active_streaks' => 'Active Streaks',
            'longest_streak_today' => 'Longest Streak Today',
            'social_interactions' => 'Social Interactions',
            'achievements_earned' => 'Achievements Earned',
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
