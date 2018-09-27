<?php

namespace common\widget\Yandex;

use yii\base\Widget;

class YandexMetrikaApi extends Widget
{
    const TRAFFIC_SOURCE     = 'ym:s:<attribution>TrafficSource';
    const SOURCE_ENGINE      = 'ym:s:<attribution>SourceEngine';
    const ADV_ENGINE         = 'ym:s:<attribution>AdvEngine';
    const REFERAL_SOURCE     = 'ym:s:<attribution>ReferalSource';

    public static $ch_dimensions  = [
        self::TRAFFIC_SOURCE => 'Источник трафика',
        self::SOURCE_ENGINE  => 'Источник трафика (детально)',
        self::ADV_ENGINE     => 'Рекламная система',
        self::REFERAL_SOURCE => 'Переход с сайтов'
    ];

    public $yandex_id;
    public $oauth_token;

    public $direct_client_logins = 'dsx90@yandex.ru';
    public $ids;                        // Идентификаторы счетчиков, через запятую. Используется вместо параметра id.
    public $metrics;                    // Список метрик, разделенных запятой. Лимит: 20 метрик в запросе.
    //ym:s:visits                           - Суммарное количество визитов.
    //ym:s:pageviews                        - Число просмотров страниц на сайте за отчетный период.
    //ym:s:users                            - Количество уникальных посетителей.

    //ym:s:bounceRate                       - Отказы
    //ym:s:pageDepth                        - Глубина просмотра
    //ym:s:avgVisitDurationSeconds          - Время на сайте
    //ym:s:visitsPerDay                     - Визитов в день
    //ym:s:visitsPerHour                    - Визитов в час
    //ym:s:visitsPerMinute                  - Визитов в минуту
    //ym:s:robotPercentage                  - Роботность

    //

    public $accuracy;                   // Точность вычисления результата. Позволяет управлять семплированием (количеством визитов, использованных при расчете итогового значения).
    public $callback;                   // Функция обратного вызова, которая обрабатывает ответ API.
    public $date1;                      // Дата начала периода выборки в формате YYYY-MM-DD. Также используйте значения: today, yesterday, ndaysAgo. Значение по умолчанию: 6daysAgo
    public $date2;                      // Дата окончания периода выборки в формате YYYY-MM-DD. Также используйте значения: today, yesterday, ndaysAgo. Значение по умолчанию: today
    public $dimensions;                 // Список группировок, разделенных запятой. Лимит: 10 группировок в запросе.
    //ym:s:<attribution>TrafficSource       - Источник трафика
    //ym:s:<attribution>SourceEngine        - Источник трафика (детально)
    //ym:s:<attribution>AdvEngine           - Рекламная система
    //ym:s:<attribution>ReferalSource	    - Переход с сайтов

    //ym:s:<attribution>DirectClickOrder    - Кампания Яндекс.Директа
    //ym:s:<attribution>DirectBannerGroup   - Группа объявлений
    //ym:s:<attribution>DirectClickBanner   - Объявление Яндекс.Директа
    //ym:s:<attribution>DirectPhraseOrCond  - Условие показа объявления
    //ym:s:<attribution>DirectPlatformType  - Тип площадки
    //ym:s:<attribution>DirectPlatform      - Площадка
    //ym:s:<attribution>DirectSearchPhrase	- Поисковая фраза (Директ)

    //ym:s:<attribution>DirectConditionType - Тип условия показа объявления
    //ym:s:<attribution>CurrencyID          - Валюта
    //ym:s:<attribution>DisplayCampaign	    - Номер заказа Яндекс.Дисплея
    //ym:s:marketSearchPhrase               - Фраза (Маркет)
    //ym:s:<attribution>SearchEngineRoot    - Поисковая система
    //ym:s:<attribution>SearchEngine        - Поисковая система (детально)
    //ym:s:<attribution>SearchPhrase        - Поисковая фраза
    //ym:s:<attribution>SocialNetwork       - Cоциальная сеть
    //ym:s:<attribution>SocialNetworkProfile- Группа соц. сети
    public $group;
    public $filters;                    // Фильтр сегментации. attribute operator 'value' filters=ym:s:regionCityName=='Москва' Лимит: количество уникальных группировок и метрик — до 10, количество отдельных фильтров — до 20, длина строки в фильтре — до 10000 символов.
    //ym:s:trafficSource=='organic' AND ym:s:isNewUser=='Yes'
    public $include_undefined;          // Включает в ответ строки, для которых значения группировок не определены. Влияет только на первую группировку. По умолчанию выключено.
    public $lang = 'ru';                // Язык.
    public $limit;                      // Количество элементов на странице выдачи. Лимит: 100000. Значение по умолчанию: 100
    public $offset;                     // Индекс первой строки выборки, начиная с 1. Значение по умолчанию: 1
    public $preset;                     // Шаблон отчета.
    //sources_summary
    //sources_search_phrases
    //tech_platforms
    public $pretty = true;              // Задает форматирование результата. Чтобы использовать форматирование, укажите значение true. Значение по умолчанию: false
    public $proposed_accuracy;          // Если параметр выставлен в true, API имеет право автоматически увеличивать accuracy до рекомендованного значения.Когда идет запрос в маленькую таблицу с очень маленьким семплингом, параметр поможет получить осмысленные результаты.
    public $sort;                       // Список группировок и метрик, разделенных запятой, по которым осуществляется сортировка. По умолчанию сортировка производится по убыванию (указан знак «-» перед группировкой или метрикой).Чтобы отсортировать данные по возрастанию, удалите знак «-».
    public $timezone;                   // Часовой пояс в формате ±hh:mm в диапазоне [-23:59; +23:59] (знак плюса нужно нужно передавать как %2B), в котором будут расчитан период выборки запроса, а также связанные с датой и временем группировки. По умолчанию используется часовой пояс счетчика.

