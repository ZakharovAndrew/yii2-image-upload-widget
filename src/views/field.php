<?= $input ?>
<div id="post-image">
    <?php if (!empty($model->{$name})) {
    $imgList = explode(',',$model->{$name});
        foreach ($imgList as $img) {
    ?>
    <div class="img-box"><img src="/uploaded_files/<?= $img ?>_img_medium.jpg" style="width:200px;height:auto"><span class="img-delete" data-img="<?= $img ?>">X</span></div>
    <?php 
        }
    } ?>
</div>

<style>
    #drop {
        text-align: center;
        border: 2px dotted #434343;
        margin-top: 10px;
        border-radius: 9px;
        background: #0000000a;
        padding: 15px 0;
    }
    #drop a:hover {
        background:#1565c0 !important;
    }
</style>

<div id="drop">
    <!-- Перетащите файл в эту область<br> -->

    <a><svg t="1648548256714" class="mr-10" width="30px" height="30px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="36351" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200">
        <path d="M512 128l271.573333 271.573333-60.373333 60.373334-168.533333-168.533334V640h-85.333334V291.413333l-168.533333 168.533334-60.373333-60.373334z m298.666667 384v298.666667H213.333333V512H128v384h768V512z" p-id="36352" fill="#ffffff"></path></svg> Загрузить картинку</a>

    <p class="drop-here">или перетащи сюда</p>
    <p style="font-size: 12px;color: #b1b1b1;">JPG, PNG, IMEC (iPhone). Максимум 10 файлов</p>
</div>