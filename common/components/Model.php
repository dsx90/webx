<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class Model extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param $modelClass
     * @param array $multipleModels
     * @param null $attribute
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [], $attribute = null)
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        if(!is_null($attribute) && isset($post[$attribute])) {
            $post = $post[$attribute];
        }
        $models   = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /**
     * @inheritdoc
     * @param array $models
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public static function loadMultiple($models, $data, $formName = null)
    {
        $success = false;
        foreach ($models as $i => $model) {
            /* @var $model Model */
            if (!empty($data[$i]) && $model->load($data[$i], '')) {
                $success = true;
            }
        }

        return $success;
    }
}