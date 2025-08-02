<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%themes}}".
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property string|null $css_variables Theme color variables
 * @property int|null $is_premium
 * @property int|null $price_coins
 * @property int|null $price_gems
 * @property int|null $is_active
 * @property string|null $preview_image_url
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property UserThemes[] $userThemes
 */
class Themes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%themes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'css_variables', 'preview_image_url'], 'default', 'value' => null],
            [['price_gems'], 'default', 'value' => 0],
            [['is_active'], 'default', 'value' => 1],
            [['name', 'display_name', 'created_by'], 'required'],
            [['description'], 'string'],
            [['css_variables', 'created_at', 'updated_at'], 'safe'],
            [['is_premium', 'price_coins', 'price_gems', 'is_active', 'created_by'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 100],
            [['preview_image_url'], 'string', 'max' => 500],
            [['name'], 'unique'],
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
            'display_name' => 'Display Name',
            'description' => 'Description',
            'css_variables' => 'Css Variables',
            'is_premium' => 'Is Premium',
            'price_coins' => 'Price Coins',
            'price_gems' => 'Price Gems',
            'is_active' => 'Is Active',
            'preview_image_url' => 'Preview Image Url',
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
     * Gets query for [[UserThemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserThemes()
    {
        return $this->hasMany(UserThemes::class, ['theme_id' => 'id']);
    }

}
