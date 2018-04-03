$j(function () {
    $j("#content div").hide(); // Initially hide all content

    if (!$j('#tabs li').is('[data-class="current"]')) {
        $j("#tabs li:first").attr("data-class","current"); // Activate first tab
        $j("#content div:first").fadeIn(); // Show first tab content
    } else {
        $j("#content div[data-class='current']").fadeIn();
    }


    $j('#tabs a').click(function(e) {
        //e.preventDefault();
        $j("#content div").hide(); //Hide all content
        $j("#tabs li").attr("data-class",""); //Reset id's
        $j(this).parent().attr("data-class","current"); // Activate this
        $j('#' + $j(this).attr('title')).fadeIn(); // Show content for current tab
    });
});

$j(function() {
    // utm to cookie
    var utm_source = getUrlParameter('utm_source');
    var utm_medium = getUrlParameter('utm_medium');
    var utm_campaign = getUrlParameter('utm_campaign');
    var utm_content = getUrlParameter('utm_content');
    var utm_term = getUrlParameter('utm_term');
    var utm_referrer = document.referrer;

    var currentdate = new Date();
    var utm_date = "" + currentdate.getFullYear() + "-"
        + (currentdate.getMonth()+1)  + "-"
        + currentdate.getDate() + " "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    if ($j.cookie('utm_date') == undefined) {
        $j.cookie('utm_date', utm_date, { expires: 365, path: '/' });
    }

    if (utm_source != '') {
        $j.cookie('utm_source', utm_source, { expires: 365, path: '/' });
    }
    if (utm_medium != '') {
        $j.cookie('utm_medium', utm_medium, { expires: 365, path: '/' });
    }
    if (utm_campaign != '') {
        $j.cookie('utm_campaign', utm_campaign, { expires: 365, path: '/' });
    }
    if (utm_content != '') {
        $j.cookie('utm_content', utm_content, { expires: 365, path: '/' });
    }
    if (utm_term != '') {
        $j.cookie('utm_term', utm_term, { expires: 365, path: '/' });
    }
    if (utm_referrer != '') {
        $j.cookie('utm_referrer', utm_referrer, { expires: 365, path: '/' });
    }

    // ajs-code
    $j('.ajs').val('ready');

    // ������� �����/������
    if ($j('.os-columnbanner-carousel .line').length) {
        $j('.os-columnbanner-carousel .line').each(function(index, e) {
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().find('.next'),
                btnPrev: $j(e).parent().find('.prev'),
                circular: true,
                visible: 1,
                speed: 500,
                auto: true,
                timeout: 5000
            });
        });
    }

    // ������������� ���������
    // ��������, ����� �� ���� ������
    if ($j('.os-product-carousel .line').length) {
        $j('.os-product-carousel .line').each(function(index, e) {
            var $auto = $j(e).data('auto') ? true : false;
            $j(e).jCarouselLite({
                btnNext: $j(e).parent().parent().find('.next'),
                circular: true,
                visible: 6,
                speed: 500,
                auto: $auto,
                timeout: 5000
            });
        });
    }

    // block banner top init
    $j('.js-block-slider .line').jCarouselLite({
        btnGo: $j('.js-block-slider .control span'),
        auto: true,
        timeout: 8000
    });

    // tpl_columt
    if( !$j.trim( $j('.js-aside-right').html() ).length ) {
        $j('.js-section').addClass('full');
        $j('.js-aside-right').hide();
    }

    // ������ ��� ��������� �������
    shop_basket_load();

    // ajax ������� �������
    $j('.js-shop-buy-action').click(function (event) {
        shop_basket_buy(event);
    });

    // price from select
    $j('.shop-select').change(function(event){
        $j('.button-refresh').click();
    });

    // � ������� ������� - ������ ����� 3 ������� �������������
    $j('.os-filter-block input, .os-filter-block select').live('change', function() {
        setTimeout(shop_filter_submit, 3000);
    });

    $j('.os-filter-block a').live('click', function() {
        if (!$j(this).hasClass('js-remove-filter')) {
            $j(this).parent().find('input').attr('checked', 'checked');
            $j('.os-filter-block .os-submit').click();
            return false;
        }
    });

    $j('.js-remove-filter').click(function(){
        $j('.os-filter-block').addClass('load');
    });

    // @todo: wtf?
    $j('a.comment-link').click(function(){
        commentPress();
    });

    // ������������� tabs-menu
    if ($j('#id-tabs').length) {
        jQueryTabs.TabMenu($j('#id-tabs a'));

        $j('#id-tabs a').click(function(){
            // product thumb size
            productThumbSize();
        });
    }

    // product compare
    $j('.js-shop-compare-action').click(shop_compare_add);
    shop_compare_load();

    // product page
    try {
        commentParser();
    } catch (e) {}

    //�������� ���� �� ������
    if ($j('#canAddMarkup').val()) {
        $j('.js-shop-buy-option').change(function () {
            var discount = 0;
            if ($j('#dataDiscount').length) {
                discount = $j('#dataDiscount').val();
            }
            var optionMarkup = 0;
            $j('.js-shop-buy-option').each(function (i, e) {
                var optionID = $j(e).data('optionid');
                var optionValue = $j(e).val();
                if (optionValue) {
                    optionMarkup += parseFloat($j('#'+'option'+optionID+'hidden'+hex_md5(optionValue)).val());
                }
            });
            // ��������� ������ ��� ������� �� ������
            //console.log(optionMarkup / 100 * discount);
            optionMarkup = optionMarkup - optionMarkup / 100 * discount;
            var price = parseFloat($j('#canAddMarkup').val());
            price = price + optionMarkup;
            price =  price.toFixed(2);
            $j('#priceSpan').html(price);
        });
    }

    //content replace for seo
    $j('.os-seo').appendTo('section').height('auto');

    //phone formating
    if ($j('.js-phone-mask').length) {
        $j('.js-phone-formatter').mask($j('.js-phone-mask').text());
    }

    //������������� ��������� ��������
    $j('.colorbox').colorbox({
        rel:'gal',
        maxWidth: '95%',
        maxHeight: '95%',
        returnFocus: false,
        trapFocus: false
    });

    //go to top button
    if ($j('.js-gototop').length) {
        var buttonToTop = $j('.js-gototop');
        buttonToTop.click(function(){
            $j('html, body').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
        $j(window).scroll(function() {
            var screenHeight = $j(window).height();
            var buttonPosition = buttonToTop.offset().top;
            if (buttonPosition > screenHeight) {
                buttonToTop.fadeIn();
            }else{
                buttonToTop.fadeOut();
            }
        });
    }

    // required fields verification
    if ($j('.js-form-validation').length) {
        $j('.js-form-validation').click(function(){
            var error = false;
            var formElement = $j(this).closest('form').find('.js-required');
            formElement.removeClass('required-field');
            formElement.each(function(){
                if (!$j.trim($j(this).val())) {
                    $j(this).addClass('required-field');
                    $j('.required-field-message').remove();
                    $j('.required-field').each(function(){
                        $j(this).after('<div class="required-field-message">������������ ����.</div>');
                    });
                    error = true;
                }
            });

            if (error == true) {
                return false;
            }

            $j('.required-field-message').remove();
        });
    }

    // top category list toggle
    $j('.js-list-all-toggle').click(function(){
        $j(this).parent().prev('.js-list-all').slideToggle();
        return false;
    });

    // block rating
    if ($j('.js-block-rating').length) {
        $j('.js-block-rating span').hover(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('.inner').css({'width' : newValue*20+'%'});
        },function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var currentValue = $ratingBlock.find('input').val();
            $ratingBlock.find('.inner').css({'width' : currentValue*20+'%'});
        });

        $j('.js-block-rating span').click(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            var newValue = $j(this).data('count');
            $ratingBlock.find('input').val(newValue);
            $ratingBlock.find('.text').html(newValue + ' �� 5');
        });

        $j('.js-rating-clear').click(function(){
            var $ratingBlock = $j(this).closest('.os-block-rating');
            $ratingBlock.find('input').val('');
            $ratingBlock.find('.inner').css({'width' : '0'});
            $j(this).html('');
        });
    }

    menuHover();

    headerTransform();

    productAutocomplete();

    productThumbSize();
});

