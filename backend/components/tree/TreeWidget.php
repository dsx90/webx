<?php
namespace backend\components\tree;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Отображение документов в виде дерева
 * Class TreeWidget
 * @package lowbase\document\components
 */
class TreeWidget extends Widget
{
    public $data = []; // маассив документов

    public function getIcon($resource)
    {
        if(isset($resource->icon)){
            return $resource->icon;
        }
        elseif(isset($resource->is_folder)){
            return 'glyphicon glyphicon-folder-open';
        }
        else {
            return 'glyphicon glyphicon-file';
        }
    }

    public function run()
    {
        $data = [];
        if ($this->data) {
            foreach ($this->data as $resource) {
                $data[] = [
                    'id' => $resource->id,
                    'text' => $resource->title . Html::tag('span', "($resource->id)", ['class' => 'hint']),
                    'parent' => ($resource->parent_id) ? $resource->parent_id : '#',
                    'icon' => $this->getIcon($resource)
                ];
            }
        }
        // Преобразуем в JSON
        $data = Json::encode($data, JSON_UNESCAPED_UNICODE);
        return $this->render('index', [
            'data' => $data
        ]);
    }
}
