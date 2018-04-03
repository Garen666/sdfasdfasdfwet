$j(function() {
    // Инициализация tabs-menu
    jQueryTabs.TabMenu( $j('#id-tabs a'));
    // инициализация полей доставки
    // select
    select_delivery();

    if ($j('#delivery').length) {
        delivery_add_to_order ();
    } else {
        $j('#deliverySum').text('0.00');
    }

    $j('#id-client').autocomplete({
        source: function( request, response ) {
            $j.ajax({
                url: "/admin/shop/users/jsonautocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data==null) response(null);
                    response( $j.map( data, function( item ) {
                        return {
                            label: item.name,
                            value: item.id
                        }
                    }));
                }
            });
        }
    });

    /*
    // при выходе из поля - автоматическое заполнение клиента
    $j('#id-client').live('change', function (e) {
        client_info();
    });
    */

    $j('#id-client').live('keydown', function(e) {
        if (e.keyCode == 13) {
            client_info();
        }
    });

    $j('a.ui-corner-all').live('click', function(e) {
        client_info();
    });

    // makeorder steps toggler
    $j('.js-makeorder-step-toggle').click(function(){
        var error = false;
        var formElement = $j(this).closest('form').find('.js-required-step1');
        formElement.removeClass('required-field');
        formElement.each(function(){
            if (!$j.trim($j(this).val())) {
                $j(this).addClass('required-field');
                makeorderRequiredCheck();
                error = true;
            }
        });

        if (error == true) {
            return false;
        }

        $j('.js-makeorder-step').slideToggle();
        makeorderRequiredRemove();
        makeorderRequiredCheck();
        return false;
    });

    // makeorder form submit
    $j('.js-makeorder-submit').click(function(){
        var error = false;
        var formElement = $j(this).closest('form').find('.js-required-step2');
        formElement.removeClass('required-field');
        formElement.each(function(){
            if (!$j.trim($j(this).val()) && $j(this).closest('tr').is(':visible')) {
                $j(this).addClass('required-field');
                error = true;
            }
        });

        makeorderRequiredCheck();

        if (error == true) {
            return false;
        }
    });

    $j('.js-select-delivery').click(function(){
        select_delivery();
        // скрываем все select оплаты
        $j("[name='payment']").each(function(i, j){
            $j(this).hide();
            $j(this).attr('disabled', '');
        });
        // показываем нужный
         var idDelivery = $j('.js-select-delivery option:selected').val();

        $j('#payment'+idDelivery).show();
        $j('#payment'+idDelivery).removeAttr('disabled');
        if ($j('#delivery').length) {
            delivery_add_to_order();
        }
    });

    $j('.js-select-delivery').change(function(){
        if ($j('#delivery').length) {
            delivery_add_to_order();
        }
    });
})

var username = '';
var usernamelast = '';
var usernamemiddle = '';
var useremail = '';
var userphone = '';
var useraddress = '';
var usercountry = '';

$j(function() {
    jQueryTabs.TabMenu($j('.settings-tab'));

    username = $j('#username').val();
    usernamelast = $j('#usernamelast').val();
    usernamemiddle = $j('#usernamemiddle').val();
    useremail = $j('#useremail').val();
    userphone = $j('#userphone').val();
    useraddress = $j('#useraddress').val();
    usercountry = $j('#usercountry').val();
});

$j(function() {
    $j('#js-delivery-city-select').click(function() {
        $j('#js-delivery-office-select').select2('data', {});
        $j('#js-delivery-office-select').empty();
        var city = $j('#js-delivery-city-select').val();
        if (city != '0') {
            $j.ajax({
                url: "/shop/novapostha/get/offices/ajax/",
                dataType: "json",
                data:{
                    city: city
                },
                success: function(data) {
                    $j(data).each(function(key, item) {
                        $j('#js-delivery-office-select').append($j('<option>', {value:item, text: item}));
                    });

                }
            });
        }
    });
});