$j(document).ready(function() {

    // Bind to StateChange Event IE 8 support
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
    });

    softPagination();
});

/**
 * �������� ������� ajax-��
 */
function softPagination() {
    //---------------------------������ ���������---------------------------------//
    if ($j('.js-product-list-group-id').length) {
        var id = $j('.js-product-list-group-id').data('id');
        var key = $j('.js-product-list-group-id').data('key');

        var $process = false;
        $j(window).scroll(function () {

            if (!$j('.js-os-stepper .selected').length) { // ���� ��� �������, �� �������
                return false;
            }

            var stepperPosition = $j('.js-os-stepper').offset().top;
            var windowBottom = $j(window).scrollTop() + $j(window).height();

            if ( windowBottom >= stepperPosition && !$process ) {
                $process = true;

                var nextLink = $j('.js-os-stepper .selected').next();
                if (nextLink == undefined || nextLink.data('rel') == 'next') {
                    nextLink.hide();
                    return false;
                }

                var url = nextLink.attr('href');
                if (!url) {
                    return false;
                }

                configurePagination(nextLink);

                // ������ ���
                History.replaceState("object or string", "Title", url);

                var elementSelector = '.js-productthumb-element';
                var containerSelector = '.js-product-list-ajax-add';
                var show = 'thumbs';

                if (!$j(elementSelector).length) {
                    elementSelector = '.js-os-productline-element';
                    show = 'table';
                }

                url =  decodeURIComponent(url);
                var tmpUrl = url;
                tmpUrl = tmpUrl.match(/p-(\d+?)\//).toString().split(',');
                var page = tmpUrl[1];

                dataJson = getUrlVars(
                    url,
                    {
                        'id' : id,
                        'key' : key,
                        'showtype': show
                    }
                );

                $j.ajax({
                    url: '/shop-product-list/ajax/p-'+page+'/',
                    data: dataJson
                }).done (function (data) {

                    $process = false;
                    var new_item = $j(data);
                    new_item.find(elementSelector).each( function(index, item) {
                        $j(containerSelector).before(' ').before(item).before(' '); // spaces for inline-block elements
                    });

                    productThumbSize();
                    $j("html, body").animate({scrollTop:$j(window).scrollTop() + 1}, 1); // 1px scroll to activate filter transform
                });
            }

        });

    }
    //---------------------------------------------------------------------------------//
}

// url format => json format
function getUrlVars(url, params) {
    var hash;
    var paramsJson = params;

    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        paramsJson[hash[0]] = hash[1];
    }
    return paramsJson;
}


