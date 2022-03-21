<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Internshiplz </title>
    <!-- ajout des css ci-dessous -->
    <link rel="stylesheet" type="text/css" media="all" href="main_posi.css" />
    <link rel="stylesheet" type="text/css" media="all" href="main_style.css" />
    <script type:"text/javascript" src="jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="script.js" ></script>
</head>

<body>

<?php 


    

    if(isset($_GET["connected"])){
        $db_host = "localhost";
        $db_user = "liuqinyu";
        $db_pwd = "L9Q9Y0l1qy;:";
        $db_name = "liuqinyu";
        $db_port = 3306;
        $username = $_GET['connected'];
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $connect = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
        mysqli_set_charset($connect, 'utf8mb4');


        // verifier la connection
        if(!$connect){
            die("error while connecting to the database: ".mysqli_connect_error());
        }

        // enregistrer les commentaires
        if(isset($_POST["commentaire"])){
            $query = "select * from Comments where Comment = '".$_POST['commentaire']."'"."and Username = '".$username."';";

            $result = mysqli_query($connect,$query);

            # Si un nouvel commentaire a ete ecrit:
            if($result->num_rows == 0){
                $query = 'INSERT INTO Comments(Username,Comment) VALUES("'.$username.'","'.$_POST["commentaire"].'");';
               
                $result = mysqli_query($connect,$query);
            }
        }
        

        // prend les commentaires
        $query = "select * from Comments;";
        $result = mysqli_query($connect,$query);

        
        print '
        <div id="begin">
            <div id="icone"><img src="UGA.jpg" id="imguga">Internshiplz</div>
            <div id="menu">
                <li class="plaque" id="pageAcc"> Accueil </li>
                <li class="plaque" id="pageRec"> Recherche </li>
                <li class="plaque" id="pageDis"> Discussion </li>
            </div>
            <div id="user">
                Connecté
                <?php echo "Bonjour !! ".$_GET["connected"]?>
            </div>

        </div>

        <div id="accueil">
            <div id="intro">
                <h1>Bonjour, bienvenu dans le site Internshiplz !</h1>
                <h2>Qui sommes-nous ? </h2>
                <p>· Nous sommes étudiantes en Master 1 Sciences du Langages parcours Industrie de la langue à l\'Université
                    Grenoble Alpes.</p>
                <h2>C\'est quoi ce site ?</h2>
                <p>· Il s\'agit d\'un site regroupant les annonces de stages dans le domaine TAL pour les étudiants en master.
                    Nous avons utilisé la méthode de webscraping pour recueillir des informations. Les sites qu\'on a
                    parcouri comme sources sont les suivants : <a
                        href="http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html" target="_blank">Offres d\'emploi en
                        TAL</a>, <a href="http://" target="_blank">LinkedIn</a>, <a href="http://" target="_blank">site3</a>
                </p>
                <h2>Qu\'est-ce que je peux faire ici ?</h2>
                <p>· Si vous êtes étudiant.e en Master TAL, ce site est ici pour réduire votre temps consacré à chercher les
                    postes et pour vous aider à se familiariser avec le marché du travail. Bien sûr, ce site est accessible
                    à tous qui sont intéressés. </p>
                <p>· Nous ne nous contentons pas de présenter les résultats de webscraping, nous proposons également les
                    sélections des stages selon différentes conditions (niveaux d’études, filières, compétences, etc). </p>
                <p>· Les utilisateurs peuvent sauvegarder les informations recherchées sur leurs ordinateurs et ils peuvent
                    laisser des commentaires en signalant des bogues, faisant des suggestions, en nous félicitant ou nous
                    critiquant.</p>
                <h2>... et comment le faire ?</h2>
                <p>· Accueil - se connecter ; Recherche - rechercher et sauvegarder ; Discussion - commentaires</p>
                <p>· Avant de commencer, il vous faut une minute pour créer un compte simple, c\'est vraiment rapide ! →→→
                </p>
            </div>

            <div id="compte">
                <br />
                <br />
                <p>État du site :</p>
                <p>Nombre de visite :101111111</p>
                <p>Nombre de recherche :205</p>
                <p>Nombre de compte :20</p>
            </div>
        </div>

        <div id="recherche">
            <div id="options">
                <form action="" method="get">
                    <p class="options">Niveaux d’études</p>
                    <div class="checkbox">
                        <label><input name="M1" type="checkbox" value="M1" />Master 1</label>
                        <label><input name="M2" type="checkbox" value="M2" />Master 2</label>
                    </div>
                </form>
                <form action="" method="get">
                    <p class="options">Filière</p>
                    <div class="checkbox">
                        <label><input name="Informatique" type="checkbox" value="Informatique" />Informatique</label>
                        <label><input name="TAL" type="checkbox" value="TAL" />Traitement automatique des langues</label>
                        <label><input name="Linguistique" type="checkbox" value="Linguistique" />Linguistique</label>
                    </div>
                </form>
                <form action="" method="get">
                    <p class="options">Date de début</p>
                    <div class="checkbox">
                        <label><input name="Mars" type="checkbox" value="Mars" />Mars</label>
                        <label><input name="Avril" type="checkbox" value="Avril" />Avril</label>
                        <label><input name="Mai" type="checkbox" value="Mai" />Mai</label>
                        <label><input name="Septembre" type="checkbox" value="Septembre" />Septembre</label>
                        <label><input name="Novembre" type="checkbox" value="Novembre" />Novembre</label>
                    </div>
                </form>
                <form action="" method="get">
                    <p class="options">Lieu</p>
                    <div class="checkbox">
                        <label><input name="Grenoble" type="checkbox" value="Grenoble" />Grenoble</label>
                        <label><input name="Lyon" type="checkbox" value="Lyon" />Lyon</label>
                        <label><input name="Paris" type="checkbox" value="Paris" />Paris</label>
                        <label><input name="Strasbourg" type="checkbox" value="Strasbourg" />Strasbourg</label>
                        <label><input name="Marseille" type="checkbox" value="Marseille" />Marseille</label>
                        <label><input name="Toulouse" type="checkbox" value="Toulouse" />Toulouse</label>
                        <label><input name="Autres" type="checkbox" value="Autres" />Autres</label>
                    </div>
                </form>

                <div id="operer">
                    <button class="grand">
                        rechercher
                    </button>
                    <button class="grand">
                        sauvegarder
                    </button>
                </div>
            </div>

            <div id="resultat">
                <p id="consigne">1155 résultats - Les résultats de webscraping sont affichés par ordre chronologique, du plus
                    récent au plus ancien.</p>

            </div>

        </div>

        <div id="discussion">
            <div>
                Listes des commentaires :
                <ol id="listCom">
                </ol>
            </div>';
                
                
                if ($result->num_rows > 0) {
                    while($msgs = $result->fetch_assoc()) {
                        print $msgs['Username'].': '.$msgs['Comment'].'<br/>';
                    }
                } else {
                    print "Pas de commentaire";
                };
                
                print'
                
            <div>
                Écrivez ici : 
                <br/>(Veuillez bien respecter les autres, tous les commentaires inappropriés seront supprimés.)
                <br/>
                <form method="post">
                    <textarea id="commentaire" name="commentaire"></textarea>
                    <button id="bCom" class="grand" type="submit">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
        
        ';
        }
        else{
            echo "Ne trichez pas, encore 5 secondes pour retourner à la page index.php";
            echo "
            <head>
                <meta http-equiv='refresh' content='5; url=index' />    
            </head>"
            ;
        };
        
        
?>
  

</body>

</html>
<script>
    $("#pageAcc").on({
    "click": function () {
        $("#accueil").css("display", "flex");
        $("#recherche,#discussion").css("display", "none");
    }
});
$("#pageRec").on({
    "click": function () {
        console.log("research clicked");
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
</script>