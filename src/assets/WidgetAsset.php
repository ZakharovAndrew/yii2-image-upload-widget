<?php

namespace ZakharovAndrew\imageupload\assets;

use yii\web\AssetBundle;

/**
 * Assets for widget
 * @author Zakharov Andrew <https://github.com/ZakharovAndrew>
 */
class WidgetAsset extends AssetBundle
{
    public $sourcePath = '@ZakharovAndrew/imageupload/assets';
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    
    public function init()
    {
        $this->css = ['css/photo.css'];
        $this->js = [
            'js/load-image.all.min.js',
            'js/compress.js',
            'js/exif-heic.js',
            'js/jquery.knob.js'
        ];
        parent::init();
    }
}