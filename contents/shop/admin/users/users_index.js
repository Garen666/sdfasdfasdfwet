$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
            }
        });

        $j('#id-user').val(ids);
    });
});

$j(window).bind('resize load', function() {
    contactsLayerHeight();
});

function contactsLayerHeight() {
    var bodyHeight = $j(window).height();
    var contentPadding = 20;
    var naviHeight = $j('.shop-admin-navi').height();
    var tabsHeight = $j('.shop-tabs-place').height();
    var buttonsHeight = $j('.ob-button-fixed-place').height();

    $j('.js-layer-overflow').css({
        'height' : bodyHeight - contentPadding - naviHeight - tabsHeight - buttonsHeight
    });

    if($j('.shop-overflow-table').length){
        $j('.js-layer-overflow').bind('scroll', function() {
            perfectScrollposition(this);
        });
    }
}