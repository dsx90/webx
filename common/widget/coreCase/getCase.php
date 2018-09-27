<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28.12.2017
 * Time: 0:53
 */

namespace common\widget\coreCase;


use yii\base\Widget;

class getCase
{
    public static function mapTree($data){
        $tree = [];
        foreach ($data as $id => &$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }
}