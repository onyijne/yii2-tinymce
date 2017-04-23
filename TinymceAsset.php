<?php
/**
 * @copyright Copyright (c) 2013-2017 Sajflow Services
 * @link https://www.sajflow.com
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace tecsin\tinymce;

use yii\web\AssetBundle;

class TinymceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/tinymce/tinymce';

    public function init()
    {
        parent::init();
        $this->js[] = YII_DEBUG ? 'tinymce.js' : 'tinymce.min.js';
    }
}