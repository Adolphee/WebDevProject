$(function(){
   //Ik heb deze animatie ...
   //$("#sidebarCollapse").css("margin-left", "-250px");
   $("#sidebar").css("margin-left", "-250px");
   animateIntro(); //.. gemaakt om de user te tonen waar de sidebar is.

    
    var sidebarVisible = false;
   $("#sidebarCollapse").on('click', function(){
      if(!sidebarVisible){//Is de sidebar niet zichtbaar? -> zichtbaar maken
        $("#sidebar").animate({
         marginLeft: "+=250px"
        }, {duration: 50, queue: false}); //queue afzetten want ...
        $("#topBar").animate({
            left: "+=230px",
            width: "-=230px"
        }, {duration: 50, queue: false}); // ... want de bovenste balk moet simultaan krimpen
        $("#sidebarCollapse").html("Hide Menu"); //Button tekst aanpassen
        sidebarVisible = true;
      } else { //De sidebar verbergen als hij al zichtbaar was
        $("#sidebar").animate({
         marginLeft: "-=250px"
        }, {duration: 50, queue: false}); //queue afzetten want ...
        $("#topBar").animate({
            left: "-=230px",
            width: "+=230px"
        }, {duration: 50, queue: false});// ... want de bovenste balk moet simultaan groeien
        $("#sidebarCollapse").html("Show Menu"); //Button tekst aanpassen
        sidebarVisible = false;
      }
   });

    //Als iets in de sidebar gedrukt wordt moet de class "active" daar aan
    //worden doorgegeven

    //UPDATE: Deze handler is eigenlijk niet meer nodig
    /*var isAlreadyActive1 = false;
    $(".subMenuItem > .subMenuDD1").on("click", function(){
      var thisBtn = $(".subMenuDD1");
      var otherBtn = $(".subMenuDD2");
      /* Eerst wil ik wel dat, indien het gaat om de
         login (X) of trending (Y) knop:
         als X geklikt wordt terwijl Y open staat
         dan moet Y automatisch zijn contents verbergen en omgekeerd.
         aangezien die sidebar via bootstrap gemaakt is heb ik gekozen
         om de element-properties naar behoren aan te passen en
         de animatie aan bootstrap over te laten.
        *//*
        if(isAlreadyActive1 == false){
          if(!$(".subMenuDD2").hasClass("collapsed") || $(".subMenuDD2 ~ ul").hasClass("show")){
              $(".subMenuDD2").attr("aria-expanded", "true");
              $(".subMenuDD2").addClass("collapsed");
              $(".subMenuDD2 ~ ul").removeClass("show");
              $(".subMenuDD2 ~ ul").addClass("collapse");
              isAlreadyActive2 = false;
          }
          isAlreadyActive1 = true;
        }
        $(".subMenuItem.active").removeClass("active").blur();
        thisBtn.parent("ul").addClass("active");
    });*/

    //UPDATE: Deze handler is eigenlijk niet meer nodig
    /*var isAlreadyActive2 = false;
    $(".subMenuItem > .subMenuDD2").on("click", function(){
      var thisBtn = $(".subMenuDD2");
      var otherBtn = $(".subMenuDD1");
      /* Eerst wil ik wel dat, indien het gaat om de
         login (X) of trending (Y) knop:
         als X geklikt wordt terwijl Y open staat
         dan moet Y automatisch zijn contents verbergen en omgekeerd.
         aangezien die sidebar via bootstrap gemaakt is heb ik gekozen
         om de element-properties naar behoren aan te passen en
         de animatie aan bootstrap over te laten.
        *//*
        if(isAlreadyActive2 == false){
          if(!$(".subMenuDD1").hasClass("collapsed") || $(".subMenuDD1 ~ ul").hasClass("show")){
              $(".subMenuDD1").attr("aria-expanded", "true");
              $(".subMenuDD1").addClass("collapsed");
              $(".subMenuDD1 ~ ul").removeClass("show");
              $(".subMenuDD1 ~ ul").addClass("collapse");
              isAlreadyActive1 = false;
          }
          isAlreadyActive2 = true;
        }
        $(".subMenuItem.active").removeClass("active").blur();
        thisBtn.parent("ul").addClass("active");
    });*/

    /* Binnen de sidebar heb ik een loginForm gezet, deze methode activeert het */
    var loginVisible = false;
    $("#dropdown-login").on('click', function(){
        $("li.active").removeClass("active");
        $(this).addClass("active");
        if(!loginVisible){
        $("#sidebar-login").slideUp;
        loginVisible = true;
      } else {
        $("#sidebar-login").slideDown;
        loginVisible = false;
      }
    });

    function animateIntro(){
        $("#sidebar").animate({
            //marginLeft: "-=250px",
            opacity: "+=1"
        }, false);

        $("#sidebarCollapse").animate({
            opacity: "+=1"
        }, false);

        $("#topBar").animate({
           width: "100%",
           //marginLeft: "-=230px"
       }, "falst", false);
   }

});
