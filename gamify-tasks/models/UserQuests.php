<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_quests".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $quest_template_id
 * @property string|null $custom_name
 * @property string|null $custom_description
 * @property string|null $status
 * @property int|null $progress_current
 * @property int $progress_target
 * @property string|null $started_at
 * @property string|null $completed_at
 * @property string|null $expires_at
 * @property int|null $health_reward
 * @property int|null $creativity_reward
 * @property int|null $knowledge_reward
 * @property int|null $happiness_reward
 * @property int|null $money_reward
 * @property int|null $xp_reward
 * @property int|null $coins_reward
 * @property int|null $gems_reward
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property QuestLogs[] $questLogs
 * @property QuestTemplates $questTemplate
 * @property Users $user
 */
class UserQuests extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_ABANDONED = 'abandoned';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_quests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quest_template_id', 'custom_name', 'custom_description', 'started_at', 'completed_at', 'expires_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'available'],
            [['gems_reward'], 'default', 'value' => 0],
            [['xp_reward'], 'default', 'value' => 100],
            [['user_id', 'progress_target', 'created_by'], 'required'],
            [['user_id', 'quest_template_id', 'progress_current', 'progress_target', 'health_reward', 'creativity_reward', 'knowledge_reward', 'happiness_reward', 'money_reward', 'xp_reward', 'coins_reward', 'gems_reward', 'created_by'], 'integer'],
            [['custom_description', 'status'], 'string'],
            [['started_at', 'completed_at', 'expires_at', 'created_at', 'updated_at'], 'safe'],
            [['custom_name'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['quest_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestTemplates::class, 'targetAttribute' => ['quest_template_id' => 'id']],
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
            'quest_template_id' => 'Quest Template ID',
            'custom_name' => 'Custom Name',
            'custom_description' => 'Custom Description',
            'status' => 'Status',
            'progress_current' => 'Progress Current',
            'progress_target' => 'Progress Target',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
            'expires_at' => 'Expires At',
            'health_reward' => 'Health Reward',
            'creativity_reward' => 'Creativity Reward',
            'knowledge_reward' => 'Knowledge Reward',
            'happiness_reward' => 'Happiness Reward',
            'money_reward' => 'Money Reward',
            'xp_reward' => 'Xp Reward',
            'coins_reward' => 'Coins Reward',
            'gems_reward' => 'Gems Reward',
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
     * Gets query for [[QuestLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestLogs()
    {
        return $this->hasMany(QuestLogs::class, ['user_quest_id' => 'id']);
    }

    /**
     * Gets query for [[QuestTemplate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestTemplate()
    {
        return $this->hasOne(QuestTemplates::class, ['id' => 'quest_template_id']);
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
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_AVAILABLE => 'available',
            self::STATUS_ACTIVE => 'active',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_FAILED => 'failed',
            self::STATUS_ABANDONED => 'abandoned',
        ];
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
    public function isStatusAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function setStatusToAvailable()
    {
        $this->status = self::STATUS_AVAILABLE;
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
    public function isStatusFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed()
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isStatusAbandoned()
    {
        return $this->status === self::STATUS_ABANDONED;
    }

    public function setStatusToAbandoned()
    {
        $this->status = self::STATUS_ABANDONED;
    }
}
