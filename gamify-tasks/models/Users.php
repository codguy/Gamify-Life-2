<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $avatar_url
 * @property string|null $timezone
 * @property int|null $level
 * @property int|null $total_xp
 * @property int|null $current_xp
 * @property int|null $xp_to_next_level
 * @property int|null $coins
 * @property int|null $gems
 * @property string|null $last_login_at
 * @property string|null $email_verified_at
 * @property int|null $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AchievementMetadata[] $achievementMetadatas
 * @property AchievementMetadata[] $achievements
 * @property Users[] $addressees
 * @property AuditLogs[] $auditLogs
 * @property AuditLogs[] $auditLogs0
 * @property BackupLogs[] $backupLogs
 * @property DailyStats[] $dailyStats
 * @property DailyStats[] $dailyStats0
 * @property FileUploads[] $fileUploads
 * @property FileUploads[] $fileUploads0
 * @property GoalLogs[] $goalLogs
 * @property GoalMetadata[] $goalMetadatas
 * @property GoalMetadata[] $goalMetadatas0
 * @property GoalMilestones[] $goalMilestones
 * @property HabitLogs[] $habitLogs
 * @property HabitMetadata[] $habitMetadatas
 * @property HabitMetadata[] $habitMetadatas0
 * @property HabitStreaks[] $habitStreaks
 * @property HabitStreaks[] $habitStreaks0
 * @property HabitMetadata[] $habits
 * @property JournalEntries[] $journalEntries
 * @property JournalEntries[] $journalEntries0
 * @property LeaderboardEntries[] $leaderboardEntries
 * @property LeaderboardEntries[] $leaderboardEntries0
 * @property LeaderboardPeriods[] $leaderboardPeriods
 * @property Notifications[] $notifications
 * @property Notifications[] $notifications0
 * @property LeaderboardPeriods[] $periods
 * @property QuestLogs[] $questLogs
 * @property QuestTemplates[] $questTemplates
 * @property Reminders[] $reminders
 * @property Reminders[] $reminders0
 * @property Users[] $requesters
 * @property ShopItems[] $shopItems
 * @property SocialActivities[] $socialActivities
 * @property SocialActivities[] $socialActivities0
 * @property SocialInteractions[] $socialInteractions
 * @property SocialInteractions[] $socialInteractions0
 * @property SystemSettings[] $systemSettings
 * @property TaskCategories[] $taskCategories
 * @property TaskLogs[] $taskLogs
 * @property TaskMetadata[] $taskMetadatas
 * @property TaskMetadata[] $taskMetadatas0
 * @property Themes[] $themes
 * @property UserAchievements[] $userAchievements
 * @property UserAchievements[] $userAchievements0
 * @property UserFriendships[] $userFriendships
 * @property UserFriendships[] $userFriendships0
 * @property UserFriendships[] $userFriendships1
 * @property UserPurchases[] $userPurchases
 * @property UserPurchases[] $userPurchases0
 * @property UserQuests[] $userQuests
 * @property UserQuests[] $userQuests0
 * @property UserSessions[] $userSessions
 * @property UserSessions[] $userSessions0
 * @property UserStats $userStats
 * @property UserStats[] $userStats0
 * @property UserThemes[] $userThemes
 * @property UserThemes[] $userThemes0
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'first_name', 'last_name', 'avatar_url', 'last_login_at', 'email_verified_at'], 'default', 'value' => null],
            [['timezone'], 'default', 'value' => 'UTC'],
            [['is_active'], 'default', 'value' => 1],
            [['gems'], 'default', 'value' => 0],
            [['xp_to_next_level'], 'default', 'value' => 100],
            [['username', 'email', 'password_hash'], 'required'],
            [['level', 'total_xp', 'current_xp', 'xp_to_next_level', 'coins', 'gems', 'is_active'], 'integer'],
            [['last_login_at', 'email_verified_at', 'created_at', 'updated_at'], 'safe'],
            [['username', 'timezone'], 'string', 'max' => 50],
            [['email', 'password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['avatar_url'], 'string', 'max' => 500],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'avatar_url' => 'Avatar Url',
            'timezone' => 'Timezone',
            'level' => 'Level',
            'total_xp' => 'Total Xp',
            'current_xp' => 'Current Xp',
            'xp_to_next_level' => 'Xp To Next Level',
            'coins' => 'Coins',
            'gems' => 'Gems',
            'last_login_at' => 'Last Login At',
            'email_verified_at' => 'Email Verified At',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AchievementMetadatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievementMetadatas()
    {
        return $this->hasMany(AchievementMetadata::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Achievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievements()
    {
        return $this->hasMany(AchievementMetadata::class, ['id' => 'achievement_id'])->viaTable('{{%user_achievements}}', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Addressees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressees()
    {
        return $this->hasMany(Users::class, ['id' => 'addressee_id'])->viaTable('{{%user_friendships}}', ['requester_id' => 'id']);
    }

    /**
     * Gets query for [[AuditLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditLogs()
    {
        return $this->hasMany(AuditLogs::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AuditLogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditLogs0()
    {
        return $this->hasMany(AuditLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[BackupLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBackupLogs()
    {
        return $this->hasMany(BackupLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[DailyStats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDailyStats()
    {
        return $this->hasMany(DailyStats::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[DailyStats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDailyStats0()
    {
        return $this->hasMany(DailyStats::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FileUploads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileUploads()
    {
        return $this->hasMany(FileUploads::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FileUploads0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileUploads0()
    {
        return $this->hasMany(FileUploads::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GoalLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalLogs()
    {
        return $this->hasMany(GoalLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GoalMetadatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalMetadatas()
    {
        return $this->hasMany(GoalMetadata::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[GoalMetadatas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalMetadatas0()
    {
        return $this->hasMany(GoalMetadata::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GoalMilestones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoalMilestones()
    {
        return $this->hasMany(GoalMilestones::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[HabitLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitLogs()
    {
        return $this->hasMany(HabitLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[HabitMetadatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitMetadatas()
    {
        return $this->hasMany(HabitMetadata::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[HabitMetadatas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitMetadatas0()
    {
        return $this->hasMany(HabitMetadata::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[HabitStreaks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitStreaks()
    {
        return $this->hasMany(HabitStreaks::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[HabitStreaks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabitStreaks0()
    {
        return $this->hasMany(HabitStreaks::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Habits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHabits()
    {
        return $this->hasMany(HabitMetadata::class, ['id' => 'habit_id'])->viaTable('{{%habit_streaks}}', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[JournalEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJournalEntries()
    {
        return $this->hasMany(JournalEntries::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[JournalEntries0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJournalEntries0()
    {
        return $this->hasMany(JournalEntries::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[LeaderboardEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaderboardEntries()
    {
        return $this->hasMany(LeaderboardEntries::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[LeaderboardEntries0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaderboardEntries0()
    {
        return $this->hasMany(LeaderboardEntries::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[LeaderboardPeriods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaderboardPeriods()
    {
        return $this->hasMany(LeaderboardPeriods::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications0()
    {
        return $this->hasMany(Notifications::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Periods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeriods()
    {
        return $this->hasMany(LeaderboardPeriods::class, ['id' => 'period_id'])->viaTable('{{%leaderboard_entries}}', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[QuestLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestLogs()
    {
        return $this->hasMany(QuestLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[QuestTemplates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestTemplates()
    {
        return $this->hasMany(QuestTemplates::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Reminders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminders()
    {
        return $this->hasMany(Reminders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reminders0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminders0()
    {
        return $this->hasMany(Reminders::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Requesters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequesters()
    {
        return $this->hasMany(Users::class, ['id' => 'requester_id'])->viaTable('{{%user_friendships}}', ['addressee_id' => 'id']);
    }

    /**
     * Gets query for [[ShopItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopItems()
    {
        return $this->hasMany(ShopItems::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SocialActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialActivities()
    {
        return $this->hasMany(SocialActivities::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[SocialActivities0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialActivities0()
    {
        return $this->hasMany(SocialActivities::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SocialInteractions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialInteractions()
    {
        return $this->hasMany(SocialInteractions::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[SocialInteractions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialInteractions0()
    {
        return $this->hasMany(SocialInteractions::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SystemSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystemSettings()
    {
        return $this->hasMany(SystemSettings::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[TaskCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCategories()
    {
        return $this->hasMany(TaskCategories::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[TaskLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskLogs()
    {
        return $this->hasMany(TaskLogs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[TaskMetadatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMetadatas()
    {
        return $this->hasMany(TaskMetadata::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TaskMetadatas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMetadatas0()
    {
        return $this->hasMany(TaskMetadata::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Themes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThemes()
    {
        return $this->hasMany(Themes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievements::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserAchievements0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements0()
    {
        return $this->hasMany(UserAchievements::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserFriendships]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFriendships()
    {
        return $this->hasMany(UserFriendships::class, ['requester_id' => 'id']);
    }

    /**
     * Gets query for [[UserFriendships0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFriendships0()
    {
        return $this->hasMany(UserFriendships::class, ['addressee_id' => 'id']);
    }

    /**
     * Gets query for [[UserFriendships1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFriendships1()
    {
        return $this->hasMany(UserFriendships::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserPurchases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPurchases()
    {
        return $this->hasMany(UserPurchases::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserPurchases0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPurchases0()
    {
        return $this->hasMany(UserPurchases::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserQuests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuests()
    {
        return $this->hasMany(UserQuests::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserQuests0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuests0()
    {
        return $this->hasMany(UserQuests::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSessions()
    {
        return $this->hasMany(UserSessions::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserSessions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSessions0()
    {
        return $this->hasMany(UserSessions::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserStats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserStats()
    {
        return $this->hasOne(UserStats::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserStats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserStats0()
    {
        return $this->hasMany(UserStats::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[UserThemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes()
    {
        return $this->hasMany(UserThemes::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserThemes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes0()
    {
        return $this->hasMany(UserThemes::class, ['created_by' => 'id']);
    }


    /**
     * Finds user by ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by Auth Key.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates authentication key.
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Generates authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates password.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Gets ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
}
