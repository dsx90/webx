<?php

namespace common\modules\attribute\query;

/**
 * This is the ActiveQuery class for [[\common\modules\attribute\models\AttributeValue]].
 *
 * @see \common\modules\attribute\models\AttributeValue
 */
class AttributeValueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\models\AttributeValue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\attribute\models\AttributeValue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
