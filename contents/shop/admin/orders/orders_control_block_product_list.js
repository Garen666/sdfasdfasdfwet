$j(function () {
    $j('#id-product').click(function(e){
        selectwindow_init('w1', 'id-name', 'id-value', {
            productsearch: true,
            productadd: true
        });
        e.preventDefault();
    });

    $j('#id-product-clear').click(function(e){
        $j('#js-product-tag').tagit("removeAll");
        e.preventDefault();
    });

    $j('.js-oders-sort').sortable({
        handle: ".move",
        axis: "y",
        update: function () {
            var productIdArray = [];
            var order_id = $j('.js-oders-sort').data('orderid');
            $j('.js-oders-sort tr').each(function () {
                productIdArray.push($j(this).data('productid'));
            });
            $j.ajax({
                url: '/admin/shop/orders/products/sort/ajax/',
                data: {
                'productsIdArray': productIdArray,
                'orderId': order_id
                }
            });
        }
    });
});

$j(function() {
    $j('#js-product-tag').tagit({
        singleField: true,
        singleFieldNode: $j($j('#js-product-tag').data('input')),
        allowSpaces: true,
        autocomplete: {
            delay: 0,
            minLength: 3,
            source: function( request, response ) {
                var query = request.term;
                $j.ajax({
                    url: "/admin/products/json/autocomtlite/ajax/",
                    dataType: "json",
                    data:{
                        name: query
                    },
                    success: function( data ) {
                        if (data==null) response(null);
                        response( $j.map( data, function( item ) {
                            var result = name = '';

                            if (item.id==0) {
                                result = '#0';
                            } else {
                                result = '#'+item.id+' '+item.name;
                            }
                            var name = item.name;

                            return {
                                label: name,
                                value: result
                            }
                        }));
                    },
                    complete : function () {
                        $j('.tagit-autocomplete').each(function(){
                            $j(this).addClass('ob-search-autocomplete');
                            var positionLeft = $j('#js-product-tag').offset().left + 1;
                            var positionTop = $j('#js-product-tag').offset().top + $j('#js-product-tag').innerHeight();
                            $j(this).css({
                            'left' : positionLeft,
                            'top' : positionTop,
                            'width' : 'auto'
                            })
                            var el = $j(this).children(':last');
                            el.attr("onClick","addProductInSelectWindow(\""+query+"\"); setTimeout(function(){$j('#js-product-tag').tagit(\"removeTagByLabel\", \"#0\");},200);");
                            var elemtext = el.text();
                            el.text('');
                            el.append('<span class="ob-link-add ob-link-dashed">'+elemtext+'</span>');
                        });
                    }
                })
            }
        }
    });
});

$j(function() {
    $j('.js-orderlist-editable').click(function(){
        $j('.js-order-table').find('.js-data-group .ob-link-edit').click();
        $j(this).html($j(this).text() == 'отменить все' ? 'редактировать все' : 'отменить все');
        return false;
    });
});

$j(function() {

    $j('.js-storage-reserve-block').click(function(event) {
        $target = $j(event.target);

        // резервирование
        if ($target.is('.js-storage-reserve')) {
            event.preventDefault();

            var balanceID = $target.attr('data-balanceid');
            var orderProductID = $target.attr('data-orderproductid');
            var $link = $target;

            $j.ajax({
                url: '/storage/reserve/ajax/',
                method: 'post',
                data: {
                    balanceid: balanceID,
                    orderproductid: orderProductID
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        var amountReserved = json.result.amount;

                        $block = $link.closest('.js-storage-reserve-block');

                        $block.html('<strong>Зарезервировано ' + amountReserved + '</strong>');
                        $block.append(' <a href="#" data-orderproductid="' + orderProductID + '" class="js-storage-cancel-reserve" >отменить</a>');
                    }
                }
            });

        }

        // отменить резервирование
        if ($target.is('.js-storage-cancel-reserve')) {
            event.preventDefault();

            var orderProductID = $target.attr('data-orderproductid');
            var $link = $target;

            $j.ajax({
                url: '/storage/reserve/cancel/ajax/',
                method: 'post',
                data: {
                    orderproductid: orderProductID
                },
                dataType:'json',
                success: function(json){
                    if (json.status == 'success') {
                        var balance = json.result.balance;

                        $block = $link.closest('.js-storage-reserve-block');

                        if (balance.count) {
                            $block.html('На складе ' + balance.name + ': ' + balance.count);
                            $block.append(' <a href="#" data-balanceid="' + balance.id + '" data-orderproductid="' + orderProductID + '" class="js-storage-reserve" >резервировать</a>');
                        } else {
                            $block.remove();
                        }
                    }
                }
            });
        }
    });
});