function showabout(){
    $("#about_container").css("display","inherit");
    $("#about_container").css("width","80vh");
    $("#about_container").addClass("animated slideInLeft");
    setTimeout(function(){
        $("#about_container").removeClass("animated slideInLeft");
    },800);
}
function closeabout(){
    $("#about_container").addClass("animated slideOutLeft");
    setTimeout(function(){
        $("#about_container").removeClass("animated slideOutLeft");
        $("#about_container").css("display","none");
    },800);
}
function showproject(){
    $("#project_container").css("display","inherit");
    $("#project_container").css("width","80vh");
    $("#project_container").addClass("animated slideInLeft");
    setTimeout(function(){
        $("#project_container").removeClass("animated slideInLeft");
    },800);
}
function closeproject(){
    $("#project_container").addClass("animated slideOutLeft");
    setTimeout(function(){
        $("#project_container").removeClass("animated slideOutLeft");
        $("#project_container").css("display","none");
    },800);
}
function showcontact(){
    $("#contact_container").css("display","inherit");
    $("#contact_container").css("width","80vh");
    $("#contact_container").addClass("animated slideInLeft");
    setTimeout(function(){
        $("#contact_container").removeClass("animated slideInLeft");
    },800);
}
function closecontact(){
    $("#contact_container").addClass("animated slideOutLeft");
    setTimeout(function(){
        $("#contact_container").removeClass("animated slideOutLeft");
        $("#contact_container").css("display","none");
    },800);
}
setTimeout(function(){
    setTimeout(function(){
      $("#about").removeClass("animated fadeIn");
      $("#contact").removeClass("animated fadeIn");
      $("#project").removeClass("animated fadeIn");
    },1000);
},1500);