/**
 * �������� ����������� ����� ���������, ����� �������� ������� ajax-��
 * @param nextLink
 */
function configurePagination( nextLink ) {
    // ������ ���������� ������
    var prevUrl = $j('.js-os-stepper .selected').attr('href');
    if ( $j('a[data-rel="prev"]').length ) {
        $j('a[data-rel="prev"]').attr( 'href', prevUrl );
    } else {
        $j('.js-os-stepper').prepend('<a href="' + prevUrl + '"id="back" data-rel="prev">&larr;�����</a>')
    }

    // ������ ��������� ������
    $j('.js-os-stepper a').removeClass('selected');
    nextLink.addClass('selected');

    // ������ ��������� ������
    if (nextLink.next() != 'undefined' &&  $j('a[data-rel="next"]').length) {
        $j('a[data-rel="next"]').attr('href', nextLink.next().attr('href'));
    }

    if (!nextLink.is(':visible')) {
        $j('.js-os-stepper a').each( function(index, item) {
            if (index > 0 && $j(this).is(':visible')) {
                $j(this).hide();
                return false;
            }
        });
        nextLink.show();
    }
}

$j(window).bind('load', function(){
    //menu
    if ($j('.js-category-nav').length) {
        //menu transformation
        var $nav = $j('.js-category-nav');
        var $sub = $nav.find('.sub');
        var navRightCoord = $nav.offset().left + $nav.width();

        $sub.show();
        menuCategoryRefactor();
        $sub.each(function(){
            var subTransition = parseInt($j(this).css('left')) * -1;
            var subRightCoord = $j(this).offset().left + $j(this).width();
            if (navRightCoord < (subRightCoord + subTransition)) {
                $j(this).css({
                    'left' : - (subRightCoord + subTransition - navRightCoord)
                });
            } else {
                $j(this).css({
                    'left' : 0
                });
            }
        });
        $sub.hide();
    }
});

