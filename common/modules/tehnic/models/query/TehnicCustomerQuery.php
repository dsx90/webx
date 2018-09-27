<?php

namespace common\modules\tehnic\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\tehnic\models\TehnicCustomer]].
 *
 * @see \common\modules\tehnic\models\TehnicCustomer
 */
class TehnicCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
