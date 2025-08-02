<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%quest_templates}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $quest_type
 * @property string|null $difficulty
 * @property int|null $duration_days
 * @property string|null $icon
 * @property int|null $health_reward
 * @property int|null $creativity_reward
 * @property int|null $knowledge_reward
 * @property int|null $happiness_reward
 * @property int|null $money_reward
 * @property int|null $xp_reward
 * @property int|null $coins_reward
 * @property int|null $gems_reward
 * @property int|null $is_system_quest
 * @property int|null $is_active
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property UserQuests[] $userQuests
 */
class QuestTemplates extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const QUEST_TYPE_DAILY = 'daily';
    const QUEST_TYPE_WEEKLY = 'weekly';
    const QUEST_TYPE_MONTHLY = 'monthly';
    const QUEST_TYPE_CUSTOM = 'custom';
    const QUEST_TYPE_EPIC = 'epic';
    const DIFFICULTY_EASY = 'easy';
    const DIFFICULTY_MEDIUM = 'medium';
    const DIFFICULTY_HARD = 'hard';
    const DIFFICULTY_LEGENDARY = 'legendary';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quest_templates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['quest_type'], 'default', 'value' => 'custom'],
            [['difficulty'], 'default', 'value' => 'medium'],
            [['duration_days'], 'default', 'value' => 30],
            [['icon'], 'default', 'value' => 'fas fa-scroll'],
            [['is_system_quest'], 'default', 'value' => 0],
            [['xp_reward'], 'default', 'value' => 100],
            [['is_active'], 'default', 'value' => 1],
            [['name', 'created_by'], 'required'],
            [['description', 'quest_type', 'difficulty'], 'string'],
            [['duration_days', 'health_reward', 'creativity_reward', 'knowledge_reward', 'happiness_reward', 'money_reward', 'xp_reward', 'coins_reward', 'gems_reward', 'is_system_quest', 'is_active', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 50],
            ['quest_type', 'in', 'range' => array_keys(self::optsQuestType())],
            ['difficulty', 'in', 'range' => array_keys(self::optsDifficulty())],
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
            'name' => 'Name',
            'description' => 'Description',
            'quest_type' => 'Quest Type',
            'difficulty' => 'Difficulty',
            'duration_days' => 'Duration Days',
            'icon' => 'Icon',
            'health_reward' => 'Health Reward',
            'creativity_reward' => 'Creativity Reward',
            'knowledge_reward' => 'Knowledge Reward',
            'happiness_reward' => 'Happiness Reward',
            'money_reward' => 'Money Reward',
            'xp_reward' => 'Xp Reward',
            'coins_reward' => 'Coins Reward',
            'gems_reward' => 'Gems Reward',
            'is_system_quest' => 'Is System Quest',
            'is_active' => 'Is Active',
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
     * Gets query for [[UserQuests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuests()
    {
        return $this->hasMany(UserQuests::class, ['quest_template_id' => 'id']);
    }


    /**
     * column quest_type ENUM value labels
     * @return string[]
     */
    public static function optsQuestType()
    {
        return [
            self::QUEST_TYPE_DAILY => 'daily',
            self::QUEST_TYPE_WEEKLY => 'weekly',
            self::QUEST_TYPE_MONTHLY => 'monthly',
            self::QUEST_TYPE_CUSTOM => 'custom',
            self::QUEST_TYPE_EPIC => 'epic',
        ];
    }

    /**
     * column difficulty ENUM value labels
     * @return string[]
     */
    public static function optsDifficulty()
    {
        return [
            self::DIFFICULTY_EASY => 'easy',
            self::DIFFICULTY_MEDIUM => 'medium',
            self::DIFFICULTY_HARD => 'hard',
            self::DIFFICULTY_LEGENDARY => 'legendary',
        ];
    }

    /**
     * @return string
     */
    public function displayQuestType()
    {
        return self::optsQuestType()[$this->quest_type];
    }

    /**
     * @return bool
     */
    public function isQuestTypeDaily()
    {
        return $this->quest_type === self::QUEST_TYPE_DAILY;
    }

    public function setQuestTypeToDaily()
    {
        $this->quest_type = self::QUEST_TYPE_DAILY;
    }

    /**
     * @return bool
     */
    public function isQuestTypeWeekly()
    {
        return $this->quest_type === self::QUEST_TYPE_WEEKLY;
    }

    public function setQuestTypeToWeekly()
    {
        $this->quest_type = self::QUEST_TYPE_WEEKLY;
    }

    /**
     * @return bool
     */
    public function isQuestTypeMonthly()
    {
        return $this->quest_type === self::QUEST_TYPE_MONTHLY;
    }

    public function setQuestTypeToMonthly()
    {
        $this->quest_type = self::QUEST_TYPE_MONTHLY;
    }

    /**
     * @return bool
     */
    public function isQuestTypeCustom()
    {
        return $this->quest_type === self::QUEST_TYPE_CUSTOM;
    }

    public function setQuestTypeToCustom()
    {
        $this->quest_type = self::QUEST_TYPE_CUSTOM;
    }

    /**
     * @return bool
     */
    public function isQuestTypeEpic()
    {
        return $this->quest_type === self::QUEST_TYPE_EPIC;
    }

    public function setQuestTypeToEpic()
    {
        $this->quest_type = self::QUEST_TYPE_EPIC;
    }

    /**
     * @return string
     */
    public function displayDifficulty()
    {
        return self::optsDifficulty()[$this->difficulty];
    }

    /**
     * @return bool
     */
    public function isDifficultyEasy()
    {
        return $this->difficulty === self::DIFFICULTY_EASY;
    }

    public function setDifficultyToEasy()
    {
        $this->difficulty = self::DIFFICULTY_EASY;
    }

    /**
     * @return bool
     */
    public function isDifficultyMedium()
    {
        return $this->difficulty === self::DIFFICULTY_MEDIUM;
    }

    public function setDifficultyToMedium()
    {
        $this->difficulty = self::DIFFICULTY_MEDIUM;
    }

    /**
     * @return bool
     */
    public function isDifficultyHard()
    {
        return $this->difficulty === self::DIFFICULTY_HARD;
    }

    public function setDifficultyToHard()
    {
        $this->difficulty = self::DIFFICULTY_HARD;
    }

    /**
     * @return bool
     */
    public function isDifficultyLegendary()
    {
        return $this->difficulty === self::DIFFICULTY_LEGENDARY;
    }

    public function setDifficultyToLegendary()
    {
        $this->difficulty = self::DIFFICULTY_LEGENDARY;
    }
}
