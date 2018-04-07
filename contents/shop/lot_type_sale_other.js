$j(function () {
   $j('.js-button-add').click(function () {
       var id = $j("#js-id").val();
        $j.ajax({
            url: '/lot/type/'+ id + '/sale/other/popup/ajax/',
            type: 'GET',
            data: {
                main: true
            },
            success: function(data) {
                $j('#js-popup-container').html(data);
                popupOpen('.js-popup-sale-other');
            },
            fail: function(data) {
                $j('#js-popup-container').html(data);
                popupOpen('.js-popup-sale-other');
            },
        });
   });

   $j(document).on('click', '.js-lot-item', function (event) {
       var id = $j("#js-id").val();
       var id2 = $j("#js-lot-id").val();
       $j.ajax({
           url: '/lot/type/'+ id + '/sale/other/popup/ajax/',
           type: 'GET',
           data: {
               lotId: $j(event.currentTarget).data('id')
           },
           success: function(data) {
               $j('#js-popup-container').html(data);
               popupOpen('.js-popup-sale-other');
           },
           fail: function(data) {
               $j('#js-popup-container').html(data);
               popupOpen('.js-popup-sale-other');
           },
       });
   });


    $j(document).on('click', '.js-popup-sale-other-save', function (event) {
        var id = $j("#js-id").val();
        $j.ajax({
            url: '/lot/type/'+ id + '/sale/other/popup/save/ajax/',
            type: 'GET',
            data: {
                data: $j('#js-lot-save').serializeArray()
            },
            success: function() {
                $j('#js-popup-container').html('');
                popupClose('.js-popup-sale-other');
                updateLotTable();
            },
            fail: function(data) {
            },
        });
    });

    $j(document).on('click', '.js-popup-sale-other-delete', function (event) {
        var id = $j("#js-id").val();
        $j.ajax({
            url: '/lot/type/'+ id + '/sale/other/popup/save/ajax/',
            type: 'GET',
            data: {
                deleted: $j('#js-lot-id').val()
            },
            success: function() {
                $j('#js-popup-container').html('');
                popupClose('.js-popup-sale-other');
                updateLotTable();
            },
            fail: function(data) {
            },
        });
    });





   function updateLotTable() {

   }
});
