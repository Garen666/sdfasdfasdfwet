$j(function() {

    //----------------------add comment--------------------------//

    // add comment link click
    $j('.js-add-comment').click( function() {
        var issueid = $j(this).data('id');

        if (issueid == '' || issueid == undefined) {
            return false;
        }

        $j('.js-add-comment-popup').attr('data-id', issueid);

        $j('.js-add-comment-popup').show();
    });

    // confirm add
    $j('.js-add-comment-button').click(function() {
        var id =  $j('.js-add-comment-popup').data('id');
        $j.ajax({
            url: '/admin/issue/ajax/add/comment/',
            data: {
                'issueid': id,
                'content': $j('.js-textarea-content').val()
            },
            success: function(data) {
                $j('.js-add-comment[data-id="'+id+'"]').text(data);
                $j('.js-textarea-content').val('');
                $j('.js-add-comment-popup').hide();
            }
        });
    });

    // cancel add
    $j('.js-add-comment-cancel').click( function() {
        $j('.js-textarea-content').val('');
        $j('.js-add-comment-popup').hide();
    })

    //----------------------end add comment--------------------------//


});