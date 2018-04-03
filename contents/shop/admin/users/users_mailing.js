$j(function() {
    // для блока с полями для файлов
    $j('#js-toggle-files').click(function(e){
        e.preventDefault();
        $j('.js-files-block').toggle();
    });
});
