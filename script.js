//----------------点击哪个页面哪个页面就换底色
$(".plaque").on({
    "click": function () {
        $(this).addClass("page").siblings().removeClass("page");
    }
});
//----------------点击哪个页面就显示哪个页面，隐藏其余页面
$("#pageAcc").on({
    "click": function () {
        $("#accueil").css("display", "flex");
        $("#recherche,#discussion").css("display", "none");
    }
});
$("#pageRec").on({
    "click": function () {
        $("#accueil,#discussion").css("display", "none");
        $("#recherche").css("display", "flex");
    }
});
$("#pageDis").on({
    "click": function () {
        $("#accueil,#recherche").css("display", "none");
        $("#discussion").css("display", "block");
    }
});
//----------------发表评论
$("#bCom").on({
    "click": function () {
        /*
        $("#listCom").append("<li>" + $("#commentaire").val() + "</li>");
        $("#commentaire").val("");
        */
        window.location.reload();
        $("#accueil,#recherche").css("display", "none");
        $("#discussion").css("display", "block");
    },
});