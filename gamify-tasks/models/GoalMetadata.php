<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_goal_metadata".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $goal_type
 * @property string|null $priority
 * @property string|null $status
 * @property string|null $target_date
 * @property string|null $progress_type
 * @property float|null $progress_current
 * @property float|null $progress_target
 * @property string|null $progress_unit
 * @property int|null $health_reward
 * @property int|null $creativity_reward
 * @property int|null $knowledge_reward
 * @property int|null $happiness_reward
 * @property int|null $money_reward
 * @property int|null $xp_reward
 * @property string|null $completed_at
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property GoalLogs[] $goalLogs
 * @property GoalMilestones[] $goalMilestones
 * @property Users $user
 */
class GoalMetadata extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const GOAL_TYPE_HEALTH = 'health';
    const GOAL_TYPE_LEARNING = 'learning';
    const GOAL_TYPE_CAREER = 'career';
    const GOAL_TYPE_PERSONAL = 'personal';
    const GOAL_TYPE_FINANCIAL = 'financial';
    const GOAL_TYPE_CREATIVE = 'creative';
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PAUSED = 'paused';
    const STATUS_CANCELLED = 'cancelled';
    const PROGRESS_TYPE_BOOLEAN = 'boolean';
    const PROGRESS_TYPE_NUMERIC = 'numeric';
    const PROGRESS_TYPE_CHECKLIST = 'checklist';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_goal_metadata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'target_date', 'progress_unit', 'completed_at'], 'default', 'value' => null],
            [['goal_type'], 'default', 'value' => 'personal'],
            [['priority'], 'default', 'value' => 'medium'],
            [['status'], 'default', 'value' => 'active'],
            [['progress_type'], 'default', 'value' => 'boolean'],
            [['progress_current'], 'default', 'value' => 0.00],
            [['progress_target'], 'default', 'value' => 1.00],
            [['money_reward'], 'default', 'value' => 0],
            [['xp_reward'], 'default', 'value' => 100],
            [['user_id', 'title', 'created_by'], 'required'],
            [['user_id', 'health_reward', 'creativity_reward', 'knowledge_reward', 'happiness_reward', 'money_reward', 'xp_reward', 'created_by'], 'integer'],
            [['description', 'goal_type', 'priority', 'status', 'progress_type'], 'string'],
            [['target_date', 'completed_at', 'created_at', 'updated_at'], 'safe'],
            [['progress_current', 'progress_target'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['progress_unit'], 'string', 'max' => 50],
            ['goal_type', 'in', 'range' => array_keys(self::optsGoalType())],
            ['priority', 'in', 'range' => array_keys(self::optsPriority())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            ['progress_type', 'in', 'range' => array_keys(self::optsProgressType())],
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
            'title' => 'Title',
            'description' => 'Description',
            'goal_type' => 'Goal Type',
            'priority' => 'Priority',
            'status' => 'Status',
            'target_date' => 'Target Date',
            'progress_type' => 'Progress Type',
            'progress_current' => 'Progress Current',
            'progress_target' => 'Progress Target',
            'progress_unit' => 'Progress Unit',
            'health_reward' => 'Health Reward',
            'creativity_reward' => 'Creativity Reward',
            'knowledge_reward' => 'Knowledge Reward',
            'happiness_reward' => 'Happiness Reward',
            'money_reward' => 'Money Reward',
            'xp_reward' => 'Xp Reward',
            'completed_at' => 'Completed At',
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
        return $this->hasMany(GoalLogs::class, ['goal_id' => 'id']);
    }

    /**
     * Gets query for [[GoalMilestones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalMilestones()
    {
        return $this->hasMany(GoalMilestones::class, ['goal_id' => 'id']);
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
     * column goal_type ENUM value labels
     * @return string[]
     */
    public static function optsGoalType()
    {
        return [
            self::GOAL_TYPE_HEALTH => 'health',
            self::GOAL_TYPE_LEARNING => 'learning',
            self::GOAL_TYPE_CAREER => 'career',
            self::GOAL_TYPE_PERSONAL => 'personal',
            self::GOAL_TYPE_FINANCIAL => 'financial',
            self::GOAL_TYPE_CREATIVE => 'creative',
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
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACTIVE => 'active',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_PAUSED => 'paused',
            self::STATUS_CANCELLED => 'cancelled',
        ];
    }

    /**
     * column progress_type ENUM value labels
     * @return string[]
     */
    public static function optsProgressType()
    {
        return [
            self::PROGRESS_TYPE_BOOLEAN => 'boolean',
            self::PROGRESS_TYPE_NUMERIC => 'numeric',
            self::PROGRESS_TYPE_CHECKLIST => 'checklist',
        ];
    }

    /**
     * @return string
     */
    public function displayGoalType()
    {
        return self::optsGoalType()[$this->goal_type];
    }

    /**
     * @return bool
     */
    public function isGoalTypeHealth()
    {
        return $this->goal_type === self::GOAL_TYPE_HEALTH;
    }

    public function setGoalTypeToHealth()
    {
        $this->goal_type = self::GOAL_TYPE_HEALTH;
    }

    /**
     * @return bool
     */
    public function isGoalTypeLearning()
    {
        return $this->goal_type === self::GOAL_TYPE_LEARNING;
    }

    public function setGoalTypeToLearning()
    {
        $this->goal_type = self::GOAL_TYPE_LEARNING;
    }

    /**
     * @return bool
     */
    public function isGoalTypeCareer()
    {
        return $this->goal_type === self::GOAL_TYPE_CAREER;
    }

    public function setGoalTypeToCareer()
    {
        $this->goal_type = self::GOAL_TYPE_CAREER;
    }

    /**
     * @return bool
     */
    public function isGoalTypePersonal()
    {
        return $this->goal_type === self::GOAL_TYPE_PERSONAL;
    }

    public function setGoalTypeToPersonal()
    {
        $this->goal_type = self::GOAL_TYPE_PERSONAL;
    }

    /**
     * @return bool
     */
    public function isGoalTypeFinancial()
    {
        return $this->goal_type === self::GOAL_TYPE_FINANCIAL;
    }

    public function setGoalTypeToFinancial()
    {
        $this->goal_type = self::GOAL_TYPE_FINANCIAL;
    }

    /**
     * @return bool
     */
    public function isGoalTypeCreative()
    {
        return $this->goal_type === self::GOAL_TYPE_CREATIVE;
    }

    public function setGoalTypeToCreative()
    {
        $this->goal_type = self::GOAL_TYPE_CREATIVE;
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

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setStatusToActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isStatusPaused()
    {
        return $this->status === self::STATUS_PAUSED;
    }

    public function setStatusToPaused()
    {
        $this->status = self::STATUS_PAUSED;
    }

    /**
     * @return bool
     */
    public function isStatusCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setStatusToCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
    }

    /**
     * @return string
     */
    public function displayProgressType()
    {
        return self::optsProgressType()[$this->progress_type];
    }

    /**
     * @return bool
     */
    public function isProgressTypeBoolean()
    {
        return $this->progress_type === self::PROGRESS_TYPE_BOOLEAN;
    }

    public function setProgressTypeToBoolean()
    {
        $this->progress_type = self::PROGRESS_TYPE_BOOLEAN;
    }

    /**
     * @return bool
     */
    public function isProgressTypeNumeric()
    {
        return $this->progress_type === self::PROGRESS_TYPE_NUMERIC;
    }

    public function setProgressTypeToNumeric()
    {
        $this->progress_type = self::PROGRESS_TYPE_NUMERIC;
    }

    /**
     * @return bool
     */
    public function isProgressTypeChecklist()
    {
        return $this->progress_type === self::PROGRESS_TYPE_CHECKLIST;
    }

    public function setProgressTypeToChecklist()
    {
        $this->progress_type = self::PROGRESS_TYPE_CHECKLIST;
    }
}
