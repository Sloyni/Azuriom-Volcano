var nav_active = false;
$("#mobile-btn").click(function (e) {
    e.preventDefault();

    if(nav_active){
        nav_active = false;
        $("#nav-btn-icon").html('<i class="fas fa-bars"></i>');
        $("#mobile-nav").css("transform", "translateX(-100vw)");
    } else {
        nav_active = true;
        $("#nav-btn-icon").html('<i class="fas fa-times"></i>');
        $("#mobile-nav").css("transform", "translateX(0px)");
    }
});

$("#go-to-bottom").click(function () {
    $('html, body').animate({
        scrollTop: $("#go-to-bottom-div").offset().top
    });
});