// product thumb size
$j(window).bind('load', function(){
    productThumbSize();
    filterTransform();
});

function productThumbSize() {
    if ($j('.js-productthumb-element').length) {
        // ������ �������
        var availMaxHeight = 0;
        $j('.js-productthumb-element').each(function(){
            var availCurrentHeight = $j(this).find('.avail').height();
            if (availMaxHeight < availCurrentHeight) {
                availMaxHeight = availCurrentHeight;
            }
        });
        $j('.js-productthumb-element .js-avail').height(availMaxHeight);

        // ������ ������ ������� �������
        var quickHeight = $j('.js-productthumb-element .js-quick').height();
        $j('.js-productthumb-element .js-quick').height(quickHeight);

        // ������ ����� �����
        var elementMaxHeight = 0;
        $j('.js-productthumb-element .js-expanded').addClass('hidden');
        $j('.js-productthumb-element').each(function(){
            var elementCurrentHeight = $j(this).find('.wrapper').height();
            if (elementMaxHeight < elementCurrentHeight) {
                elementMaxHeight = elementCurrentHeight;
            }
        });
        $j('.js-productthumb-element').height(elementMaxHeight);
        $j('.js-productthumb-element .js-wrapper').css({'min-height' : elementMaxHeight});
        $j('.js-productthumb-element .js-expanded').removeClass('hidden');

        setTimeout(function(){
            $j('.js-productthumb-element').addClass('visible');
        }, 1000);
    }
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return '';
}

// �������� ����� � ���������
function shop_compare_add(event) {
    var productID = $j(event.target).closest('.js-shop-compare').data('productid');
    shop_compare_load(productID);

    event.preventDefault();
}

// ��������� ���������
function shop_compare_load(productID) {
    if (productID == undefined) {
        productID = 0;
    }
    var html = '';
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            productid: productID
        },
        success: function (data) {
            // ��������� ��� ������
            if (data.count > 0) {
                html += '<div class="os-compare-block ">';
                $j(data.productArray).each(function (i, e) {
                    var $button = $j('.js-shop-compare[data-productid='+e.id+']');
                    $button.find('.js-shop-compare-action').hide();
                    $button.find('.js-shop-compared').show();

                    html += '<div class="element">';
                    html += '<a href="javascript: deleteCompare('+e.id+');" class="remove">&nbsp;</a>';
                    html += '<a href="'+ e.url+'" data-productId="'+e.id+'">'+e.name+'</a>';
                    html += '</div>';
                });
                html = '<div class="os-caption-block">� ���������</div>'+html;
                html += '<div class="more"><a href="/compare/" class="os-submit">��������</a></div>';
                html += '</div>';

                $j('.js-compare-list').show();
                var compareBlock = $j(".js-compare-list");
                compareBlock.html(html);
            }
        }
    });
}

function deleteCompare (productId) {
    $j.ajax({
        url: "/ajax/compare/",
        dataType: "json",
        data: {
            'delete': productId
        },
        success: function (data) {
            var $button = $j('.js-shop-compare[data-productid='+productId+']');
            $button.find('.js-shop-compare-action').show();
            $button.find('.js-shop-compared').hide();
            shop_compare_load();
            $j(".id-"+productId).hide(400);
            if (data.count == 0) {
                $j('.js-compare-list').hide();
            }

            setTimeout(function(){
                $j(".id-"+productId).remove();
            }, 1000);
        }
    });
}

