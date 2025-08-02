<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_metadata}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $description
 * @property string|null $priority
 * @property string|null $status
 * @property string|null $due_date
 * @property int|null $estimated_duration Duration in minutes
 * @property int|null $actual_duration Actual time spent in minutes
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
 * @property TaskCategories $category
 * @property Users $createdBy
 * @property GoalLogs[] $goalLogs
 * @property QuestLogs[] $questLogs
 * @property TaskLogs[] $taskLogs
 * @property Users $user
 */
class TaskMetadata extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_metadata}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'description', 'due_date', 'estimated_duration', 'actual_duration', 'completed_at'], 'default', 'value' => null],
            [['priority'], 'default', 'value' => 'medium'],
            [['status'], 'default', 'value' => 'pending'],
            [['money_reward'], 'default', 'value' => 0],
            [['xp_reward'], 'default', 'value' => 10],
            [['user_id', 'title', 'created_by'], 'required'],
            [['user_id', 'category_id', 'estimated_duration', 'actual_duration', 'health_reward', 'creativity_reward', 'knowledge_reward', 'happiness_reward', 'money_reward', 'xp_reward', 'created_by'], 'integer'],
            [['description', 'priority', 'status'], 'string'],
            [['due_date', 'completed_at', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['priority', 'in', 'range' => array_keys(self::optsPriority())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskCategories::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'priority' => 'Priority',
            'status' => 'Status',
            'due_date' => 'Due Date',
            'estimated_duration' => 'Estimated Duration',
            'actual_duration' => 'Actual Duration',
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
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TaskCategories::class, ['id' => 'category_id']);
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
        return $this->hasMany(GoalLogs::class, ['related_task_id' => 'id']);
    }

    /**
     * Gets query for [[QuestLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestLogs()
    {
        return $this->hasMany(QuestLogs::class, ['related_task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskLogs()
    {
        return $this->hasMany(TaskLogs::class, ['task_id' => 'id']);
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
            self::STATUS_PENDING => 'pending',
            self::STATUS_IN_PROGRESS => 'in_progress',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_CANCELLED => 'cancelled',
        ];
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
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusInprogress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function setStatusToInprogress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
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
    public function isStatusCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setStatusToCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
    }
}
