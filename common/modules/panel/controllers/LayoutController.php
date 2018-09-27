<?php

namespace common\modules\panel\controllers;

use common\components\dispatcher\Controller;

/**
 * Default controller for the `test` module
 */
class LayoutController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ViewNotFoundException
     * @throws \yii\base\InvalidCallException
     */
    public function index()
    {
        return $this->render('index');
    }
}
