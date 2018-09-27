<?php

namespace common\modules\tehnic\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\tehnic\models\TehnicOption]].
 *
 * @see \common\modules\tehnic\models\TehnicOption
 */
class TehnicOptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicOption[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\TehnicOption|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
