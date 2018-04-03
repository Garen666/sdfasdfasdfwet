$j(function() {
    //colorpicjer init
    $j('.js-color').each(function(){
        var input = $j(this);
        var currentColor = input.val();
        input.css({
            'background-color' : currentColor
        });

        input.ColorPicker({
            color: currentColor,
            onShow: function (colpkr) {
                $j(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $j(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                input.css({
                    'background-color' : '#' + hex
                });
                input.val('#' + hex);
            }
        });
    });
    
    $j('#js-autorepeat').on("change", function(e) {
        var val = $j(this).select2("val");
        
        if (val != 'no') {
            $j('#js-autorepeat-term').show();
            if (val == 'month') {
                $j('#js-autorepeat-term-text').html('день месяца');
            } else if (val == 'week') {
                $j('#js-autorepeat-term-text').html('день недели');
            } else if (val == 'day') {
                $j('#js-autorepeat-term-text').html('час');
            }
            
        } else {
            $j('#js-autorepeat-term').hide();
        }
    });
});