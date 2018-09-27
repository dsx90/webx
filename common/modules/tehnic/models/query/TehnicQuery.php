<?php

namespace common\modules\tehnic\models\query;

use common\models\Launch;
use common\modules\tehnic\models\Tehnic;

/**
 * This is the ActiveQuery class for [[\common\modules\tehnic\models\Tehnic]].
 *
 * @see \common\modules\tehnic\models\Tehnic
 */
class TehnicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\Tehnic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\tehnic\models\Tehnic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function published()
    {
        $this->andWhere(['{{%launch}}.status' => Launch::STATUS_ACTIVE]);
        $this->andWhere(['<', '{{%launch}}.published_at', time()]);

        return $this;
    }
}
