<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%leaderboard_entries}}".
 *
 * @property int $id
 * @property int $period_id
 * @property int $user_id
 * @property int $rank_position
 * @property int|null $total_xp
 * @property int|null $tasks_completed
 * @property int|null $habits_completed
 * @property int|null $quests_completed
 * @property int|null $achievements_earned
 * @property int|null $streak_days
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property LeaderboardPeriods $period
 * @property Users $user
 */
class LeaderboardEntries extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leaderboard_entries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['streak_days'], 'default', 'value' => 0],
            [['period_id', 'user_id', 'rank_position', 'created_by'], 'required'],
            [['period_id', 'user_id', 'rank_position', 'total_xp', 'tasks_completed', 'habits_completed', 'quests_completed', 'achievements_earned', 'streak_days', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['period_id', 'user_id'], 'unique', 'targetAttribute' => ['period_id', 'user_id']],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeaderboardPeriods::class, 'targetAttribute' => ['period_id' => 'id']],
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
            'period_id' => 'Period ID',
            'user_id' => 'User ID',
            'rank_position' => 'Rank Position',
            'total_xp' => 'Total Xp',
            'tasks_completed' => 'Tasks Completed',
            'habits_completed' => 'Habits Completed',
            'quests_completed' => 'Quests Completed',
            'achievements_earned' => 'Achievements Earned',
            'streak_days' => 'Streak Days',
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
     * Gets query for [[Period]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeriod()
    {
        return $this->hasOne(LeaderboardPeriods::class, ['id' => 'period_id']);
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
