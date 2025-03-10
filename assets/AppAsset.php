<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/scheme/dark.css',
        'css/site.css',
        'css/jsCalendar.css',
        'https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.5/themes/jsCalendar.darkseries.min.css',
    ];
    public $js = [
        'js/ajax.js',
        'js/moment.js',
        'https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.5/source/jsCalendar.min.js',
        'https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.5/source/jsCalendar.lang.ru.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset'
    ];
}