// @todo: refactoring
function commentParser() {
    var index = 'false';

    //document.location.href = '#';

    var commentIndex  = $j.cookie('comment');
    if (commentIndex == 'true' ) {
        $j.cookie('comment', index, {
            path: "/"
        });
        $j('.tab-content').hide();
        $j('.shop-block-comments').show();
        $j('.shop-tab-block a').removeClass('selected');
        $j("[data-rel = '.shop-block-comments']").addClass('selected');
        document.location.href='#id-tabs';
    }
}

function shop_filter_submit() {
    $j('.os-filter-block').addClass('load');
    $j('.os-filter-block .os-submit').click();
}

// @todo: wtf?
function commentPress() {
    var index = 'true';
    $j.cookie('comment', index, {
        path: "/"
    });
}

// ����������: ���� �� ������ ������ (� �������)
function shop_basket_buy(event) {
    var productID = $j(event.target).closest('.js-shop-buy').data('productid');
    var productCount = $j('.js-shop-buy-count').val();

    // ����� ������
    var productOptions = '';
    $j('.js-shop-buy-option').each(function (i, e) {
        var optionID = $j(e).data('optionid');
        var optionValue = $j(e).val();

        productOptions += optionID + ':' + optionValue + ';';
    });

    shop_basket_load(productID, productCount, productOptions);

    event.preventDefault();
}

// �������� ���������� �������
function shop_basket_popup() {
    popupOpen('.js-basket-popup');
}

// ��������� �������
function shop_basket_load(productID, productCount, productOptions) {
    if (productID == undefined) {
        productID = 0;
    }
    if (productCount == undefined) {
        productCount = 1;
    }
    if (productOptions == undefined) {
        productOptions = '';
    }

    $j.ajax({
        url: "/ajax/basket/",
        dataType: "json",
        data: {
            productid: productID,
            productcount: productCount,
            productoptions: productOptions
        },
        success: function (data) {
            // ��������� �������
            $j('.js-basket').html(data.html);

            // ���������� ���� �������
            if (data.productID > 0) {
                shop_basket_popup();
            }

            // ��������� ��� ������
            if (data.productIDArray) {
                var $buttonTemplate = $j('.js-basket-button-inbasket').html();

                $j(data.productIDArray).each(function (i, e) {
                    var $button = $j('.js-shop-buy[data-productid='+e+']');
                    $button.html($buttonTemplate);
                    $button.find('.js-shop-buy-action').on('click', shop_basket_buy);
                });

                //���������� ������� ����� - ��� ��������� ������ ��� �������� ������
                $j(data.productIDArray).each(function (i, e) {
                    var $button = $j('.js-shop-buy[data-productid='+e+']');
                    $button.html($buttonTemplate);
                    $button.find('.js-shop-buy-action').on('click', shop_basket_buy);
                });

                var productID = parseInt($j('#productPage').val());
                if (productID) {
                    $j(data.optionArray).each(function (z, e) {

                        for (var key in e) {
                            if (key == productID ) {
                                for (var ke in e[key]) {
                                    if (e[key][ke]['filtervalue']) {
                                        //������� ������ �� ����� � ����� �������� ������� ��������� ������� ��� �������� ����� ������
                                        $j('select.js-shop-buy-option[name=option-'+e[key][ke]['filterid']+']').val(e[key][ke]['filtervalue']).change();
                                    }
                                }
                            }
                        }
                    });
                }
            }

            // ���� �� ���� �������
            $j('#id-shop-basket .js-basketpopup-toggle').click(function () {
                shop_basket_popup();
                return false;
            });
        }
    });
}

// ����� os-popup-block open
function popupOpen(e) {
    $j(e).fadeIn();
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.popup-block');
    var popupHeight = popupBlock.height();
    popupBlock.css({
        'top' : - popupHeight
    });
    popupBlock.animate({
        'top': 0
    }, 500);
}

// ����� os-popup-block close
function popupClose(e) {
    var scrltp = $j(window).scrollTop();
    var popupBlock = $j(e).find('.popup-block');
    var popupHeight = popupBlock.height();
    var popupTopPadding = 100;
    popupBlock.animate({
        'top': - popupHeight - popupTopPadding
    }, 500);
    setTimeout(function(){
        $j(e).fadeOut();
    }, 500);
}

