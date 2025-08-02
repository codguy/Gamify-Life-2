<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%quest_logs}}".
 *
 * @property int $id
 * @property int $user_quest_id
 * @property int|null $progress_increment
 * @property string|null $notes
 * @property int|null $related_task_id
 * @property int|null $related_habit_id
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property HabitMetadata $relatedHabit
 * @property TaskMetadata $relatedTask
 * @property UserQuests $userQuest
 */
class QuestLogs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quest_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes', 'related_task_id', 'related_habit_id'], 'default', 'value' => null],
            [['progress_increment'], 'default', 'value' => 1],
            [['user_quest_id', 'created_by'], 'required'],
            [['user_quest_id', 'progress_increment', 'related_task_id', 'related_habit_id', 'created_by'], 'integer'],
            [['notes'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_quest_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserQuests::class, 'targetAttribute' => ['user_quest_id' => 'id']],
            [['related_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskMetadata::class, 'targetAttribute' => ['related_task_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'id']],
            [['related_habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => HabitMetadata::class, 'targetAttribute' => ['related_habit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_quest_id' => 'User Quest ID',
            'progress_increment' => 'Progress Increment',
            'notes' => 'Notes',
            'related_task_id' => 'Related Task ID',
            'related_habit_id' => 'Related Habit ID',
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
     * Gets query for [[RelatedHabit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedHabit()
    {
        return $this->hasOne(HabitMetadata::class, ['id' => 'related_habit_id']);
    }

    /**
     * Gets query for [[RelatedTask]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedTask()
    {
        return $this->hasOne(TaskMetadata::class, ['id' => 'related_task_id']);
    }

    /**
     * Gets query for [[UserQuest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuest()
    {
        return $this->hasOne(UserQuests::class, ['id' => 'user_quest_id']);
    }

}
