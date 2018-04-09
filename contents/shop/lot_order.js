$j(function () {
    $j('#js-send-message').click(function () {
        $j.ajax({
            url: '/send/message/ajax/',
            type: 'POST',
            data: {
                //deleted: $j('#js-lot-id').val()
            },
            success: function(data) {

            },
            fail: function(data) {
            },
        });
    });
});