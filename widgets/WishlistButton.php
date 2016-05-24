<?php
namespace halumein\wishlist\widgets;

use yii\helpers\Html;
use halumein\wishlist\models\Wishlist;
use yii\helpers\Url;
use yii;

class WishlistButton extends \yii\base\Widget
{
    public $text = NULL;
    public $model = NULL;
    public $cssClass = NULL;
    public $cssClassInList = NULL;
    public $htmlTag = 'div';

    public function init()
    {
        parent::init();

        \halumein\wishlist\assets\WidgetAsset::register($this->getView());

        if ($this->text === NULL) {
            $this->text = 'В избранное';
        }

        if ($this->cssClass === NULL) {
            $this->cssClass = 'hal-wishlist-button';
        }

        if ($this->cssClassInList === NULL) {
            $this->cssClassInList = 'in-list';
        }

        return true;
    }

    public function run()
    {
        if (!is_object($this->model)) {
            return false;
        }

        $action = 'add';
        $url = '/wishlist/element/add';
        $model = $this->model;

        $elementModel = Wishlist::find()->where([
            'user_id' => \Yii::$app->user->getId(),
            'model' => $model::className(),
            'item_id' => $model->id,
            ])->one();

        if ($elementModel) {
            $this->text = 'В избранном';
            $this->cssClass .= ' '.$this->cssClassInList;
            $action = 'remove';
            $url = '/wishlist/element/remove';
        }

        return Html::tag($this->htmlTag, $this->text, [
            'class' => $this->cssClass,
            'data-role' => 'hal_wishlist_button',
            'data-url' => Url::toRoute($url),
            'data-action' => $action,
            'data-item-id' => $model->id,
            'data-model' => $model::className()
        ]);
    }
}
