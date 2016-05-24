<?php

namespace halumein\wishlist\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use halumein\wishlist\models\Wishlist;
use yii\helpers\Url;


/**
 * Default controller for the `wishlist` module
 */
class ElementController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        $wishlistModel = new Wishlist();

        $postData = \Yii::$app->request->post();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // небольшая проверка на случай если уже добавлен из модального окна или на другой вкладке
        $checkModel = Wishlist::find()->where([
            'user_id' => \Yii::$app->user->getId(),
            'model' => $postData['model'],
            'item_id' => $postData['itemId'],
            ])->one();

        if ($checkModel) {
            return [
                'response' => true,
                'url' => Url::toRoute('/wishlist/element/remove'),
            ];
        }

        $wishlistModel->user_id = \Yii::$app->user->getId();
        $wishlistModel->model = $postData['model'];
        $wishlistModel->item_id = $postData['itemId'];

        if ($wishlistModel->save()) {
            return [
                'response' => true,
                'url' => Url::toRoute('/wishlist/element/remove'),
            ];
        }

        return [
            'response' => false
        ];

    }

    public function actionRemove()
    {
        $postData = \Yii::$app->request->post();

        $elementModel = Wishlist::find()->where([
            'user_id' => \Yii::$app->user->getId(),
            'model' => $postData['model'],
            'item_id' => $postData['itemId'],
            ])->one();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // небольшая проверка на случай если уже удалено из модального окна или на другой вкладке
        if ($elementModel) {
            if ($elementModel->delete()) {
                return [
                    'response' => true,
                    'url' => Url::toRoute('/wishlist/element/add'),
                ];
            }
        } else {
            return [
                'response' => true,
                'url' => Url::toRoute('/wishlist/element/add'),
            ];
        }

        return [
            'response' => false
        ];
    }

}
