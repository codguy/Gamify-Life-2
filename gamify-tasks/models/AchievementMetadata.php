<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_achievement_metadata".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $category
 * @property string|null $rarity
 * @property string|null $icon
 * @property string|null $badge_color
 * @property string|null $unlock_conditions
 * @property int|null $xp_reward
 * @property int|null $coins_reward
 * @property int|null $gems_reward
 * @property string|null $title_unlock
 * @property int|null $is_system_achievement
 * @property int|null $is_active
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property UserAchievements[] $userAchievements
 * @property Users[] $users
 */
class AchievementMetadata extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const CATEGORY_TASKS = 'tasks';
    const CATEGORY_HABITS = 'habits';
    const CATEGORY_QUESTS = 'quests';
    const CATEGORY_SOCIAL = 'social';
    const CATEGORY_STATS = 'stats';
    const CATEGORY_STREAKS = 'streaks';
    const CATEGORY_SPECIAL = 'special';
    const RARITY_COMMON = 'common';
    const RARITY_RARE = 'rare';
    const RARITY_EPIC = 'epic';
    const RARITY_LEGENDARY = 'legendary';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_achievement_metadata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'unlock_conditions', 'title_unlock'], 'default', 'value' => null],
            [['category'], 'default', 'value' => 'tasks'],
            [['rarity'], 'default', 'value' => 'common'],
            [['icon'], 'default', 'value' => 'fas fa-trophy'],
            [['badge_color'], 'default', 'value' => '#fbbf24'],
            [['xp_reward'], 'default', 'value' => 50],
            [['gems_reward'], 'default', 'value' => 0],
            [['is_active'], 'default', 'value' => 1],
            [['name', 'created_by'], 'required'],
            [['description', 'category', 'rarity'], 'string'],
            [['unlock_conditions', 'created_at', 'updated_at'], 'safe'],
            [['xp_reward', 'coins_reward', 'gems_reward', 'is_system_achievement', 'is_active', 'created_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 50],
            [['badge_color'], 'string', 'max' => 7],
            [['title_unlock'], 'string', 'max' => 100],
            ['category', 'in', 'range' => array_keys(self::optsCategory())],
            ['rarity', 'in', 'range' => array_keys(self::optsRarity())],
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
            'category' => 'Category',
            'rarity' => 'Rarity',
            'icon' => 'Icon',
            'badge_color' => 'Badge Color',
            'unlock_conditions' => 'Unlock Conditions',
            'xp_reward' => 'Xp Reward',
            'coins_reward' => 'Coins Reward',
            'gems_reward' => 'Gems Reward',
            'title_unlock' => 'Title Unlock',
            'is_system_achievement' => 'Is System Achievement',
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
     * Gets query for [[UserAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievements::class, ['achievement_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('tbl_user_achievements', ['achievement_id' => 'id']);
    }


    /**
     * column category ENUM value labels
     * @return string[]
     */
    public static function optsCategory()
    {
        return [
            self::CATEGORY_TASKS => 'tasks',
            self::CATEGORY_HABITS => 'habits',
            self::CATEGORY_QUESTS => 'quests',
            self::CATEGORY_SOCIAL => 'social',
            self::CATEGORY_STATS => 'stats',
            self::CATEGORY_STREAKS => 'streaks',
            self::CATEGORY_SPECIAL => 'special',
        ];
    }

    /**
     * column rarity ENUM value labels
     * @return string[]
     */
    public static function optsRarity()
    {
        return [
            self::RARITY_COMMON => 'common',
            self::RARITY_RARE => 'rare',
            self::RARITY_EPIC => 'epic',
            self::RARITY_LEGENDARY => 'legendary',
        ];
    }

    /**
     * @return string
     */
    public function displayCategory()
    {
        return self::optsCategory()[$this->category];
    }

    /**
     * @return bool
     */
    public function isCategoryTasks()
    {
        return $this->category === self::CATEGORY_TASKS;
    }

    public function setCategoryToTasks()
    {
        $this->category = self::CATEGORY_TASKS;
    }

    /**
     * @return bool
     */
    public function isCategoryHabits()
    {
        return $this->category === self::CATEGORY_HABITS;
    }

    public function setCategoryToHabits()
    {
        $this->category = self::CATEGORY_HABITS;
    }

    /**
     * @return bool
     */
    public function isCategoryQuests()
    {
        return $this->category === self::CATEGORY_QUESTS;
    }

    public function setCategoryToQuests()
    {
        $this->category = self::CATEGORY_QUESTS;
    }

    /**
     * @return bool
     */
    public function isCategorySocial()
    {
        return $this->category === self::CATEGORY_SOCIAL;
    }

    public function setCategoryToSocial()
    {
        $this->category = self::CATEGORY_SOCIAL;
    }

    /**
     * @return bool
     */
    public function isCategoryStats()
    {
        return $this->category === self::CATEGORY_STATS;
    }

    public function setCategoryToStats()
    {
        $this->category = self::CATEGORY_STATS;
    }

    /**
     * @return bool
     */
    public function isCategoryStreaks()
    {
        return $this->category === self::CATEGORY_STREAKS;
    }

    public function setCategoryToStreaks()
    {
        $this->category = self::CATEGORY_STREAKS;
    }

    /**
     * @return bool
     */
    public function isCategorySpecial()
    {
        return $this->category === self::CATEGORY_SPECIAL;
    }

    public function setCategoryToSpecial()
    {
        $this->category = self::CATEGORY_SPECIAL;
    }

    /**
     * @return string
     */
    public function displayRarity()
    {
        return self::optsRarity()[$this->rarity];
    }

    /**
     * @return bool
     */
    public function isRarityCommon()
    {
        return $this->rarity === self::RARITY_COMMON;
    }

    public function setRarityToCommon()
    {
        $this->rarity = self::RARITY_COMMON;
    }

    /**
     * @return bool
     */
    public function isRarityRare()
    {
        return $this->rarity === self::RARITY_RARE;
    }

    public function setRarityToRare()
    {
        $this->rarity = self::RARITY_RARE;
    }

    /**
     * @return bool
     */
    public function isRarityEpic()
    {
        return $this->rarity === self::RARITY_EPIC;
    }

    public function setRarityToEpic()
    {
        $this->rarity = self::RARITY_EPIC;
    }

    /**
     * @return bool
     */
    public function isRarityLegendary()
    {
        return $this->rarity === self::RARITY_LEGENDARY;
    }

    public function setRarityToLegendary()
    {
        $this->rarity = self::RARITY_LEGENDARY;
    }
}
