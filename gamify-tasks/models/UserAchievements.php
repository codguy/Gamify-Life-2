<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_achievements".
 *
 * @property int $id
 * @property int $user_id
 * @property int $achievement_id
 * @property int|null $progress_current
 * @property int|null $progress_target
 * @property int|null $is_completed
 * @property string|null $completed_at
 * @property int|null $is_showcased
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AchievementMetadata $achievement
 * @property Users $createdBy
 * @property Users $user
 */
class UserAchievements extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_achievements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['completed_at'], 'default', 'value' => null],
            [['is_showcased'], 'default', 'value' => 0],
            [['progress_target'], 'default', 'value' => 1],
            [['user_id', 'achievement_id', 'created_by'], 'required'],
            [['user_id', 'achievement_id', 'progress_current', 'progress_target', 'is_completed', 'is_showcased', 'created_by'], 'integer'],
            [['completed_at', 'created_at', 'updated_at'], 'safe'],
            [['user_id', 'achievement_id'], 'unique', 'targetAttribute' => ['user_id', 'achievement_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['achievement_id'], 'exist', 'skipOnError' => true, 'targetClass' => AchievementMetadata::class, 'targetAttribute' => ['achievement_id' => 'id']],
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
            'achievement_id' => 'Achievement ID',
            'progress_current' => 'Progress Current',
            'progress_target' => 'Progress Target',
            'is_completed' => 'Is Completed',
            'completed_at' => 'Completed At',
            'is_showcased' => 'Is Showcased',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Achievement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(AchievementMetadata::class, ['id' => 'achievement_id']);
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
