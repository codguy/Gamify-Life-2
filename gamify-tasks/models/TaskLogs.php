<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_logs}}".
 *
 * @property int $id
 * @property int $task_id
 * @property string $action
 * @property string|null $old_status
 * @property string|null $new_status
 * @property string|null $notes
 * @property int|null $time_spent Time spent in this session (minutes)
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property TaskMetadata $task
 */
class TaskLogs extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ACTION_CREATED = 'created';
    const ACTION_STARTED = 'started';
    const ACTION_PAUSED = 'paused';
    const ACTION_RESUMED = 'resumed';
    const ACTION_COMPLETED = 'completed';
    const ACTION_CANCELLED = 'cancelled';
    const ACTION_UPDATED = 'updated';
    const OLD_STATUS_PENDING = 'pending';
    const OLD_STATUS_IN_PROGRESS = 'in_progress';
    const OLD_STATUS_COMPLETED = 'completed';
    const OLD_STATUS_CANCELLED = 'cancelled';
    const NEW_STATUS_PENDING = 'pending';
    const NEW_STATUS_IN_PROGRESS = 'in_progress';
    const NEW_STATUS_COMPLETED = 'completed';
    const NEW_STATUS_CANCELLED = 'cancelled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['old_status', 'new_status', 'notes', 'time_spent'], 'default', 'value' => null],
            [['task_id', 'action', 'created_by'], 'required'],
            [['task_id', 'time_spent', 'created_by'], 'integer'],
            [['action', 'old_status', 'new_status', 'notes'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            ['action', 'in', 'range' => array_keys(self::optsAction())],
            ['old_status', 'in', 'range' => array_keys(self::optsOldStatus())],
            ['new_status', 'in', 'range' => array_keys(self::optsNewStatus())],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskMetadata::class, 'targetAttribute' => ['task_id' => 'id']],
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
            'task_id' => 'Task ID',
            'action' => 'Action',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'notes' => 'Notes',
            'time_spent' => 'Time Spent',
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
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskMetadata::class, ['id' => 'task_id']);
    }


    /**
     * column action ENUM value labels
     * @return string[]
     */
    public static function optsAction()
    {
        return [
            self::ACTION_CREATED => 'created',
            self::ACTION_STARTED => 'started',
            self::ACTION_PAUSED => 'paused',
            self::ACTION_RESUMED => 'resumed',
            self::ACTION_COMPLETED => 'completed',
            self::ACTION_CANCELLED => 'cancelled',
            self::ACTION_UPDATED => 'updated',
        ];
    }

    /**
     * column old_status ENUM value labels
     * @return string[]
     */
    public static function optsOldStatus()
    {
        return [
            self::OLD_STATUS_PENDING => 'pending',
            self::OLD_STATUS_IN_PROGRESS => 'in_progress',
            self::OLD_STATUS_COMPLETED => 'completed',
            self::OLD_STATUS_CANCELLED => 'cancelled',
        ];
    }

    /**
     * column new_status ENUM value labels
     * @return string[]
     */
    public static function optsNewStatus()
    {
        return [
            self::NEW_STATUS_PENDING => 'pending',
            self::NEW_STATUS_IN_PROGRESS => 'in_progress',
            self::NEW_STATUS_COMPLETED => 'completed',
            self::NEW_STATUS_CANCELLED => 'cancelled',
        ];
    }

    /**
     * @return string
     */
    public function displayAction()
    {
        return self::optsAction()[$this->action];
    }

    /**
     * @return bool
     */
    public function isActionCreated()
    {
        return $this->action === self::ACTION_CREATED;
    }

    public function setActionToCreated()
    {
        $this->action = self::ACTION_CREATED;
    }

    /**
     * @return bool
     */
    public function isActionStarted()
    {
        return $this->action === self::ACTION_STARTED;
    }

    public function setActionToStarted()
    {
        $this->action = self::ACTION_STARTED;
    }

    /**
     * @return bool
     */
    public function isActionPaused()
    {
        return $this->action === self::ACTION_PAUSED;
    }

    public function setActionToPaused()
    {
        $this->action = self::ACTION_PAUSED;
    }

    /**
     * @return bool
     */
    public function isActionResumed()
    {
        return $this->action === self::ACTION_RESUMED;
    }

    public function setActionToResumed()
    {
        $this->action = self::ACTION_RESUMED;
    }

    /**
     * @return bool
     */
    public function isActionCompleted()
    {
        return $this->action === self::ACTION_COMPLETED;
    }

    public function setActionToCompleted()
    {
        $this->action = self::ACTION_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isActionCancelled()
    {
        return $this->action === self::ACTION_CANCELLED;
    }

    public function setActionToCancelled()
    {
        $this->action = self::ACTION_CANCELLED;
    }

    /**
     * @return bool
     */
    public function isActionUpdated()
    {
        return $this->action === self::ACTION_UPDATED;
    }

    public function setActionToUpdated()
    {
        $this->action = self::ACTION_UPDATED;
    }

    /**
     * @return string
     */
    public function displayOldStatus()
    {
        return self::optsOldStatus()[$this->old_status];
    }

    /**
     * @return bool
     */
    public function isOldStatusPending()
    {
        return $this->old_status === self::OLD_STATUS_PENDING;
    }

    public function setOldStatusToPending()
    {
        $this->old_status = self::OLD_STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isOldStatusInprogress()
    {
        return $this->old_status === self::OLD_STATUS_IN_PROGRESS;
    }

    public function setOldStatusToInprogress()
    {
        $this->old_status = self::OLD_STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isOldStatusCompleted()
    {
        return $this->old_status === self::OLD_STATUS_COMPLETED;
    }

    public function setOldStatusToCompleted()
    {
        $this->old_status = self::OLD_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isOldStatusCancelled()
    {
        return $this->old_status === self::OLD_STATUS_CANCELLED;
    }

    public function setOldStatusToCancelled()
    {
        $this->old_status = self::OLD_STATUS_CANCELLED;
    }

    /**
     * @return string
     */
    public function displayNewStatus()
    {
        return self::optsNewStatus()[$this->new_status];
    }

    /**
     * @return bool
     */
    public function isNewStatusPending()
    {
        return $this->new_status === self::NEW_STATUS_PENDING;
    }

    public function setNewStatusToPending()
    {
        $this->new_status = self::NEW_STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isNewStatusInprogress()
    {
        return $this->new_status === self::NEW_STATUS_IN_PROGRESS;
    }

    public function setNewStatusToInprogress()
    {
        $this->new_status = self::NEW_STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isNewStatusCompleted()
    {
        return $this->new_status === self::NEW_STATUS_COMPLETED;
    }

    public function setNewStatusToCompleted()
    {
        $this->new_status = self::NEW_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isNewStatusCancelled()
    {
        return $this->new_status === self::NEW_STATUS_CANCELLED;
    }

    public function setNewStatusToCancelled()
    {
        $this->new_status = self::NEW_STATUS_CANCELLED;
    }
}
