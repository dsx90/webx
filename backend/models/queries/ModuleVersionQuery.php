<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:52
 */
namespace backend\models\queries;

use yii\db\ActiveQuery;

class ModuleVersionQuery extends ActiveQuery
{
    /**
     * @param string|array $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}