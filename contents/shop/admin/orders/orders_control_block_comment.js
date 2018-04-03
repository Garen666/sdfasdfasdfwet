$j(function () {
    // notification value toggle
    var confirmMessageShow = true;
    $j('.js-notify-value-toggle').change(function(){
        if (confirmMessageShow) {
            var clickConfirm = confirm('Вы уверены что хотите отправить комментарий клиенту? Отменить операцию будет невозможно.');
            if (clickConfirm) {
                $j(this).next('.js-notify-value').toggle();
                confirmMessageShow = false;
            } else {
                $j(this).find('input').removeAttr('checked');
            }
        } else {
            $j(this).next('.js-notify-value').toggle();
            confirmMessageShow = true;
        }
    });
});

// Редактирование, удаление комментариев
$j(function(){
    if ( $j('.js-edit-message').length ){

        $j('.js-edit-message').click(function(){
            var popupButton =  $j('.js-edit-comment');
            var popupTitle =  $j('.js-popup-title');
            var popupTextarea =  $j('.js-edit-comment-text');

            // параметры для кнопки редактирования, удаления
            var id = $j(this).attr('data-id');
            var action = $j(this).attr('data-action');
            popupButton.attr('data-id',id);
            popupButton.attr('data-action',action);

            // готовим попап для удаления или редактирования
            if ( action == 'edit' ) {
                popupButton.val('Редактировать');
                popupTitle.text('Редактировать сообщение');
                popupTextarea.removeAttr('disabled');
            } else {
                popupButton.val('Удалить');
                popupTitle.text('Удалить сообщение');
                popupTextarea.attr('disabled','');
            }

            var text = $j.trim($j('#js-text-'+id).text()); // получаем текст сообщения
            popupTextarea.val(text);

            popupOpen('.js-edit-message-popup');
            return false;
        });

    }

    if ( $j('.js-edit-comment').length ){
        $j('.js-edit-comment').click( function(){

            $j.ajax({
                url: '/admin/shop/edit-comment/ajax/',
                method: 'post',
                data: {
                    id: $j(this).attr('data-id'),
                    action: $j(this).attr('data-action'),
                    text: $j('.js-edit-comment-text').val() // textarea, текст сообщения
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        $j('#js-text-'+json.id).text(json.text);
                        if (json.text == 'Сообщение удалено') {
                            $j('a[data-id='+json.id+']').hide(); // скрываем кнопки для удаления редактирования
                        }
                    }
                    popupClose('.js-edit-message-popup');
                }
            })
        })
    }
});