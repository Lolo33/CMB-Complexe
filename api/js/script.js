/**
 * Created by Niquelesstup on 28/08/2017.
 */
$(function () {
    var $window = $(window);
    $window.scroll(function () {
        majCategoriesMenu();
    });
});

majCategoriesMenu();

function majCategoriesMenu() {
    var $window = $(window);
    var scrollLenght = parseInt($window.scrollTop());
    var recup_liste = $("#recup-liste");

    if (scrollLenght >= parseInt($("#structure").position().top)) {
        $(".sous-menu-item-active").addClass("sous-menu-item").removeClass("sous-menu-item-active");
        $("#structure-item").addClass("sous-menu-item-active");
    }
    if (scrollLenght >= parseInt(recup_liste.position().top)) {
        $(".sous-menu-item-active").addClass("sous-menu-item").removeClass("sous-menu-item-active");
        $("#recup-item").addClass("sous-menu-item-active");
    }
    if (scrollLenght >= parseInt($("#recup-one").position().top)){
        $(".sous-menu-item-active").addClass("sous-menu-item").removeClass("sous-menu-item-active");
        $("#recup-one-item").addClass("sous-menu-item-active");
    }
}

$(".sous-menu-item").click(function () {
    $(".sous-menu-item-active").addClass("sous-menu-item").removeClass("sous-menu-item-active");
    $(this).addClass("sous-menu-item-active");
});