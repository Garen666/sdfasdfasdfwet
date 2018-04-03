var geocoder;
var map;

$j(function () {
    // система скрытия/раскрытия блоков
    var element = $j('.shop-toggle-block');

    // обработчик клик
    $j('.shop-toggle-block .toggle').click(function() {
        var toggleElement = $j('.shop-toggle-block').has(this); // текеущий блок по котором нажали
        var index = toggleElement.index(); // индекс елемента
        $j(toggleElement).find('.block').animate({
        'height' : 'toggle'
        });

        if ($j(this).is('.close')) {
            $j(this).removeClass('close');
        } else {
            $j(this).addClass('close');
        }
        return false;
    });

    // геокодирование
    var address = $j('#js-map-address').text();

    if (address != undefined && address != '') {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
            zoom: 8,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('js-map-canvas'), mapOptions);
        googlemaps_geocode(address);
    }
});

function googlemaps_geocode(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            $j("#js-map-canvas").html('Не найдено место на карте. Попробуйте указать другой адрес.');
            $j("#js-map-canvas").removeAttr("style");
            // alert('Ошибка геокодирования адреса. Код ошибки: ' + status);
        }
    });
}

$j(function() {
    // выбор компании tag it + autocomplete
    $j('#js-company-tag').each(function (i, e) {
        var $ul = $j(e);
        $ul.tagit({
            singleField: true,
            singleFieldNode: $j($ul.data('input')),
            placeholderText: 'Компания',
            allowSpaces: true,
            autocomplete: {
                delay: 0,
                minLength: 2,
                source: function( request, response ) {
                    $j.ajax({
                        url: "/search/companyautocomplete/",
                        dataType: "json",
                        data:{
                            name: request.term
                        },
                        success: function( data ) {
                            if (data==null) response(null);
                            response( $j.map( data, function( item ) {
                                var result = name = '';

                                result = item.name;
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

    tagCompany();

    post_autocomplete($j('#js-post-field'));

    recommend_init();

    if ($j('#js-sort-table').length) {
        $j('#js-sort-table').tablesorter();
    }
});

// autocomplete должности
function post_autocomplete($input) {
    $input.autocomplete({
        source: function(request, response) {
            $j.ajax({
                url: "/admin/shop/users/ajax/post/autocomplete/",
                dataType: "json",
                data:{
                    name: request.term
                },
                success: function( data ) {
                    if (data == null) response(null);
                    response($j.map(data, function(item) {
                        return {
                            label: item,
                            value: item
                        }
                    }));
                }
            });
        }
    });
}

var pageSize = 20;
$j(function() {
    $j('#js-user-filter').select2({
        //placeholder: {title: "Search for a movie", id: "s"},
        //Does the user have to enter any data before sending the ajax request
        minimumInputLength: 0,
        allowClear: true,
        multiple: true,
        ajax: {
            //How long the user has to pause their typing before sending the next request
            quietMillis: 150,
            //The url of the json service
            url: "/admin/shop/users/jsonautocomplete/select2/",
            dataType: 'jsonp',
            //Our search term and what page we are on
            data: function (term, page) {
                return {
                    pageSize: pageSize,
                    pageNum: page,
                    searchTerm: term,
                    searchin: 'userto'
                };
            },
            results: function (data, page) {
                //Used to determine whether or not there are more results available,
                //and if requests for more data should be sent in the infinite scrolling
                var more = (page * pageSize) < data.Total;
                return { results: data.Results, more: more };
            }
        }
    });
});

function tagCompany () {
    if ($j('#js-typesex').val() != 'company'){
        $j('#js-company-tag').show();
        $j('#js-company-input').hide();
        var array = $j('#js-company-input').val().split(',');
        $j("#js-company-tag").tagit("removeAll");
        $j('#js-company-input').val('');

        $j(array).each(function (i, j) {
            if (j) {
                $j("#js-company-tag").tagit("createTag", j.trim());
            }
        });

    } else {
        $j('#js-company-tag').hide();
        $j('#js-company-input').show();
        $j('#js-company-input').val($j('#js-company-tag').tagit("assignedTags"));
    }
}

$j(window).bind('load', function(){
    animation('.js-data-element', 'blind');
});