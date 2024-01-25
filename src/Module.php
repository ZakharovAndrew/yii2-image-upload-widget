<?php

namespace ZakharovAndrew\imageupload;

use Yii;

/**
 * Модуль для SKLAD
 */
class Module extends \yii\base\Module
{
    /**
     * @var string path to the images directory
     */
    public $uploadDir = '';
    
    /**
     *
     * @var string source language for translation 
     */
    public $sourceLanguage = 'en-US';
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'ZakharovAndrew\imageupload\controllers';

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
    }
    
    //imageupload
    
        /**
     * Registers the translation files
     */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['extension/yii2-image-upload-widget/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => $this->sourceLanguage,
            'basePath' => '@vendor/zakharov-andrew/yii2-image-upload-widget/src/messages',
            'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
            'fileMap' => [
                'extension/yii2-image-upload-widget/imageupload' => 'imageupload.php',
            ],
        ];
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t
     *
     * @see Yii::t
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        $category = 'imageupload';
        return Yii::t('extension/yii2-image-upload-widget/' . $category, $message, $params, $language);
    }
}
