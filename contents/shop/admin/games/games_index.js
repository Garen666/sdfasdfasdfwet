$j(function() {
    // �������������� ������� ������� �������
    $j('input#id_search').keyup(function() {
        $j('.js-tree-menu .sub').show();
        $j('.js-tree-menu u').addClass('down');
        jQueryFilter.categorySearch('.list .item', this);
    });
});

$j(function () {
    $j('.js-checkbox').change(function () {
        var ids = '';

        $j('.js-checkbox').each(function (i, e) {
            if (e.checked) {
                ids += $j(e).val();
                ids += ',';
                $j(this).closest('.element').addClass('selected');
            } else {
                $j(this).closest('.element').removeClass('selected');
            }
        });

        $j('#id-category').val(ids);
    });

    // ����������, �������� ��������� ��� ������� ������
    if ( $j('.js-show-products').length ){
        $j('.js-show-products').click( function(){
            if ($j(this).is(':checked')) {
                $j(this).val(1);
            } else {
                $j(this).val(0);
            }
        });
    }
});

$j(function(){
    $j('.js-draggable').mouseup(function(){
        var dropOn = $j('.droppable-hover');// ������� �� ������� �������
        var movable = $j(this); // ������� ������� �������������
        if (dropOn.length && movable.length){
            var isProduct = 0; // ��� ����������� ���� ��� ������������� (��������� ��� �������)
            if (movable.hasClass("js-draggable-product")){
                isProduct = 1;
            }
            $j(movable).hide('slow');
            var droponId = dropOn.attr('js-data-id');
            var mevedId = movable.attr('js-data-id');
            if ( isProduct == 1 || droponId != mevedId ){
                $j.ajax({
                    url: '/admin/shop/manage/products/ajax/',
                    data: {
                        dropOnId: droponId,
                        movedId: mevedId,
                        isProduct: isProduct
                    },
                    dataType: 'json',
                    success: function(json) {
                        movable.remove();
                        // ���� ������������� ���������
                        if ( isProduct == 0) {
                            rebuildCategoryTree();
                            // ��������� ����������� ������ �������� �� ����
                            setTimeout(function () {
                                $j('.js-tree-menu .item').droppable({
                                    activeClass: "droppable",
                                    hoverClass: "droppable-hover"
                                });
                            }, 1000);
                        }
                    },
                    error: function(err, msg) {
                        console.log(msg);
                    }
                });
            }
        }
    });
});

function rebuildCategoryTree() {
    // id ������� ���������
    var categoryid = $j("#js-open-category-id").attr('category-id');
    $j.ajax({
        url: '/admin/shop/rebuild/categorytree/',
        data :{
            categoryid: categoryid
        },
        dataType: 'json',
        success: function( json ) {
            $j(".js-tree-menu").empty();
            $j(".js-tree-menu").html(json.html);

            // ������o������ ������
            $j('.js-tree-menu').find('u').each(function(){
                var menuID = $j(this).data('id');
                var childCount = $j('.js-tree-menu div[data-parentid="'+menuID+'"]').length;
                if (childCount === 0) {
                    $j(this).hide();
                }
            });

            $j('.js-tree-menu .item u').click(function(){
                var menuID = $j(this).data('id');
                $j(this).toggleClass('down');
                $j('.js-tree-menu div[data-parentid="'+menuID+'"]').slideToggle();
            });

        },
        error: function( data, error, errrDet ) {

        }
    });

}


function cookieFromTreemenu(){
    var ch = [];
    $j(".js-tree-menu .sub").each(function(){
        if($j(this).is(":visible")){
            ch.push($j(this).data("parentid"));
        }
    });
    $j.cookie("treemenuCookie", ch.join(','));
}

function treedataFromCookie(){
    if($j.cookie("treemenuCookie") == null){
        return;
    }
    var chMap = $j.cookie("treemenuCookie").split(',');
    for (var i in chMap) {
        //alert(chMap[i]);
        $j(".js-tree-menu .sub[data-parentid='"+chMap[i]+"']").show();
        $j(".js-tree-menu u[data-id='"+chMap[i]+"']").addClass('down');
    }
}

function clearCookie(){
    $j.cookie("treemenuCookie", null);
}

$j(function() {
    treedataFromCookie();

    $j(".js-tree-menu u").click(function(){
        setTimeout("cookieFromTreemenu();", 2000);
    });
});

$j(function () {
    $j('.js-checkbox').each(function (i, checkbox) {
        $j(checkbox).click(function() {
            recalculate_checkbox();
        });
    });
});

// ������������� checkbox�
function recalculate_checkbox() {
    var s = '';
    $j('.js-checkbox').each(function (i, checkbox) {
        if (checkbox.checked) {
            s += checkbox.value;
            s += ',';
        }
    });

    $j('#id-checkboxes').val(s);

    if (s != '') {
        $j('#id-form-delete').show();
    } else {
        $j('#id-form-delete').hide();
    }
}

// ���������� ����� ���������
$j(function() {

    $j('.js-add-new-category').click(function() {

        var categoryName = prompt('������� ��� ����� ���������');

        if (categoryName != null) {

            var parentID = $j(this).attr('js-data-id');

            $j.ajax({
                url: '/admin/add/new/category/ajax/',
                data: {
                    name: categoryName,
                    parentID: parentID
                },
                dataType: 'json',
                success: function(result) {
                    if (result == 'ok') {
                        location.reload();
                    }
                }
            })
        }
        return false;
    })
});