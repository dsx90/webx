<?php
namespace common\models;

use Yii;

/**
 * Шаблоны документов
 * Используются для применения макетов
 * отображения данных, а также закрепления
 * за документом дополнительных полей
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $path
 *
 */
class Template extends \yii\db\ActiveRecord
{
    public $code;

    const SHOW_TEMPLATE = 0;
    const SHOW_PARTIAL = 1;

    /**
     * Способ вывода шаблона
     * @return array
     */
    public static function getDisplayArray()
    {
        return [
            self::SHOW_TEMPLATE => Yii::t('backend', 'Show Template'),
            self::SHOW_PARTIAL  => Yii::t('backend', 'Show Partial'),
        ];
    }

    /**
     * Наименование таблицы
     * @return string
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * Правила валидации
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'], // Обязательно для заполнения
            [['title'], 'unique'],   // Уникальное значение
            [['description'], 'string'],    // Текстовое поле
            [['path'], 'pathValidate', 'skipOnEmpty' => false], // Проверка на существование файла шаблона
            [['title', 'path'], 'string', 'max' => 255], // Строковое значение (максимум 255 символов)
            [['title', 'description', 'path'], 'filter', 'filter' => 'trim'],    // Обрезаем строки по краям
            [['path', 'description'], 'default', 'value' => null],  // По умолчанию = null
            ['code', 'safe'],
            ['display', 'integer']
        ];
    }

    /**
     * Наименование полей аттрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('backend', 'ID'),
            'title'         => Yii::t('backend', 'Title'),
            'description'   => Yii::t('backend', 'Description'),
            'path'          => Yii::t('backend', 'Path'),
            'display'       => Yii::t('backend', 'Display'),
            'code'          => '',
        ];
    }

    /**
     * Документы с текущим шаблоном
     * @return \yii\db\ActiveQuery
     */
    public function getLaunch()
    {
        return $this->hasMany(Launch::class, ['template_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->openFile();
            return true;
        }
        return false;
    }

    public function openFile(){
        $file = fopen(Yii::getAlias('@template').'/'.$this->title.'.tpl', "w+");
        fwrite($file, $this->code);
        fclose($file);
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->loadFile();
    }

    public function loadFile(){
        $this->code = file_get_contents(Yii::getAlias('@template').'/'.$this->title.'.tpl');
    }

    /**
     * Проверка на существование файла
     */
    public function pathValidate()
    {
        // Определяем расширение файла
        $ext = substr($this->path, -4);
        $file = ($ext === '.tpl') ? $this->path : $this->path.'.tpl';
        if ($this->path && !file_exists(Yii::getAlias($file))) {
            // Выводим ошибку если файл не найден
            $this->addError('path', Yii::t('document', 'Файл шаблона не найден.'));
        }
    }

    /**
     * Список шаблонов массивом
     * @return array
     */
    public static function getAll()
    {
        $type = [];
        if ($model = self::find()->orderBy(['title' => SORT_ASC])->all()) {
            foreach ($model as $m) {
                $type[$m->id] = $m->title;
            }
        }

        return $type;
    }
}
