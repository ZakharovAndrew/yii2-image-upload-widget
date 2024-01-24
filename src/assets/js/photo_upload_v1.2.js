var postImages = [];
var postImageCount = 0;
const compress = new Compress();

function iOS() {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}

$(function(){
    var ul = $('#upload ul');
    let max_images = $('#post-max-image').val();
    if ($("#product-images").val().length > 0) {
        postImages = $("#product-images").val().split(',');
    }
	
        console.log('start photo_upload', max_images);

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $('#drop-upload-file').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),
        
        

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {
            console.log('length', postImageCount);
            
            if (postImageCount>(max_images-1)) {
                $("#message-box").html('<p style="color:red">Максимум 5 картинок!</p>');
                alert('Максимум '+max_images+' картинок!');
            } else {
                postImageCount += 1;
                // учитываем все файлы
                let filesCount = data.files.length;

                var i = 0;
                   var fileNameExt = data.files[i].name.substr(data.files[i].name.lastIndexOf('.') + 1);
                    console.log('fileNameExt', fileNameExt,  ' имя ', data.files[i].src);
                    $("#debug-info").append('<p>fileNameExt '+fileNameExt+'</p>');
                    $("#output").append('<p>'+fileNameExt+'</p>');
                    if (fileNameExt == 'heic' || fileNameExt == 'jpeg' || fileNameExt == 'JPEG' || fileNameExt == 'jpg' || fileNameExt == 'JPG' || fileNameExt == 'PNG'  || fileNameExt == 'png') {
                        //console.log(data.files);
                        const preview = document.getElementById('preview')
                        const output = document.getElementById('output')

                        const files = data.files;
                        console.log('data src =', data.files[i].src);
                        console.log('data src =', files);
                        console.log('start compress');
                        
                        var fileImg;
                        const imageForCompress = new Image();
                        
                        /*
                        loadImage(
                            data.files[i],
                            function (img, data) {
                                document.body.appendChild(img);
                                console.log('data.image', img);

                                imageForCompress.src = img.src;
                                console.log('imageForCompress', imageForCompress, data);
                                fileImg = dataURLtoFile(img.src, data.files[i].name);
                                console.log('fileImg', fileImg);
                            },
                            { maxWidth: 1000, maxHeight: 1000}
                        );*/

                    console.log('asd');

      

                            compress.compress([data.files[i]], {
                                size: 4, // the max size in MB, defaults to 2MB
                                quality: 0.9, // the quality of the image, max is 1,
                                maxWidth: 1000, // the max width of the output image, defaults to 1920px
                                maxHeight: 1000, // the max height of the output image, defaults to 1920px
                                resize: true // defaults to true, set false if you do not want to resize the image width and height
                            }).then((images) => {
                                $("#output").append('<p>Start сжатия</p>');
                                console.log(images);
                                const img = images[0];
                                // returns an array of compressed images
                                preview.src = `${img.prefix}${img.data}`;
                                //console.log(img);

                                const { endSizeInMb, initialSizeInMb, iterations, sizeReducedInPercent, elapsedTimeInSeconds, alt } = img;

                                //output.innerHTML = `<b>Start Size:</b> ${initialSizeInMb} MB <br/><b>End Size:</b> ${endSizeInMb} MB <br/><b>Compression Cycles:</b> ${iterations} <br/><b>Size Reduced:</b> ${sizeReducedInPercent} % <br/><b>File Name:</b> ${alt}`;

                                var file = dataURLtoFile(preview.src, 'filename'+Date.now()+'.jpg');
                                console.log('FILE==', file);
                                $("#output").append('<p>'+'FILE==' + file+'</p>');

                                data.files[i] = file; //new File([Base64.encode(preview.src)], "my_image.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});// compress.convertBase64ToFile(preview.src);
                                var jqXHR = data.submit();
                            }).catch(function (err) {
                                console.log(err);
                            });


                            

  
                    } else {

                        var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                            ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

                        // Append the file name and file size
                        tpl.find('p').text(data.files[i].name)
                                     .append('<i>' + formatFileSize(data.files[i].size) + '</i>');

                        // Add the HTML to the UL element
                        data.context = tpl.appendTo(ul);

                        // Initialize the knob plugin
                        tpl.find('input').knob();

                        // Listen for clicks on the cancel icon
                        tpl.find('span').click(function(){

                            if(tpl.hasClass('working')){
                                jqXHR.abort();
                            }

                            tpl.fadeOut(function(){
                                tpl.remove();
                            });

                        });

                        // Automatically upload the file once it is added to the queue
                        var jqXHR = data.submit();
                    }
                
                
            }
        },

        done: function(e, data){
            $("#output").append('GOOD!', data.result);
            console.log('GOOD!', data, data.result);
            var result = JSON.parse(data.result);
            $('#post-image').append('<div class="img-box"><img src="/uploaded_files/'+result.filename_medium+'" style="width:200px;height:auto"><span class="img-delete" data-img="'+result.filename+'">X</span></div>');
            //postImages[result.filename] = result.filename;
            
            postImages.push(result.filename);
            genRawPostText();
        },

        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
            $("#debug-info").append('<p>Ошибка загрузки</p>');
        }

    });


    $('#send-post').submit(function() {
        console.log('Отправка формы');
        if ($('#closed_pavilion').is(':checked')) {
            $("#product-images").val('a035390bad8ddf2ac6d133c56ddea2ca');
            //console.log('добавим фотки' + 'a035390bad8ddf2ac6d133c56ddea2ca');
        } else 
        if (postImageCount == 0) {
            event.preventDefault();
            alert('Добавьте картинки!');
            return;
        }
        if ($("#post-row").val() == '') {
            event.preventDefault();
            alert('Выберите место!');
            return;
        }
    });
    
    $("#photoRow").on('change', function() {
        $("#post-row").val($("#photoRow").val());
        console.log($("#photoRow").val());
    });
    $("#photoPlace").on('change input keyup', function() {
        $("#post-place").val($("#photoPlace").val());
        console.log($("#photoPlace").val());
    });

    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    function genRawPostText() {
        $("#product-images").val(postImages.join(','));
        $("#imgCount").html('Максимально 5 картинок. Можно еще добавить '+(10 - postImageCount) +' картинок');
        console.log($("#product-images").val());
    }
    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
    
    $("#text").on('input', function() {
        genRawPostText();
        $("#letters").html('Осталось символов: '+ (1000 - $("#text").val().length) +' из 1000');
    });
    
    $("#category").on('change', function() {
        $("#post-category").val($("#category").val());
        console.log($("#post-category").val());
    });
    
    $('#post-image').on('click', function(e) {
        console.log(e.target.className);
        if (e.target.className == 'img-delete') {
            const img_id = $(e.target).data('img');
            postImages.splice( $.inArray(img_id, postImages), 1 );
            postImageCount -=1;
            $(e.target).parent().remove();
            genRawPostText();
        }
    });
    
    $("#category").trigger('change');
	
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
                u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:"image/jpeg"});
    }

    $("#debug-info").append('<p>Готовы к загрузке</p>');
    
    $("#post-image").sortable({
        update: function(event, ui) {
            resetIdsOfImage();
        } //end update         
    });
    
    function resetIdsOfImage() {
        var values = [];
        $('.img-delete').each(function() {
            values.push($(this).attr('data-img'));
        });
        postImages = values;
        genRawPostText();
    }
});

$(document).ready(function(){
    
});