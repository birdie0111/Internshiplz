//----------------点击哪个页面哪个页面就换底色
$(".plaque").on({
    "click": function () {
        $(this).addClass("page").siblings().removeClass("page");
    }
});

//----------------点击哪个页面就显示哪个页面，隐藏其余页面
$("#pageAcc").on({
    "click": function () {
        $("#content").css("display","block");
        $("#recherche,#discussion").css("display", "none");
        // obtenir les informations du site
        $.ajax({
            url: 'actions/etatSite.php',
            type: 'get',
            dataType: 'html',
            success: function (data) {  //如果请求成功，返回数据。
                if (data != null) {
                    var str = new Array();
                    str = data.split(",");
                    var nbCompte = str[0];
                    var nbCommentaire = str[1];
                    $("#nbCompte").html(nbCompte);
                    $("#nbCommentaire").html(nbCommentaire);
                }
            },
        });
    }
});

$("#pageRec").on({
    "click": function () {
        $("#content,#discussion").css("display", "none");
        $("#recherche").css("display", "flex");
        console.log("research entered");
        // 建立实习信息的数据表格，并写入页面
        ajax = $.ajax({
            url: 'actions/rechercher.php',
            type: 'post',
            dataType: 'html',
            success: function (data) {  //如果请求成功，返回数据。
                var t = "<tr><th>n°</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
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

        var arry = new Array();
        $('input[name="T[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val3 = arry.join("|");

        var arry = new Array();
        $('input[name="A[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val4 = arry.join("|");

        var arry = new Array();
        $('input[name="Tele[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val5 = arry.join("|");

        var arry = new Array();
        $('input[name="R[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val6 = arry.join("|");

        var arry = new Array();
        $('input[name="L[]"]:checked').each(function () {
            arry.push($(this).val());
        });
        var val7 = arry.join("|");

        $.ajax({
            url: 'actions/action.php',
            type: 'post',
            dataType: 'html',
            data: { 'ficm': val1, 'ficf': val2, 'fictemps': val3, 'fica': val4, 'fictele': val5, 'ficr': val6, 'ficl': val7 },
            success: function (data) {  //如果请求成功，返回数据。
                var html = "<tr><th>n°</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
                $("#tableAffiche").html(html); //在html页面id=tableAffiche的标签里显示html内容
                $("#tableAffiche").append(data);
                /*
                $("#tableAffiche").append("<br/>Success! Votre choix :<br/>");
                $("#tableAffiche").append(val1 + val2 + val3 + val4 + val5  + val6 + val7);
                */
            },
        });
    }
});

$("#btSau").on({
    "click": function () {
        
        var arryPath = [];

        $('.fakePath').each(function () {
            arryPath.push($(this).text());
        });

        for(var i = 0; i < arryPath.length; i++){
            arryPath[i] = arryPath[i].replace("fichier_txt", "text_files");
        }
        /* codes marchent pas
        arryPath.forEach(function (value) {
            value = value.replace("fichier_txt", "text_files");
        });
        */
        for(var i = 0; i < arryPath.length; i++){
            url = "http://i3l.univ-grenoble-alpes.fr/~tangyuhe/Intershiplz-main-8/"+arryPath[i];
            window.location.href = url;
        }

    }
});

$("#pageDis").on({
    "click": function () {
        $("#content,#recherche").css("display", "none");
        $("#discussion").css("display", "block");
        $.ajax({
            url: 'actions/EnvoyerComm.php',
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
            data: { 'par': paroles, 'user': username },
            success: function (data) {  //如果请求成功，返回数据。
                $("#listCom").html(data);
                $("#commentaire").val('');
            },
        });

    },
});
