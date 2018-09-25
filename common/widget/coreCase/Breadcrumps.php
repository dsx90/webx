<?php

namespace common\widget\coreCase;

use common\models\Launch;
use yii\base\Widget;

class Breadcrumps extends Widget
{
    public $level;//Уровень генерируемого меню.
    public $resources;//Список ресурсов, через запятую, для вывода в результатах. Если id ресурса начинается с дефиса, этот ресурс исключается из выборки.
    public $templates;//Список шаблонов, через запятую, для фильтрации результатов. Если id шаблона начинается с дефиса, ресурсы с ним исключается из выборки.
    public $showUnpublished = 1;//Показывать неопубликованные ресурсы.
    public $sortby;//Любое поле ресурса для сортировки, включая ТВ параметр, если он указан в параметре &includeTVs, например {"tvname":"ASC", "pagetitle":"DESC"}. Можно указывать JSON строку с массивом нескольких полей. Для случайно сортировки укажите «RAND()»
    public $limit = false;//Ограничение количества результатов выборки. Можно использовать «0».
    //Шаблон
    public $tplOuter;//Чанк обертка всего блока меню. По умолчанию: @INLINE <ul[[+classes]]>[[+wrapper]]</ul>
    public $tpl;//Имя чанка для оформления ресурса. Если не указан, то содержимое полей ресурса будет распечатано на экран. По умолчанию: @INLINE <li[[+classes]]><a href="[[+link]]" [[+attributes]]>[[+menutitle]]</a>[[+wrapper]]</li>

    public $select = ['id', 'parent_id', 'title', 'slug'];
    //
    public $data;
    public $controller;
    public $id;//'id' => $launch->id

    public $link;
    public $menutitle;
    public $tplParentRow;

    public $breadcrumps_str;
    public $breadcrumps_array;

//
    public function init()
    {
        parent::init();

        $this->data = Launch::find()
            ->select($this->select)
            ->indexBy('id')
            ->where([
                //'id' => $this->parents,
                //'status' => $this->showUnpublished,
                //'id' => $this->resources,
            ])
            //->limit($this->limit)
            ->asArray()
            ->all();

        if(isset($this->id)){
            $id = (int)$this->id;
            $this->breadcrumps_array = $this->breadcrumps($this->data, $id);
        }
    }

    public function breadcrumps($array, $id){
        if(!$id) return false;

        $count = count($array);
        $breadcrumps_array = array();
        for ($i = 0; $i< $count; $i++){
            if (isset($array[$id])){
                $breadcrumps_array[$array[$id]['id']] = $array[$id]['title'];
                $id = $array[$id]['parent_id'];
            } else break;
        }
        return array_reverse($breadcrumps_array, true);
    }

    public function breadcrumpsOuter(){
        if ($this->breadcrumps_array){
            foreach ($this->breadcrumps_array as $id => $title) {
                $this->breadcrumps_str .= "<a href='{$id}'>{$title}</a> / ";
            }
        } else {
            $this->breadcrumps_str = "Каталог";
        }
        return $this->breadcrumps_str;
    }


    public function run(){


        return $this->breadcrumpsOuter();
    }
}
