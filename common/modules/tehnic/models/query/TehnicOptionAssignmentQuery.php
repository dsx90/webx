<?php

namespace common\modules\tehnic\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\tehnic\models\TehnicOptionAssignment]].
 *
 * @see \common\modules\tehnic\models\TehnicOptionAssignment
 */
class TehnicOptionAssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicOptionAssignment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicOptionAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
