$(function() {

    $(".form").hide();
    $(".form").fadeIn(1500);
    // $("#btn-mid").on( "hover", function() {
    //   $("#btn-mid").animate({
    //     width: ["-=50","swing"]
    //   }, 300);
    // });

    $("#btn-mid").hover(function(){
      var a = $("#btn-mid");

      a.css("color": "lime");
    });
});
