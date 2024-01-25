<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile('https://code.jquery.com/ui/1.10.4/jquery-ui.js', ['depends' => [yii\web\JqueryAsset::className()]]);

?>
<style>
    #drop-upload-file {
        display: none;
    }
</style>

<form id="upload" method="post" action="<?= Url::toRoute(['/imageupload/upload/upload']) ?>" enctype="multipart/form-data" accept="image/*">
<input type="file" name="upl" id="drop-upload-file">
    <ul><!-- The file uploads will be shown here --></ul>      
</form>

<form id="send-post" method="post">
    <input type="hidden" id="post-max-image" name="post-max-image" value="10">
    <input type="hidden" id="post-text" name="post-text" value="">
</form>

<img src="" alt="" id="preview" style="display:none">
<p id="orientation" style="display:block"></p>
<p id="output"  style="display:none"></p>
<div id="debug-info" style="display:none"></div>