    public $data;                       // drilldown, pivot, drilldown, bytime, comparison
    public $result;
    private $metrika;
    private $error;
    private $api_url = 'https://api-metrika.yandex.ru/stat/v1/data';

    // Method
    // <тип_метода> https://api-metrika.yandex.ru/<раздел_API>/<версия>/<имя_метода>.<формат_результата>?<параметры>&<авторизационный_токен>

    public function init()
    {
        parent::init();
        if ($this->ids == null) {$this->error[] = 'ids';}
        if ($this->oauth_token == null) {$this->error[] = 'oauth_token';}

        if (empty($this->metrics)) {$this->metrics = ['ym:s:visits'];}
        if (empty($this->dimensions)) {$this->dimensions = ['ym:s:<attribution>TrafficSource'];}

        if (isset($this->date1)) $this->date1 = str_replace("-","",$this->date1);
        if (isset($this->date2)) $this->date2 = str_replace("-","",$this->date2);

        $data = array(
            'ids'                   => implode(',', $this->ids),
            'oauth_token'           => $this->oauth_token,
            'direct_client_logins'  => $this->direct_client_logins,
            'metrics'               => implode(',', $this->metrics),
            'accuracy'              => $this->accuracy,
            'callback'              => $this->callback,
            'date1'                 => $this->date1,
            'date2'                 => $this->date2,
            'dimensions'            => implode(',', $this->dimensions),
            'group'                 => $this->group,
            'filters'               => $this->filters,
            'include_undefined'     => $this->include_undefined,
            'lang'                  => $this->lang,
            'limit'                 => $this->limit,
            'offset'                => $this->offset,
            'preset'                => $this->preset,
            'pretty'                => $this->pretty,
            'proposed_accuracy'     => $this->proposed_accuracy,
            'sort'                  => $this->sort,
            'timezone'              => $this->timezone,
        );
        $parametrs = http_build_query($data, '', '&');

        $this->metrika = $this->api_url.$this->getModule($this->data).'?'.$parametrs;
        //$this->result = json_decode(file_get_contents($this->metrika));
        $this->result = $data;
    }

    public function getModule($data) {
        if(!isset($data)) {
            return false;
        } else {
            return '/'.$data;
        }
    }

    public function getTotals() {
        for ($i=0; $i <= $this->DateInterval(); $i++){
            if (isset($this->result->totals[1][$i])){
                $arr[] = "{ y: '{$this->result->time_intervals[$i][0]}', item1:{$this->result->totals[1][$i]}, item2:{$this->result->totals[0][$i]}}";
            }
        }
        return implode(','.PHP_EOL,$arr);
    }

    public function DateInterval(){
        $difference = intval(abs(
            strtotime($this->result->query->date1) - strtotime($this->result->query->date2)
        ));
        return $difference / (3600 * 24);
    }

    public function run(){
        if (isset($this->error)){
            $error = implode(', ',$this->error);
            return "Пустое значение <b>{$error}</b>";
        }

        //echo $this->render('list', [
        //    'model' => $this,
        //]);

        echo '<pre>';
        print_r($this->result);
        print_r($this->metrika);
        //echo $this->DateInterval();
        //echo $this->getTotals();
        echo '</pre>';

        //print_r($metrika->totals[1][1]);


        //if(isset($metrika->totals[1])){echo 'Общее количесво посещений '. $metrika->totals[1];};
        //echo 'C '.$this->result->query->date1;
        //echo ' - по '.$this->result->query->date2;
    }
}
