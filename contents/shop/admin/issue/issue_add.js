$j(function() {

    // инициализация табов
    open_tab($j('#tabInitSelected').val(), 1);
    // инициализация полей доставки
    select_delivery();

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
            $j("#managerid").select2("val", ui.item.manager);
        }
    });
});

$j(function () {
    $j('.product-find').click(function () {
        $j.get('/issue/add/products/list/', {
            name: $j('#js-product-name-input').val(),
            categoryId:  $j('#js-product-category').val()
        }, function(data) {
            $j('#js-product-div').empty();
            $j('#js-product-div').append(data);
        });
    });

    $j('#js-product-name-input').keypress(function (event) {
        if (event.which == '13') {

            $j.get('/issue/add/products/list/', {
                name: $j('#js-product-name-input').val(),
                categoryId:  $j('#js-product-category').val()
            }, function(data) {
                $j('#js-product-div').empty();
                $j('#js-product-div').append(data);
            });


            event.preventDefault();

        }
    });

});

$j(function() {
    $j('#js-product-tag').each(function (i, e) {
        var $ul = $j(e);
        $ul.tagit({
            singleField: true,
            singleFieldNode: $j($ul.data('input')),
            allowSpaces: true,
            autocomplete: {
                delay: 0,
                minLength: 2,
                source: function( request, response ) {
                    $j.ajax({
                        url: "/admin/products/json/autocomtlite/ajax/",
                        dataType: "json",
                        data:{
                            name: request.term,
                            add: 'no'
                        },
                        success: function( data ) {
                            if (data==null) response(null);
                            response( $j.map( data, function( item ) {
                                var result = name = '';

                                result = '#'+item.id+' '+item.name;
                                var name = item.name;

                                return {
                                    label: name,
                                    value: result
                                }
                            }));
                        }
                    })
                }
            }
        });
    });

});


$j(function() {
    $j('#js-delivery').click(function() {
        var price = $j('#js-delivery option:selected').attr('data-price');
        $j('#js-price-delivery').text(price+' uah');
        $j('#js-price-delivery-value').val(price);
        recalculate_price();
        select_delivery();
    });

    $j('#js-dashed-docs-list').click(function () {
        setTimeout(function() {
            if ($j('.js-docs-list').css('display') == 'none') {
                $j.cookie('docs-list', 'ok',
                    {
                        expires: 360,
                        path: '/'
                    }
                );
            } else {
                $j.cookie('docs-list', 'no',
                    {
                        expires: 360,
                        path: '/'
                    }
                );
            }
        }, 500);


    });
});