$j(function() {
    /*$j.ajax({
        url: "/shop/novapostha/get/cities/ajax/",
        dataType: "json",
        success: function(data) {
            $j(data).each(function(key, item) {
                $j('#js-delivery-city-select').append($j('<option>', {value:item, text: item}));
            });

        }
    });*/
});

function select_delivery() {
    /*var logic = $j('#delivery option:selected').data('class');
    console.log('select_delivery');
    if (logic == 'Нова Пошта') {
        if (!$j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().show();
            $j('#js-delivery-office-select').parent().show();
            $j('#useraddress').hide();
            $j('#usercity').hide();
        }
    } else {
        if ($j('#js-delivery-city-select').parent().is(':visible')) {
            $j('#js-delivery-city-select').parent().hide();
            $j('#js-delivery-office-select').parent().hide();
            $j('#useraddress').show();
            $j('#usercity').show();
        }
    }*/

}

function tab_addNewUser_click() {
    $j('#username').val('');
    $j('#usernamelast').val('');
    $j('#usernamemiddle').val('');
    $j('#useremail').val('');
    $j('#userphone').val('');
    $j('#useraddress').val('');
    $j('#usercountry').val('');
    $j('#id-client').val('');
    $j('#id-newuser').val(1);
    return false;
}

function tab_me_click() {
    $j('#username').val(username);
    $j('#usernamelast').val(usernamelast);
    $j('#usernamemiddle').val(usernamemiddle);
    $j('#useremail').val(useremail);
    $j('#userphone').val(userphone);
    $j('#useraddress').val(useraddress);
    $j('#usercountry').val(usercountry);
    $j('#id-client').val('');
    $j('#id-newuser').val(0);
    return false;
}

function tab_client_click() {
    $j('#username').val('');
    $j('#usernamelast').val('');
    $j('#usernamemiddle').val('');
    $j('#useremail').val('');
    $j('#userphone').val('');
    $j('#useraddress').val('');
    $j('#usercountry').val('');
    $j('#id-newuser').val(0);
    return false;
}

function client_info() {
    var userId = $j('#id-client').val();

    $j.ajax({
        url: '/admin/shop/users/ajax/info/',
        type: "post",
        data: {
            id : userId
        },
        dataType : "json",
        success: function (data, textStatus) {
            if (data) {
                $j('#username').val(data.name);
                $j('#usernamelast').val(data.namelast);
                $j('#usernamemiddle').val(data.namemiddle);
                $j('#useremail').val(data.email);
                $j('#userphone').val(data.phone);
                $j('#useraddress').val(data.address);
            }
        }
    });
}

function delivery_add_to_order () {
    var sel = document.getElementById("delivery");
    var amount = Number(sel.options[sel.selectedIndex].getAttribute('data-amount')).toFixed(2);
    var pay = Number(sel.options[sel.selectedIndex].getAttribute('data-paydelivery'));
    var allSum = document.getElementById('allSumClear').value;
    $j('#needcity').hide();
    $j('#needaddress').hide();
    $j('#needcountry').hide();
    if (sel.options[sel.selectedIndex].getAttribute('data-address')==1) {
        $j('#needaddress').show();
    }
    if (sel.options[sel.selectedIndex].getAttribute('data-country')==1) {
        $j('#needcountry').show();
    }
    if (sel.options[sel.selectedIndex].getAttribute('data-city')==1) {
        $j('#needcity').show();
    }

    if (pay) {
        $j('#deliverySum').text(amount);
        $j('#allSum').text((Number(allSum) + Number(amount)));
    } else {
        $j('#deliverySum').text('0.00');
        $j('#allSum').text(allSum);
    }
}

function makeorderRequiredCheck() {
    $j('.required-field-message').remove();
    $j('.required-field').each(function(){
        $j(this).after('<div class="required-field-message">Обязательное поле.</div>');
    });
}

function makeorderRequiredRemove() {
    $j('.required-field').removeClass('required-field');
}