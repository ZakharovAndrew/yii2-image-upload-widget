<?php
/**
 * Yii2 Image Upload Widget
 * *************
 * Yii2 widget for loading images. That widget integrates multiple file selection, drag&drop support and preview of images.
 *  
 * @link https://github.com/ZakharovAndrew/yii2-image-upload-widget/
 * @copyright Copyright (c) 2024 Zakharov Andrew
 */
namespace ZakaharovAndrew\imageupload;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\web\View;
//use ZakaharovAndrew\imageupload\assets\WidgetAsset;

/**
 * Yii2 Upload Image Widget
 */
class UploadImageWidget extends InputWidget
{
   /**
     * Upload file to URL
     * @var string
     * @example
     * http://xxxxx/upload.php
     * ['images/upload']
     * ['upload']
     */
    public $url;
}
