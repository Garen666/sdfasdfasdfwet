$j(function() {
    $j('#js-input-game-search').keypress(function () {
        var search = $j('#js-input-game-search').val();

        if (search.length > 1) {

            $j(".js-game-item").each(function(i, item) {
                var search = $j('#js-input-game-search').val();
                var name = $j(item).data("name");
                console.log(name);
                console.log();

                if (name.search(search)) {
                    $j(item).hide();

                } else {
                    $j(item).show();

                }
            });

        } else {
            $j(".js-game-item:hidden").show();
        }
    });
});