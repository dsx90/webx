<?php

namespace common\modules\shop\queries;

/**
 * This is the ActiveQuery class for [[\common\modules\shop\models\Product]].
 *
 * @see \common\modules\shop\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\shop\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\shop\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
