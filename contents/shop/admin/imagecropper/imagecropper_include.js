var widthDiv;
var heightDiv;
var widthImage;
var heightImage;

$j(function () {
    if ($j('#file_upload_crop').length) {
        $j('#file_upload_crop').uploadify({
            swf           : '/media/uploadify/uploadify.swf',
            uploader      : '/imagecropper/upload/ajax/',
            buttonText    : 'Загрузить',
            multi         : false,
            'onUploadSuccess' : function(file, data, response) {
                $j('#cropper-viewport-id').html('');

                if (data != 'Не коректный файл.' && data != 'Изображение слишком велико.' && data != 'Изображение слишком мало.') {
                    data = $j.parseJSON(data);
                    $j('#cropper-viewport-id').html(
                        '<p><img src="'+data.src+'" alt="" id="imagecropper-cropimage" width="'+data.width+'" height="'+data.height+'" ' +
                            'style="float: left; margin-right: 10px;"/></p>'
                    );

                    widthDiv = data.widthdiv;
                    heightDiv = data.heightdiv;
                    widthImage = data.width;
                    heightImage = data.height;

                    $j('#imagecropper-name').val(data.filename);
                    $j('#big-image-main').val(data.filename);
                    $j('#imagecropper-ext').val(data.ext);
                    $j('#imagecropper-x1').val(0);
                    $j('#imagecropper-y1').val(0);
                    $j('#imagecropper-x2').val(widthDiv);
                    $j('#imagecropper-y2').val(heightDiv);
                    $j('#imagecropper-koef').val(data.koef);
/*
                    $j('<div><img src="'+data.src+'" style="position: relative;" /><div>')
                        .css({
                            float: 'left',
                            position: 'relative',
                            overflow: 'hidden',
                            width: data.widthdiv+'px',
                            height: data.heightdiv+'px'
                        })
                        .insertAfter($j('#imagecropper-cropimage'));
*/
                    if ($j('.js-imagecropper-enable').length) {
                        var aspectRatio = data.cropWidth+':'+data.cropHeight;
                    } else {
                        var aspectRatio = false;
                    }

                    setTimeout(function(){
                        $j('#imagecropper-cropimage').imgAreaSelect({
                            // aspectRatio: aspectRatio, отключим соотношение сторон
                            handles: true,
                            fadeSpeed: 200,
                            minHeight: data.cropHeight,
                            minWidth: data.cropWidth,
                            show: true,
                            x1:0,
                            y1:0,
                            x2:widthDiv,
                            y2:heightDiv,
                            onSelectChange: preview,
                            onSelectEnd: function (img, selection) {
                                $j('#imagecropper-x1').val(selection.x1);
                                $j('#imagecropper-y1').val(selection.y1);
                                $j('#imagecropper-x2').val(selection.x2);
                                $j('#imagecropper-y2').val(selection.y2);
                            }
                        });
                    }, 1000);
                } else {
                    $j('#cropper-viewport-id').append('<div>'+data+'</div>');
                }
                popupOpen('.js-croper-popup');
            }
        });
    }
});

function preview(img, selection) {
    var scaleX = widthDiv / (selection.width || 1);
    var scaleY = heightDiv / (selection.height || 1);

    $j('#imagecropper-cropimage + div > img').css({
        width: Math.round(scaleX * widthImage) + 'px',
        height: Math.round(scaleY * heightImage) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}