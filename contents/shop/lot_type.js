$j(function () {
   $j('.js-tr-lot-list').click(function (event) {
       return location.href = $j(this).data('href');
   });
});