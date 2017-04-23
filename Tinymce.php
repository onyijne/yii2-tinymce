<?php
/**
 * @copyright Copyright (c) 2013-2017 Sajflow Services
 * @link https://www.sajflow.com
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace tecsin\tinymce;

use yii\helpers\Html;
use yii\helpers\Json;
use dosamigos\tinymce\TinyMce;

/**
 *
 * TinyMCE js plugin for WYSIWYG editing with elFinder file picker support
 *
 * @author Samuel Onyijne <samuel@sajflow.com>
 * @link https://www.sajflow.com/samuel
 * @link https://www.sajflow.com
 */
class Tinymce extends TinyMce
{
    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language;
    /**
     * @var array the client options for TinyMCE JS plugin.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];
    
   /**
     * @var string file an absolute path to elfinder url. Default is /admin/upload
     */
    public $file = '';
    /**
     * @var string title the title of the pop up window. Default is file manager
     */
    public $title = '';
    /**
     * @var integer width the default width of the file browser window. Default is 700
     */
    public $width ='';
    /**
     * @var integer height the default height of the file browser window. Default is 350
     */
    public $height = '';
    /**
     * @var integer resizable if the file browser window should be resizable. Default is yes
     */
    public $resizable = '';
    
    /**
     * @var bool whether to set the on change event for the editor. This is required to be able to validate data.
     * @see https://github.com/2amigos/yii2-tinymce-widget/issues/7
     */
    public $triggerSaveOnBeforeValidateForm = true;
    
     public function init() {
        parent::init();
        if(empty($this->file)){
            $this->file = '/admin/upload';
        }
        if(empty($this->title)){
            $this->title = 'File Manager';
        }
        if(empty($this->width)){
            $this->width = 700;
        }
        if(empty($this->height)){
            $this->height = 350;
        }
        if(empty($this->resizable)){
            $this->resizable = 'yes';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerPlugin();
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerPlugin()
    {
        $view = $this->getView();
        TinymceAsset::register($view);
        $id = (isset($this->options['id'])) ? $this->options['id'] : $this->getId();        
        $this->clientOptions['file_picker_types'] = 'file image media';
        $this->clientOptions['selector'] = "#$id";
        $this->assignLanguageFile($view);       
        $js = array_reverse($this->clientOptions);
        $options = Json::encode($js);
        $this->js($options, "#$id");
    }
    
    protected function assignLanguageFile($view) {
         if ($this->language !== null) {
            $langFile = "langs/{$this->language}.js";
            $langAssetBundle = TinymceLangAsset::register($view);
            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }
    }
    
    public function js($options, $id){
        $view = $this->getView();
        $js = <<< JS
        let opt = {$options};
        opt['file_picker_callback'] = elfinderFilePicker;
        tinymce.init(opt);
        function elfinderFilePicker (callback, value, meta) {
            tinymce.activeEditor.windowManager.open({
                file: '$this->file',
                title: '$this->title',
                width: $this->width,  
                height: $this->height,
                resizable: '$this->resizable'
            }, {
                oninsert: function (file, elf) {
                var url, reg, info;

               // URL normalization
               url = file.url;
               reg = /\/[^/]+?\/\.\.\//;
               while(url.match(reg)) {
               url = url.replace(reg, '/');
        }

          // Make file info
          info = file.name + ' (' + elf.formatSize(file.size) + ')';

          // Provide file and text for the link dialog
          if (meta.filetype == 'file') {
              callback(url, {text: info, title: info});
          }

          // Provide image and alt text for the image dialog
         if (meta.filetype == 'image') {
             callback(url, {alt: info});
         }

      // Provide alternative source and posted for the media dialog
      if (meta.filetype == 'media') {
        callback(url);
      }
    }
  });
  return false;
} 
     if ($this->triggerSaveOnBeforeValidateForm) {
            $('$id').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });
        }
             
  
                
JS;
      $view->registerJs($js);
    }
}
