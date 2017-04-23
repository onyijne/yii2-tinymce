<?php
/**
 * @copyright Copyright (c) 2013-2017 Sajflow Services
 * @link https://www.sajflow.com
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace tecsin\tinymce;

use yii\web\AssetBundle;

class TinymceLangAsset extends AssetBundle
{
    public $sourcePath = '@vendor/2amigos/yii2-tinymce-widget/src/assets';

    public $depends = [
        'tecsin\tinymce\TinymceAsset'
    ];
}
