<?php

namespace common\widget\coreCase;

use dsx90\launcher\models\Launch;
use yii\base\Widget;

class Menu extends Widget
{

    public $parents = null;     //Список родителей, через запятую, для поиска результатов. Если поставить 0 - выборка не ограничивается. Если id родителя начинается с дефиса, он и его потомки исключаются из выборки.
    public $level;              //Уровень генерируемого меню.
    public $resources;          //Список ресурсов, через запятую, для вывода в результатах. Если id ресурса начинается с дефиса, этот ресурс исключается из выборки.
    public $templates;          //Список шаблонов, через запятую, для фильтрации результатов. Если id шаблона начинается с дефиса, ресурсы с ним исключается из выборки.
    public $showUnpublished = 1;//Показывать неопубликованные ресурсы.
    public $sortby;             //Любое поле ресурса для сортировки, включая ТВ параметр, если он указан в параметре &includeTVs, например {"tvname":"ASC", "pagetitle":"DESC"}. Можно указывать JSON строку с массивом нескольких полей. Для случайно сортировки укажите «RAND()»
    public $limit = 20;         //Ограничение количества результатов выборки. Можно использовать «0».
    //Шаблон
    public $tplOuter;           //Чанк обертка всего блока меню. По умолчанию: @INLINE <ul[[+classes]]>[[+wrapper]]</ul>
    public $tpl;                //Имя чанка для оформления ресурса. Если не указан, то содержимое полей ресурса будет распечатано на экран. По умолчанию: @INLINE <li[[+classes]]><a href="[[+link]]" [[+attributes]]>[[+menutitle]]</a>[[+wrapper]]</li>
    public $items;

    public $select = ['id', 'parent_id', 'title', 'slug'];
    //
    public $query;
    public $controller;
    public $id;//'id' => $launch->id

    public $link;
    public $menutitle;
    public $tplParentRow;
    public $debug = false;
    public $last = true;

//
    public function init()
    {
        parent::init();

        if( $this->tpl === null ){
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';

        $query = Launch::find()->asArray()->indexBy('id');
        if (isset($this->select)){
            $query->select($this->select);
        }
        if ($this->parents !== null) {
            $query->andFilterWhere(['parent_id' => $this->parents]);
        }
        if ($this->resources !== null) {
            $query->andFilterWhere(['id' => $this->resources]);
        }
        if ($this->showUnpublished !== null) {
            $query->andFilterWhere(['status' => $this->showUnpublished]);
        }
        if ($this->limit !==20){
            $query->limit($this->limit);
        }
        $this->query = $query->all();
    }

    protected function getMenuHtml($data){

        $str = '';
        foreach ($data as $item) {
            $placeholders = array('[[+slug]]', '[[+childs]]');
            $values = array(\yii\helpers\Url::to([$this->controller, 'slug' => $item['slug']]), $item['childs']);
            $output .= str_replace($placeholders, $values, $tpl);

            //$str .= $this->cat_tpl($item);
        }
        return $str;
    }

    //protected function cat_tpl($category) {
    //    ob_start();
    //    include __DIR__ . '/menu_tpl/' . $this->tpl;
    //    return ob_get_clean();
    //}

    public function run(){
        $map = getCase::mapTree($this->query, $this->last);
        if ($this->debug == false) {
            return $this->getMenuHtml($map);
        } else {
            return print_r(getCase::mapTree($this->query, $this->last));
            //return print_r($this->query);
        }
    }
}
//