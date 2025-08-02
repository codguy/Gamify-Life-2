<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_purchases".
 *
 * @property int $id
 * @property int $user_id
 * @property int $shop_item_id
 * @property int|null $purchase_price_coins
 * @property int|null $purchase_price_gems
 * @property int|null $is_active
 * @property string|null $expires_at
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property ShopItems $shopItem
 * @property Users $user
 */
class UserPurchases extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expires_at'], 'default', 'value' => null],
            [['purchase_price_gems'], 'default', 'value' => 0],
            [['is_active'], 'default', 'value' => 1],
            [['user_id', 'shop_item_id', 'created_by'], 'required'],
            [['user_id', 'shop_item_id', 'purchase_price_coins', 'purchase_price_gems', 'is_active', 'created_by'], 'integer'],
            [['expires_at', 'created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['shop_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopItems::class, 'targetAttribute' => ['shop_item_id' => 'id']],
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
            'shop_item_id' => 'Shop Item ID',
            'purchase_price_coins' => 'Purchase Price Coins',
            'purchase_price_gems' => 'Purchase Price Gems',
            'is_active' => 'Is Active',
            'expires_at' => 'Expires At',
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
     * Gets query for [[ShopItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopItem()
    {
        return $this->hasOne(ShopItems::class, ['id' => 'shop_item_id']);
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
