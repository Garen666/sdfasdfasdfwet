$j(function () {
    $j('.js-todo-status').click(function (event) {
        event.preventDefault();

        var issueID = $j(event.target).data('issueid');
        var statusID = $j(event.target).data('statusid');

        $j.ajax({
            url: '/admin/todo/update/',
            data: {
                issueid: issueID,
                statusid: statusID
            },
            success: function () {
                $j(event.target).closest('div').find('a').removeClass('selected');
                $j(event.target).addClass('selected');
            }
        });
    });
});

$j(function() {

    //----------------------add comment--------------------------//

    // add comment link click
    $j('.js-add-comment').click( function() {
        var issueid = $j(this).data('id');

        if (issueid == '' || issueid == undefined) {
            return false;
        }

        $j('.js-add-comment-popup').data('id', issueid);
        $j('.js-add-comment-popup').show();
        $j('.js-textarea-content').focus();
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
                $j('<p>'+data+'</p><hr/>').insertBefore($j('.js-add-comment[data-id="'+id+'"]'));
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