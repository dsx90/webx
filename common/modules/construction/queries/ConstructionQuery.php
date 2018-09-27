<?php

namespace common\modules\construction\queries;

/**
 * This is the ActiveQuery class for [[\common\modules\construction\models\Construction]].
 *
 * @see \common\modules\construction\models\Construction
 */
class ConstructionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\construction\models\Construction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\construction\models\Construction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
