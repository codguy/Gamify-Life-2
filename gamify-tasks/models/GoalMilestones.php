<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_goal_milestones".
 *
 * @property int $id
 * @property int $goal_id
 * @property string $title
 * @property string|null $description
 * @property string|null $target_date
 * @property int|null $is_completed
 * @property string|null $completed_at
 * @property int|null $sort_order
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property GoalMetadata $goal
 */
class GoalMilestones extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_goal_milestones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'target_date', 'completed_at'], 'default', 'value' => null],
            [['sort_order'], 'default', 'value' => 0],
            [['goal_id', 'title', 'created_by'], 'required'],
            [['goal_id', 'is_completed', 'sort_order', 'created_by'], 'integer'],
            [['description'], 'string'],
            [['target_date', 'completed_at', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['goal_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoalMetadata::class, 'targetAttribute' => ['goal_id' => 'id']],
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
            'goal_id' => 'Goal ID',
            'title' => 'Title',
            'description' => 'Description',
            'target_date' => 'Target Date',
            'is_completed' => 'Is Completed',
            'completed_at' => 'Completed At',
            'sort_order' => 'Sort Order',
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
     * Gets query for [[Goal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoal()
    {
        return $this->hasOne(GoalMetadata::class, ['id' => 'goal_id']);
    }

}
