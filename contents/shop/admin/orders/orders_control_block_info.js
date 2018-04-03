$j(function() {
    $j( "#js-parent-name" ).catcomplete({
        delay: 0,
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/issue/searchajax/select2/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data=='badLen') return false;
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        var id = group = name = '';
                        id = item.id;
                        name = item.name;
                        category = item.category;
                        manager = item.manager;

                        return {
                            id: id,
                            label: name,
                            category: category,
                            manager: manager
                        }
                    }));
                }
            });
        },
        select: function( event, ui ) {
            $j('#js-parent-value').val(ui.item.id);
        }
    });
});

$j(function(){
    $j('.js-user-edit').hide();
    $j('.js-user-view').show();
    $j('.js-user-edit-button').click(function () {
        $j('.js-user-edit').slideToggle();
        return false;
    });
});

function settings_stage_popup (orderId, statusId) {
    if (!statusId || !orderId) {
        return false;
    }

    $j.get('/admin/order/workflow-setting-info/', {
        statusid: statusId,
        orderid: orderId
    }, function(data) {
        if (data) {
            $j('#js-settings-stage-popup-content').empty();
            $j('#js-settings-stage-popup-content').append(data);
            popupOpen('.js-settings-stage-popup');
        }
    });

    return false;

}