$j(function() {
    $j('#js-client-phone').autocomplete({
        source: function( request, response ) {
            query = request.term;
            $j.ajax({
                url: "/admin/shop/users/phone/ajax/autocomplete/select2/",
                dataType: "json",
                data:{
                    phone: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        name = item.name;
                        phone = item.phone;
                        return {
                            id: item.id,
                            label: phone+' ('+name+')',
                            value: phone,
                            name: item.name,
                            email: item.email,
                            skype: item.skype,
                            whatsapp: item.whatsapp
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $j('#id-clientid-value').val(ui.item.id);
            $j('#id-clientid-name').val(ui.item.name);
            $j('[name=contact_email]').val(ui.item.email);
            $j('[name=contact_skype]').val(ui.item.skype);
            $j('[name=contact_whatsapp]').val(ui.item.whatsapp);
        }
    });
});

function init_products (workflowid) {
    $j('.delete').each(function() {
        $j(this).click();
    });

    $j.ajax({
        url: "/admin/issue/ajax/init/products/",
        dataType: "json",
        data:{
            workflowId: workflowid
        },
        success: function( data ) {
            if (data) {
                $j.each(data, function (key, item) {
                    var html = '<tr class="js-tr-product-table"><td><input type="hidden" name="add_product_'+item.id+'" value="'+item.id+'"> <span class="cat-name">'+ item.categoryName+'</span> <br>'+'<a href="'+item.url+'">'+item.name+'</a></td>';
                    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-price-value" name="price_product_'+item.id+'" type="text" style="width: 70px;" value="'+item.price+'"/></td>';
                    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-count-value" name="count_product_'+item.id+'" type="text" style="width: 40px;" value="1"/></td>';
                    html+= '<td class="align_right price">'+item.price+' uah</td>';
                    html+= '<td class="align_center"><a class="delete" href="javascript:void(0);" onclick="$j(this).parent().parent().remove(); recalculate_price();"></a></td></tr>';

                    $j('#issue-add-product-table').prepend(html);

                    recalculate_price();
                });
            }

        }
    });

}

function issue_add_product (id, name, categoryName, price, url, serial) {
    var html = '<tr class="js-tr-product-table"><td><input type="hidden" name="serial_product_'+id+'" value="'+serial+'"><input type="hidden" name="add_product_'+id+'" value="'+id+'"> <span class="cat-name">'+categoryName+'</span> <br>'+'<a href="'+url+'">'+name+'</a></td>';
    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-price-value" name="price_product_'+id+'" type="text" style="width: 70px;" value="'+price+'"/></td>';
    html+= '<td class="align_center"><input onblur="recalculate_price();" class="align_center js-count-value" name="count_product_'+id+'" type="text" style="width: 40px;" value="1"/></td>';
    html+= '<td class="align_right price">'+price+' uah</td>';
    html+= '<td class="align_center"><a class="delete" href="javascript:void(0);" onclick="$j(this).parent().parent().remove(); recalculate_price();"></a></td></tr>';

    $j('#issue-add-product-table').prepend(html);

    recalculate_price();
}

function recalculate_price () {
    var price = 0;
    $j('.js-tr-product-table').each(function() {
        amount = Number($j(this).find('.js-price-value').val());
        count = Number($j(this).find('.js-count-value').val());
        sum = Number(amount*count);
        price+= sum;
        $j(this).find('.price').text(sum.toFixed(2)+' uah');
    });

    price+= Number($j('#js-price-delivery-value').val());
    $j('#js-price-total').text(price.toFixed(2)+' uah');
}

function select_delivery() {
    var logic = $j('#js-delivery option:selected').data('class');
    if (logic == 'Нова Пошта') {
        if (!$j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().show();
            $j('#js-delivery-office-select').parent().show();
            $j('#js-delivery-city-input').hide();
            $j('#js-delivery-office-input').hide();
        }
    } else {
        if ($j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().hide();
            $j('#js-delivery-office-select').parent().hide();
            $j('#js-delivery-city-input').show();
            $j('#js-delivery-office-input').show();
        }
    }

}

function open_tab (tab, init) {
    $j('.selected').removeClass('selected');

    if (tab == 'project' || !tab) {
        $j('#js-fade-parent-div').hide();
        $j('#js-fade-product').show();
        $j('.js-workflow-container').show();
        $j('#js-parent-name').removeAttr('required');
        $j('#js-issue-project-tab').addClass('selected');
        $j('#js-iforder-callback').append($j('#js-fade-product'));

        //перенос блоков
        // блок - когда старт задача
        $j('#js-workflow-container-parent-div').append($j('#js-workflow-container-div'));
        $j('#js-workflow-parent-div').append($j('#js-workflow-div'));
        $j('#js-source-parent-div').append($j('#js-source-div'));
        $j('#js-fade-parent-div').append($j('#js-fade-div'));
        $j('#js-content-parent-div').append($j('#js-content-div'));
        $j('#js-what-todo-parent-div').append($j('#js-what-todo-div'));
        $j('#js-start-issue-parent-div').append($j('#js-start-issue-div'));
        $j('#js-result-div').empty();

    }

    if (tab == 'issue') {
        $j('#js-fade-parent-div').show();
        $j('#js-fade-product').hide();
        $j('.js-workflow-container').hide();
        $j('#js-parent-name').attr('required', '');
        $j('#js-issue-task-tab').addClass('selected');
        $j('#js-iforder-callback').append($j('#js-fade-product'));

        // перенос блоков
        // блок - когда старт задача
        $j('#js-workflow-container-parent-div').append($j('#js-workflow-container-div'));
        $j('#js-workflow-parent-div').append($j('#js-workflow-div'));
        $j('#js-source-parent-div').append($j('#js-source-div'));
        $j('#js-fade-parent-div').append($j('#js-fade-div'));
        $j('#js-content-parent-div').append($j('#js-content-div'));
        $j('#js-what-todo-parent-div').append($j('#js-what-todo-div'));
        $j('#js-start-issue-parent-div').append($j('#js-start-issue-div'));
        $j('#js-result-div').empty();

        $j('.js-result-block').show();
    }

    if (tab == 'order') {
        $j('#js-fade-parent-div').show();
        $j('#js-fade-product').show();
        $j('.js-workflow-container').show();
        $j('#js-parent-name').removeAttr('required');
        $j('#js-issue-order-tab').addClass('selected');
        $j('#js-iforder').append($j('#js-fade-product'));

        // перенос блоков
        // блок - когда старт задача

        $j('#js-result-div').append($j('#js-start-issue-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-what-todo-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-content-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-fade-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-source-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-workflow-div'));
        $j('#js-result-div').append('<br>');
        $j('#js-result-div').append($j('#js-workflow-container-div'));
        $j('.js-result-block').hide();

        setTimeout(function() {
            $j('#js-product-name-input').focus();
        }, 200);
    }

    var worlflowId = $j('#js-control-workflowid').val();
    var selected = false;
    // подгружаем бизнес процессы длоя каждой группы
    $j.ajax({
        url: "/workflow/list/ajax/",
        dataType: "json",
        data:{
            tab: tab
        },
        success: function( data ) {
            $j('#js-workflowid').empty();
            $j(data).each(function(key, value) {
                $j('#js-workflowid').append( $j('<option value="'+value.id+'">'+value.name+'</option>'));
                if (worlflowId == value.id) {
                    $j('#js-workflowid').select2('val', value.id);
                    selected = true;
                }
            });

            if (data || !selected) {
                $j('#js-workflowid').select2('val', $j('#js-workflowid:first').val());
            }
            
        }
    });


    if (tab) {
        $j.cookie('issue-add-tab', tab,
            {
                expires: 360,
                path: '/'
            }
        );
    }

    setTimeout(function() {
            $j('.js-workflowid').change();
        }, 500
    );

    return false;
}