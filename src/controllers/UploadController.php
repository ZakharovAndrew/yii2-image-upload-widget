<?php

namespace ZakharovAndrew\imageupload\controllers;

use ZakharovAndrew\imageupload\models\UploadImage;
use yii\web\Controller;
use yii\filters\VerbFilter;
use ZakharovAndrew\imageupload\Module;

class UploadController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'upload' => ['POST'],
                    ],
                ],
            ]
        );
    }
   
    public function actionUpload()
    {
        if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
            $module = \Yii::$app->getModule('imageupload');            
            echo json_encode(UploadImage::upload($module->uploadDir));
            die();
        }
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status'    => 'error',
            'message'   => Module::t('Please upload the file!')
        ];
    }
}
