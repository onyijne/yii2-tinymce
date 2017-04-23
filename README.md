Yii2 TinyMCE
============
TinyMCE extension for Yii2, with elFinder as its file picker features.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tecsin/yii2-tinymce "*"
```

or add

```
"tecsin/yii2-tinymce": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

tinyMCE WYSIWYG Editor  :
-----
with model


```php
    /**
     * @var array clientOptions The client options for TinyMCE JS plugin.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
<?= $form->field($model, 'content')->widget(\tecsin\tinymce\Tinymce::className(), [
    'options' => ['rows' => 6],
    'language' => 'en_GB',
    'clientOptions' => [
        'plugins' => [
            "image imagetools  lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons "
    ],
/*elfinder options*/
'file'  => '/admin/file-browser',//relative or absolute url
'title' => 'file browser',
'width' => 750,
'height' => 350,
'resizable' => 'yes'
]);?>
```

without model


```php
    
   /**
     * @var array clientOptions The client options for TinyMCE JS plugin.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
<?= \tecsin\tinymce\Tinymce::widget([
    'options' => ['rows' => 6],
    'language' => 'en_GB',
    'clientOptions' => [
        'plugins' => [
            "image imagetools  lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        'toolbar' => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons "
    ]
]); ?>
```

Contributions are welcome either by bug reporting or in coding more features.