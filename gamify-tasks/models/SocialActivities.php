<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%social_activities}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $activity_type
 * @property string|null $activity_data Flexible data for different activity types
 * @property int|null $is_public
 * @property int|null $likes_count
 * @property int|null $comments_count
 * @property int|null $shares_count
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property SocialInteractions[] $socialInteractions
 * @property Users $user
 */
class SocialActivities extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ACTIVITY_TYPE_TASK_COMPLETED = 'task_completed';
    const ACTIVITY_TYPE_QUEST_COMPLETED = 'quest_completed';
    const ACTIVITY_TYPE_ACHIEVEMENT_EARNED = 'achievement_earned';
    const ACTIVITY_TYPE_LEVEL_UP = 'level_up';
    const ACTIVITY_TYPE_STREAK_MILESTONE = 'streak_milestone';
    const ACTIVITY_TYPE_GOAL_COMPLETED = 'goal_completed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%social_activities}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_data'], 'default', 'value' => null],
            [['is_public'], 'default', 'value' => 1],
            [['shares_count'], 'default', 'value' => 0],
            [['user_id', 'activity_type', 'created_by'], 'required'],
            [['user_id', 'is_public', 'likes_count', 'comments_count', 'shares_count', 'created_by'], 'integer'],
            [['activity_type'], 'string'],
            [['activity_data', 'created_at', 'updated_at'], 'safe'],
            ['activity_type', 'in', 'range' => array_keys(self::optsActivityType())],
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
            'activity_type' => 'Activity Type',
            'activity_data' => 'Activity Data',
            'is_public' => 'Is Public',
            'likes_count' => 'Likes Count',
            'comments_count' => 'Comments Count',
            'shares_count' => 'Shares Count',
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
     * Gets query for [[SocialInteractions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialInteractions()
    {
        return $this->hasMany(SocialInteractions::class, ['activity_id' => 'id']);
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
     * column activity_type ENUM value labels
     * @return string[]
     */
    public static function optsActivityType()
    {
        return [
            self::ACTIVITY_TYPE_TASK_COMPLETED => 'task_completed',
            self::ACTIVITY_TYPE_QUEST_COMPLETED => 'quest_completed',
            self::ACTIVITY_TYPE_ACHIEVEMENT_EARNED => 'achievement_earned',
            self::ACTIVITY_TYPE_LEVEL_UP => 'level_up',
            self::ACTIVITY_TYPE_STREAK_MILESTONE => 'streak_milestone',
            self::ACTIVITY_TYPE_GOAL_COMPLETED => 'goal_completed',
        ];
    }

    /**
     * @return string
     */
    public function displayActivityType()
    {
        return self::optsActivityType()[$this->activity_type];
    }

    /**
     * @return bool
     */
    public function isActivityTypeTaskcompleted()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_TASK_COMPLETED;
    }

    public function setActivityTypeToTaskcompleted()
    {
        $this->activity_type = self::ACTIVITY_TYPE_TASK_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isActivityTypeQuestcompleted()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_QUEST_COMPLETED;
    }

    public function setActivityTypeToQuestcompleted()
    {
        $this->activity_type = self::ACTIVITY_TYPE_QUEST_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isActivityTypeAchievementearned()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_ACHIEVEMENT_EARNED;
    }

    public function setActivityTypeToAchievementearned()
    {
        $this->activity_type = self::ACTIVITY_TYPE_ACHIEVEMENT_EARNED;
    }

    /**
     * @return bool
     */
    public function isActivityTypeLevelup()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_LEVEL_UP;
    }

    public function setActivityTypeToLevelup()
    {
        $this->activity_type = self::ACTIVITY_TYPE_LEVEL_UP;
    }

    /**
     * @return bool
     */
    public function isActivityTypeStreakmilestone()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_STREAK_MILESTONE;
    }

    public function setActivityTypeToStreakmilestone()
    {
        $this->activity_type = self::ACTIVITY_TYPE_STREAK_MILESTONE;
    }

    /**
     * @return bool
     */
    public function isActivityTypeGoalcompleted()
    {
        return $this->activity_type === self::ACTIVITY_TYPE_GOAL_COMPLETED;
    }

    public function setActivityTypeToGoalcompleted()
    {
        $this->activity_type = self::ACTIVITY_TYPE_GOAL_COMPLETED;
    }
}
