<?php

namespace halumein\wishlist\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use halumein\wishlist\models\Wishlist;



/**
 * Default controller for the `wishlist` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
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

        $list = Wishlist::find()->where([
            'user_id' => \Yii::$app->user->getId(),
            ])->all();

        return $this->render('index', [
            'list' => $list
        ]);
    }

}
