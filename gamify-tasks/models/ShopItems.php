<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shop_items}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $item_type
 * @property string|null $category
 * @property string|null $icon
 * @property int|null $price_coins
 * @property int|null $price_gems
 * @property string|null $rarity
 * @property string|null $item_effects
 * @property int|null $duration_hours For temporary items
 * @property int|null $is_active
 * @property int|null $is_limited_time
 * @property string|null $available_from
 * @property string|null $available_until
 * @property int|null $max_purchases_per_user
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property UserPurchases[] $userPurchases
 */
class ShopItems extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ITEM_TYPE_POWERUP = 'powerup';
    const ITEM_TYPE_THEME = 'theme';
    const ITEM_TYPE_REWARD = 'reward';
    const ITEM_TYPE_PREMIUM = 'premium';
    const ITEM_TYPE_CONSUMABLE = 'consumable';
    const RARITY_COMMON = 'common';
    const RARITY_RARE = 'rare';
    const RARITY_EPIC = 'epic';
    const RARITY_LEGENDARY = 'legendary';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_items}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'category', 'item_effects', 'duration_hours', 'available_from', 'available_until', 'max_purchases_per_user'], 'default', 'value' => null],
            [['item_type'], 'default', 'value' => 'powerup'],
            [['icon'], 'default', 'value' => 'fas fa-shopping-cart'],
            [['is_limited_time'], 'default', 'value' => 0],
            [['rarity'], 'default', 'value' => 'common'],
            [['is_active'], 'default', 'value' => 1],
            [['name', 'created_by'], 'required'],
            [['description', 'item_type', 'rarity'], 'string'],
            [['price_coins', 'price_gems', 'duration_hours', 'is_active', 'is_limited_time', 'max_purchases_per_user', 'created_by'], 'integer'],
            [['item_effects', 'available_from', 'available_until', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            ['item_type', 'in', 'range' => array_keys(self::optsItemType())],
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
            'item_type' => 'Item Type',
            'category' => 'Category',
            'icon' => 'Icon',
            'price_coins' => 'Price Coins',
            'price_gems' => 'Price Gems',
            'rarity' => 'Rarity',
            'item_effects' => 'Item Effects',
            'duration_hours' => 'Duration Hours',
            'is_active' => 'Is Active',
            'is_limited_time' => 'Is Limited Time',
            'available_from' => 'Available From',
            'available_until' => 'Available Until',
            'max_purchases_per_user' => 'Max Purchases Per User',
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
     * Gets query for [[UserPurchases]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPurchases()
    {
        return $this->hasMany(UserPurchases::class, ['shop_item_id' => 'id']);
    }


    /**
     * column item_type ENUM value labels
     * @return string[]
     */
    public static function optsItemType()
    {
        return [
            self::ITEM_TYPE_POWERUP => 'powerup',
            self::ITEM_TYPE_THEME => 'theme',
            self::ITEM_TYPE_REWARD => 'reward',
            self::ITEM_TYPE_PREMIUM => 'premium',
            self::ITEM_TYPE_CONSUMABLE => 'consumable',
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
    public function displayItemType()
    {
        return self::optsItemType()[$this->item_type];
    }

    /**
     * @return bool
     */
    public function isItemTypePowerup()
    {
        return $this->item_type === self::ITEM_TYPE_POWERUP;
    }

    public function setItemTypeToPowerup()
    {
        $this->item_type = self::ITEM_TYPE_POWERUP;
    }

    /**
     * @return bool
     */
    public function isItemTypeTheme()
    {
        return $this->item_type === self::ITEM_TYPE_THEME;
    }

    public function setItemTypeToTheme()
    {
        $this->item_type = self::ITEM_TYPE_THEME;
    }

    /**
     * @return bool
     */
    public function isItemTypeReward()
    {
        return $this->item_type === self::ITEM_TYPE_REWARD;
    }

    public function setItemTypeToReward()
    {
        $this->item_type = self::ITEM_TYPE_REWARD;
    }

    /**
     * @return bool
     */
    public function isItemTypePremium()
    {
        return $this->item_type === self::ITEM_TYPE_PREMIUM;
    }

    public function setItemTypeToPremium()
    {
        $this->item_type = self::ITEM_TYPE_PREMIUM;
    }

    /**
     * @return bool
     */
    public function isItemTypeConsumable()
    {
        return $this->item_type === self::ITEM_TYPE_CONSUMABLE;
    }

    public function setItemTypeToConsumable()
    {
        $this->item_type = self::ITEM_TYPE_CONSUMABLE;
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
