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
        // 建立实习信息的数据表格，并写入页面
        ajax = $.ajax({
            url: 'recherche_yuhe.php',
            type: 'post',
            dataType: 'html',
            success: function (data) {  //如果请求成功，返回数据。
                var t = "<tr><th>Numéro</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
                var html = "";
                html += data;
                $("#tableAffiche").html(t);
                $("#tableAffiche").append(html); //在html页面id=tableAffiche的标签里显示html内容

            },
        });

        //确保ajax请求完毕时执行
        $.when(ajax).done(function () {
            $.ajax({
                url: 'actions/nbWebscrap.php',
                type: 'get',
                dataType: 'html',
                success: function (data) {  //如果请求成功，返回数据。
                    $("#nbWebscrap").html(data);
                },
            });

        });


    }
});

$("#btRec").on({
    "click": function () {
        // 发送选项数据，从数据库中选择内容，写入网页
        var arry = new Array();
        $('input[name="M[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val1 = arry.join("|");

        var arry = new Array();
        $('input[name="F[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val2 = arry.join("|");

        $.ajax({
            url: 'actions/action.php',
            type: 'post',
            dataType: 'html',
            data: { 'ficm': val1, 'ficf': val2 },
            success: function (data) {  //如果请求成功，返回数据。
                var html = "<tr><th>Numéro</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
                $("#tableAffiche").html(html); //在html页面id=tableAffiche的标签里显示html内容
                $("#tableAffiche").append(data);
                $("#tableAffiche").append("<br/>Success! Votre choix :<br/>");
                $("#tableAffiche").append(val1 + val2);
            },
        });
    }
});

$("#pageDis").on({
    "click": function () {
        $("#accueil,#recherche").css("display", "none");
        $("#discussion").css("display", "block");
        $.ajax({
            url: 'discussion_yuhe.php',
            type: 'get',
            dataType: 'html',
            success: function (data) {  //如果请求成功，返回数据。
                $("#listCom").html(data);
                data = "";
            },
        });
    }
});
//----------------发表评论
$("#bCom").on({
    "click": function () {
        
        let paroles = $("#commentaire").val();
        let username = $("#phpUsername").val();
        $.ajax({
            url: 'actions/discuter.php',
            type: 'post',
            dataType: 'html',
            data: {'par': paroles, 'user': username },
            success: function (data) {  //如果请求成功，返回数据。
                $("#listCom").html(data);
                $("#commentaire").val('');
            },
        });
        
    },
});
