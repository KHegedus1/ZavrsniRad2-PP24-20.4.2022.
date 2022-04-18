$(".removeFromCart").on("click", function () {
  let proizvodSifra = $(this).data("sifra");
  $.ajax({
    url: "/narudzba/removefromcart/" + proizvodSifra,
    success: function (result) {
      if (result == "OK") {
        $.ajax({
          url: "/narudzba/brojjedinstvenihproizvoda/",
          success: function (result) {
            if (result == 0) {
              $("#content").load(location.href + " #content>*", "");
            }
          },
        });
        $("#shopping-icon").load(location.href + " #shopping-icon>*", "");
        $("#product" + productId).remove();
        $("#sumTotal").load(location.href + " #sumTotal", "");
      }
    },
  });
});