// ������ ���������� �������
function shop_basket_popup_close() {
    $j('.os-popup-block .close').click();
    return false;
}

function productsNoticeOfAvailability() {
    var email = $j('#email').val();
    var name =  $j('#name').val();
    var productid =  $j('#productid').val();
    $j.ajax({
        url: '/noticeofavailabilityajax/',
        type:'POST',
        dataType: "json",
        data: {
            productid: productid,
            email: email,
            name: name
        },

        success: function(x) {
            if (x.send == true) {
                popupOpen('#id-notice-of-availability-success');
                popupClose('#id-notice-of-availability');
            } else {
                popupOpen('#id-notice-of-availability');
                $j('#id-notice-of-availability-error').show();
                $j('#id-notice-of-availability-error-name').hide();
                $j('#id-notice-of-availability-error-email').hide();
                if (x.error == 'name') {
                    $j('#id-notice-of-availability-error-name').show();
                }
                if (x.error == 'email') {
                    $j('#id-notice-of-availability-error-email').show();
                }
            }
        },
        fail: function() {
            alert('Request failed');
        }
    });
}

// @todo: use jquery toggleClass()
function toggleElement(e){
    if ($j(e).is('.selected')) {
        $j(e).removeClass('selected');
    } else {
        $j(e).addClass('selected');
    }
}

//menu hover dropdown function
function menuHover() {
    var $navElement = $j('.js-category-nav').find('.nav-element');

    $navElement.hover(function(){
        var $this = $j(this);
        $this.addClass('js-hover');
        setTimeout(function(){
            if ($this.hasClass('js-hover')) {
                $this.find('.sub').fadeIn(200);
                $this.addClass('hover');
            }
        }, 500);
    }, function(){
        var $this = $j(this);
        $this.removeClass('js-hover');
        setTimeout(function(){
            if ($this.hasClass('js-hover')) {
                return;
            } else {
                $this.find('.sub').fadeOut();
                $this.removeClass('hover');
            }
        }, 500);
    });

    if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
        $navElement.find('.element-inner>a').click(function(){
            $j(this).next('.sub').fadeToggle();
            return false;
        });
    }
}

function menuCategoryRefactor() {
    $j('.js-category-list').each(function(){
        var maxGridSize = 4;
        var columnLength = 10;
        var categoryCount = $j(this).find('.level-1, .level-2').length;
        var categoryLevelFirstCount = $j(this).find('.level-1').length;
        if (categoryLevelFirstCount < maxGridSize) {
            maxGridSize = categoryLevelFirstCount;
        }

        var gridSize = Math.ceil(categoryCount / columnLength);
        if (gridSize > maxGridSize) {
            gridSize = maxGridSize;
        }

        $j(this).addClass('x'+ gridSize);
    });

    $j('.js-category-list').masonry({
        itemSelector: 'li'
    });
}

// filter transform
function filterTransform(){
    if ($j('.js-wrap-filter').length) {
        var $wrap = $j('.js-wrap-filter');

        if ($wrap.length) {
            var wrapTop = $wrap.offset().top;

            var $filter = $j('.js-block-filter');
            var filterHeight = $filter.height();
            var filterTop = $filter.offset().top;
            var filterBottom = filterHeight + filterTop;

            var $productList = $j('.js-product-list');
            var productListHeight = $productList.height();


            var filterBottomCompensate = 0;

            if (productListHeight > filterHeight) {
                leftAsideTransform();

                $j(window).bind('resize scroll', function() {
                    leftAsideTransform();
                });
            }
        }
    }

    function leftAsideTransform(){
        productListHeight = $productList.height();
        $wrap.height(productListHeight);

        var wrapHeight = $wrap.height();
        var wrapBottom = wrapTop + wrapHeight;

        var frame = $j(window);
        var frameTop = frame.scrollTop();
        var frameHeight = frame.height();
        var frameBottom = frameTop + frameHeight;

        if (frameTop > wrapTop) {
            $filter.addClass('slideable');
        } else {
            $filter.removeClass('slideable');
        }

        if (wrapBottom < frameBottom) {
            filterBottomCompensate = frameBottom - wrapBottom;
        } else {
            filterBottomCompensate = 0;
        }

        if (frameBottom > filterBottom) {
            $filter.css({
                'top' : frameBottom - filterBottom - filterBottomCompensate
            });
        }
    }
}

