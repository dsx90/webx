<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.09.2018
 * Time: 2:07
 */

namespace backend\components;

use yii\base\Exception;

class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
    /**
     * @param string $category Категория. Должна иметь один из видов:
     * - moduleId.moduleVersion.categoryName
     * - moduleId.categoryName
     * - categoryName
     * @param string $language
     * @return string Путь к файлу
     * @throws Exception
     * @see \yii\i18n\PhpMessageSource::getMessageFilePath()
     */
    protected function getMessageFilePath($category, $language)
    {
        $categoryList = explode('.', $category);
        $bathPath = trim($this->basePath, '\\/');
        switch (count($categoryList)) {
            case 1:
                return $this->getFullFileName("@common/{$bathPath}/{$language}", $categoryList[0]);
                break;
            case 2:
                return $this->getFullFileName("@common/modules/{$categoryList[0]}/{$bathPath}/{$language}", $categoryList[1]);
                break;
            case 3:
                return $this->getFullFileName("@common/modules/{$categoryList[0]}/modules/{$categoryList[1]}/{$bathPath}/{$language}", $categoryList[2]);
                break;
            default :
                throw new Exception("Invalid category name: '{$category}.");
                break;
        }
    }

    private function getFullFileName($path, $category)
    {
        $path = \Yii::getAlias($path);
        return isset($this->fileMap[$category])
            ? $path . $this->fileMap[$category]
            : $path . '/'.str_replace('\\', '/', $category) . '.php';
    }
}