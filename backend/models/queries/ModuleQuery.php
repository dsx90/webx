<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 1:55
 */

namespace backend\models\queries;

use yii\db\ActiveQuery;
use backend\models\Module;
/**
 * @method Module[] each($batchSize = 100, $db = null)
 * @method Module[] all($db = null)
 * @method Module one($db = null)
 * @method Module oneOrException($db = null, $exceptionMessage = null)
 */
class ModuleQuery extends ActiveQuery
{
    /**
     * @param bool $isActive = true
     * @return $this
     */
    public function active($isActive = true)
    {
        return $isActive
            ? $this->andWhere('version_id is not null')
            : $this->andWhere('version_id is null');
    }
    /**
     * @param string|array $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}