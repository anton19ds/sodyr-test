<?php

namespace app\modules\panel\controllers;

use yii\web\Controller;

/**
 * Default controller for the `panel` module
 */
class DefaultController extends MainController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
