<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Internshiplz </title>
    <!-- ajout des css ci-dessous -->
    <link rel="stylesheet" type="text/css" media="all" href="main_posi.css" />
    <link rel="stylesheet" type="text/css" media="all" href="main_style.css" />
    <script type:"text/javascript" src="jquery-3.6.0.min.js"></script>
</head>

<body>
    <div id="begin">
        <div id="icone"><img src="UGA.jpg" id="imguga">Internshiplz</div>
        <div id="menu">
            <li class="plaque" id="pageAcc"> Accueil </li>
            <!--
            <li class="plaque" id="pageRec"> Recherche </li>
            <li class="plaque" id="pageDis"> Discussion </li>
-->
        </div>
        <div id="user">
            Non connecté
        </div>

    </div>

    <?php include "templates/accueil.php" ?>
    <script type="text/javascript" src="script.js" ></script>
</body>

</html>