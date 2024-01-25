<?php

namespace ZakharovAndrew\imageupload\models;

use Yii;
use \yii\helpers\ArrayHelper;
use ZakharovAndrew\imageupload\Module;


class UploadImage
{
    // A list of permitted file extensions
    const ALLOWED = ['png', 'jpg'];
    
    const MAX_SIZE = [
        'mini'      => 233,
        'medium'    => 510,
        'big'       => 1000
    ];
     
    public static function upload($dir_name)
    {
        $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if (!in_array(strtolower($extension), static::ALLOWED)) {
            return [
                'status' => 'error',
                'message' => Module::t('Wrong format')
            ];
	}

        $filename = md5(date("Y-m-d H:i:s").$_FILES['upl']['name']);       
        
        static::imageResize(
            $_FILES['upl']['tmp_name'],
            $_FILES['upl']['type'],
            $dir_name.$filename
        );
        
        $format = '';
        if ($_FILES['upl']['type']=='image/jpeg') {
            $format = '.jpg';
        } else if ($_FILES['upl']['type']=='image/png') {
            $format = '.png';
        } else {
            move_uploaded_file($_FILES['upl']['tmp_name'], $dir_name.$_FILES['upl']['name'].str_replace('/','_',$_FILES['upl']['type']));
            $format = '.'.$extension;
        }
        
        return [
            'status' => 'success',
            'filename_medium' => $filename . '_img_medium' . $format,
            'filename' => $filename
        ];
    }
    
    /**
     * Image re-size
     * @param int $width
     * @param int $height
     */
    public static function imageResize($filename, $filetype, $img_name)
    {
        /* Get original file size */
        list($w, $h) = getimagesize($filename);        
        
        /* set new file name */
        $path = $img_name;

        /* set image size */
        $size = [];
        $size['img_big']    = ($w < static::MAX_SIZE['big'] && $h < static::MAX_SIZE['big']) ? ['w' => $w, 'h' => $h] : static::getSize($w, $h, static::MAX_SIZE['big']);
        $size['img_medium'] = static::getSize($w, $h, static::MAX_SIZE['medium']);
        $size['img_mini']   = static::getSize($w, $h, static::MAX_SIZE['mini'], false);


        /* Save image */
        if($filetype == 'image/jpeg')
        {
            /* Get binary data from image */
            $imgString = file_get_contents($filename);
            /* create image from string */
            $image = imagecreatefromstring($imgString);
            
            // create new images
            foreach ($size as $key => $value) {
                $tmp = imagecreatetruecolor($value['w'], $value['h']);
                imagecopyresampled($tmp, $image, 0, 0, 0, 0, $value['w'], $value['h'], $w, $h);
                imagejpeg($tmp, $path.'_'.$key.'.jpg', 80);
                imagedestroy($tmp);
            }
        } else if($filetype == 'image/png') {
            $image = imagecreatefrompng($filename);
            foreach ($size as $key => $value) {
                $tmp = imagecreatetruecolor($value['w'], $value['h']);
                imagealphablending($tmp, false);
                imagesavealpha($tmp, true);
                imagecopyresampled($tmp, $image,0,0,0,0,$value['w'],$value['h'],$w, $h);
                imagepng($tmp, $path, 0);
                imagedestroy($tmp);
            }
        } else {
            return false;
        }
        
        imagedestroy($image);
        imagedestroy($tmp);
        return true;
    }
    
    
    public static function getSize($w, $h, $size, $maxsize = true)
    {
        if ($w > $h && $maxsize) {
            $ratio = $size/$w;
        } else {
            $ratio = $size/$h;
        }

        // fixed size in width
        if (!$maxsize && ceil($ratio * $w) < static::MAX_SIZE['mini']) {
            $ratio =  static::MAX_SIZE['mini']/$w;
        }

        return [
            'w' => ceil($ratio * $w),
            'h' => ceil($ratio * $h),
        ];
    }
}
