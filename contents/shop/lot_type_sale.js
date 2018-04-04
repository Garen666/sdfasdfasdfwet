$j(function () {
    $j("#js-lot-save").submit(function() {

        $j('.js-checkbox-active:checked').each(function (i, elem) {
            $j(elem).next().val(1);
        });
    });
});


