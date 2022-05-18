//----------------bouton couleur change avec la page
$(".plaque").on({
    "click": function () {
        $(this).addClass("page").siblings().removeClass("page");
    }
});

//----------------page show, les autres pages hide + fonctions des pages
$("#pageAcc").on({ // page "accueil"
    "click": function () {
        $("#content").css("display","block");
        $("#recherche,#discussion").css("display", "none");
        // obtenir les informations du site
        $.ajax({
            url: 'actions/etatSite.php',
            type: 'get',
            dataType: 'html',
            success: function (data) {
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

$("#pageRec").on({ // page "recherche"
    "click": function () {
        $("#content,#discussion").css("display", "none");
        $("#recherche").css("display", "flex");
        console.log("research entered");
        // établir tableau InfoStage, l'écrire dans page recherche
        ajax = $.ajax({
            url: 'actions/rechercher.php',
            type: 'post',
            dataType: 'html',
            success: function (data) {
                var t = "<tr><th>n°</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
                var html = "";
                html += data;
                $("#tableAffiche").html(t);
                $("#tableAffiche").append(html); // show html dans id=tableAffiche

            },
        });
        
        $.when(ajax).done(function () { // marcher quand ajax fini
            $.ajax({                    // obtenir nb de résultats de webscraping
                url: 'actions/nbWebscrap.php',
                type: 'get',
                dataType: 'html',
                success: function (data) {
                    $("#nbWebscrap").html(data);
                },
            });

        });


    }
});

$("#btRec").on({ // bouton "rechercher"
    "click": function () {
        // envoyer les choix + choisir info dans DB + écrire dans page recherche
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
            success: function (data) {
                var html = "<tr><th>n°</th><th>Titre</th><th>Date</th><th>Organisme</th><th>Niveaux d'études</th><th>Filière</th><th>Lieu</th><th>Fichier</th></tr>";
                $("#tableAffiche").html(html);
                $("#tableAffiche").append(data);
                /* pour vérifier les choix :
                $("#tableAffiche").append("<br/>Success! Votre choix :<br/>");
                $("#tableAffiche").append(val1 + val2 + val3 + val4 + val5  + val6 + val7);
                */
            },
        });
    }
});
//---------------- envoyer tous commentaires dans page discussion
$("#pageDis").on({  // page discussion
    "click": function () {
        $("#content,#recherche").css("display", "none");
        $("#discussion").css("display", "block");
        $.ajax({
            url: 'actions/EnvoyerComm.php',
            type: 'get',
            dataType: 'html',
            success: function (data) {
                $("#listCom").html(data);
                data = "";
            },
        });
    }
});
//---------------- envoyer un nouveau commentaire
$("#bCom").on({  // bouton "envoyer"
    "click": function () {

        let paroles = $("#commentaire").val();
        let username = $("#phpUsername").val();
        $.ajax({
            url: 'actions/discuter.php',
            type: 'post',
            dataType: 'html',
            data: { 'par': paroles, 'user': username },
            success: function (data) {
                $("#listCom").html(data);
                $("#commentaire").val('');
            },
        });

    },
});
