<?php
/**
 * Yii2 Image Upload Widget
 * *************
 * Yii2 widget for loading images. That widget integrates multiple file selection, drag&drop support and preview of images.
 *  
 * @link https://github.com/ZakharovAndrew/yii2-image-upload-widget/
 * @copyright Copyright (c) 2024 Zakharov Andrew
 */
namespace ZakharovAndrew\imageupload;

use Yii;
use yii\widgets\InputWidget;
use yii\web\View;
use yii\helpers\Html;
use ZakharovAndrew\imageupload\assets\WidgetAsset;

/**
 * Yii2 Upload Image Widget
 */
class ImageUploadWidget extends InputWidget
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
    
    public $form;
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (empty($this->url)) {
            throw new InvalidConfigException('Url must be set');
        }
        
        //register Assets
        WidgetAsset::register($this->view);

        parent::init();
    }
    
    public function run()
    {
        $params = array_merge($this->options, ['id' => 'product-images']);
        $input = $this->form->field($this->model, $this->attribute)->hiddenInput($params)->label(false);
        
        return $this->render('field', [
            'model' => $this->model,
            'name' => $this->attribute,
            'input' => $input ?? ''
        ]);
    }
    
    public static function afterForm()
    {
        return \Yii::$app->view->render('@ZakharovAndrew/imageupload/views/afterForm');
        
    }
}
