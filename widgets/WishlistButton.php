<?php
namespace halumein\wishlist\widgets;

use yii\helpers\Html;
use halumein\wishlist\models\Wishlist;
use yii\helpers\Url;
use yii;

class WishlistButton extends \yii\base\Widget
{
    public $anchorActive = NULL;
    public $anchorUnactive = NULL;
    public $model = NULL;
    public $cssClass = NULL;
    public $cssClassInList = NULL;
    public $htmlTag = 'div';

    public function init()
    {
        parent::init();

        \halumein\wishlist\assets\WidgetAsset::register($this->getView());

        if ($this->anchorActive === NULL) {
            $this->anchorActive = 'В избранном';
        }

        if ($this->anchorUnactive === NULL) {
            $this->anchorUnactive = 'В избранное';
        }

        $anchor = ['active' => $this->anchorActive, 'unactive' => $this->anchorUnactive];

        if ($this->cssClass === NULL) {
            $this->cssClass = 'hal-wishlist-button';
        }

        if ($this->cssClassInList === NULL) {
            $this->cssClassInList = 'in-list';
        }

        $this->getView()->registerJs("wishlist.anchor = ".json_encode($anchor));

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
        $text = $this->anchorUnactive;

        $elementModel = Wishlist::find()->where([
            'user_id' => \Yii::$app->user->getId(),
            'model' => $model::className(),
            'item_id' => $model->id,
            ])->one();

        if ($elementModel) {
            $text = $this->anchorActive;
            $this->cssClass .= ' '.$this->cssClassInList;
            $action = 'remove';
            $url = '/wishlist/element/remove';
        }

        return Html::tag($this->htmlTag, $text, [
            'class' => $this->cssClass,
            'data-role' => 'hal_wishlist_button',
            'data-url' => Url::toRoute($url),
            'data-action' => $action,
            'data-in-list-css-class' => $this->cssClassInList,
            'data-item-id' => $model->id,
            'data-model' => $model::className()
        ]);
    }
}
