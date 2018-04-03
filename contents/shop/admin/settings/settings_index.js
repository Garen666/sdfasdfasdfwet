$j(function () {
    jQueryTabs.TabMenu($j('.settings-tab'), $j('.js-tabselect').val());

    $j('.js-cash-clear-no').click(function(e) {
       $j("[data-rel='#settings-tab-0']").click();
    });
});