function basket_order_quick (productId, productName) {
    $j('input[name="productid"]').val(productId);
    $j('#quickOrderProductName').text(productName);
    popupOpen('.js-popup-quickorder');
}

// header transformation
function headerTransform() {
    if ($j('.js-header').length) {
        if ((pgwBrowser.os.group == 'Android') || (pgwBrowser.os.group == 'Windows Phone') || (pgwBrowser.os.group == 'iOS') || (pgwBrowser.os.group == 'BlackBerry')) {
            return false; // ��������� ��� ��������� ��������
        }

        var autocompleteTopTrue = $j('.js-input-search').outerHeight() + $j('.js-input-search').offset().top;
        var headerHeight = $j('.js-header').outerHeight();
        var $headerWraper = $j('.js-header-wrap');
        $headerWraper.height(headerHeight);
        var headerStartPoint = $j('.js-header-wrap').offset().top;
        var headerEndPoint = $j('.js-header-wrap').height() + $j('.js-header-wrap').offset().top;

        var lastScrollTop = 0;
        var revert = false;
        $j(window).scroll(function(event){
            var currentScrollTop = $j(this).scrollTop();

            if (currentScrollTop > lastScrollTop){
                // ����
                if (currentScrollTop > headerEndPoint) {
                    $headerWraper.addClass('os-fixed-header');
                    $headerWraper.addClass('os-transform-header');
                    revert = true;
                }

                $headerWraper.removeClass('show');

                lastScrollTop = currentScrollTop - 1; // fix for ie
            } else {
                //�����
                if (currentScrollTop < headerEndPoint) {
                    $headerWraper.removeClass('os-transform-header');
                }
                if (currentScrollTop > headerStartPoint) {
                    if (revert) {
                        $headerWraper.addClass('os-fixed-header');
                    }
                } else {
                    $headerWraper.removeClass('os-fixed-header');
                }

                $headerWraper.addClass('show');

                if (currentScrollTop == 0) {
                    revert = false;
                }

                lastScrollTop = currentScrollTop;
            }

            var autocompleteTop = $j('.ui-autocomplete').offset().top;
            if (autocompleteTop > autocompleteTopTrue) {
                $j('.js-input-search').autocomplete("close");
            }
        });
    }
}

function productAutocomplete() {
    // search
    // ���� ���������� ����
    if($j('.js-input-search').length){
        $j('.js-input-search').each(function(){
            $j(this).autocomplete({
                source: function( request, response ) {

                    $j.ajax({
                        url: "/search/jsonautocomplete/",
                        dataType: "json",
                        data: {
                            name: request.term
                        },
                        background: true,
                        success: function (data) {
                            if (data==null) {
                                response(null);
                            }
                            response( $j.map( data, function( item ) {
                                return {
                                    label: item.name,
                                    image: item.image,
                                    description: item.description,
                                    url: item.url
                                }
                                return item.name;
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    document.location = ui.item.url;
                },
                minLength: 3
            }).data('ui-autocomplete')._renderItem = function (ul, item) {
                var imageHtml = '';
                if (item.image) {
                    imageHtml = '<img src="' + item.image + '" />';
                } else {
                    imageHtml = '<img src="/media/shop/stub.jpg" style="max-width: 50px; max-height: 50px;" />';
                }
                var inner_html = '<a class="os-autocoplete-element"><span class="image">'+imageHtml+'<span></span></span><span class="description"><span class="name">' + item.label + '</span>' + item.description + '</span><span class="clear"></span></a>';
                ul.css('z-index','9999');

                return $j( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append(inner_html)
                    .appendTo( ul );
            };
        });
    }
}