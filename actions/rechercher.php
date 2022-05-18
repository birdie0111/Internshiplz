<?php
// connection à la base de donnée
$servername = "localhost";
$username = "tangyuhe";
$password = "07151129";
$dbname = "tangyuhe";
/* établir la connection */
$conn = new mysqli($servername, $username, $password, $dbname);
/* vérifier la connection */
if ($conn->connect_error) {
    die("Fail : " . $conn->connect_error);
}

// vider la base de donnée
$sql = "DELETE FROM `InfoStage` WHERE 1";
$retval = mysqli_query( $conn, $sql );
if(! $retval ) {
  die('Erreur: ' . mysqli_error($conn));
}

// obtenir les résultats de webscraping
$dir = "../text_files";
$i = 0;
$NdE = "";
$Filiere = "";
$TempsStage = "";
$Anglais = 0;
$Teletravail = 0;
$Remuneration = 0;
$Recommandation = 0;
if (is_dir($dir)) {
    $dh = opendir($dir);
    while (($file = readdir($dh)) !== false) {
        // les informations à obtenir
        if (!is_dir($file)) {
            $hfic = fopen("$dir/$file", "r");
            $path = "text_files/$file"; # ouvrir les fichier .txt
            while ($ligne = fgets($hfic)) {
                // echo "$ligne<br/>";
                // echo "<tr><td> contenu </td><td> contenu </td></tr>";
                if (strpos($ligne, "Titre: ") !== false) {
                    $i = $i + 1;
                    $titre = str_replace("Titre: ", "", $ligne);
                    $titre = str_replace("'","''",$titre);
                }
                if (strpos($ligne, "Date: ") !== false) {
                    $date = str_replace("Date: ", "", $ligne);
                }
                if (strpos($ligne, "Organisme: ") !== false) {
                    $inst = str_replace("Organisme: ", "", $ligne);
                    $inst = str_replace("'","''",$inst);
                }
                if (strpos($ligne, "Lieu: ") !== false) {
                    $lieu = str_replace("Lieu: ", "", $ligne);
                    $lieu = str_replace("'","''",$lieu);
                }
                
                if (preg_match("/(?i)m1|master1|master 1|Master 1 ou 2|bac\+4|bac \+ 4|Bac \+4/", $ligne)) {
                    if (strstr($NdE, "Master 1") == false) {
                        $NdE = $NdE . "Master 1 ";
                    }
                }
                if (preg_match('/(?i)m2|master2|master 2|Master 1 ou 2|bac\+5|bac \+ 5|Bac \+5/', $ligne)) {
                    if (strstr($NdE, "Master 2") == false) {
                        $NdE = $NdE . "Master 2 ";
                    }
                }

                if (preg_match("/(?i)Informatique/", $ligne)) {
                    if (strstr($Filiere, "Informatique") == false) {
                        $Filiere = $Filiere . "Informatique ";
                    }
                }
                if (preg_match("/(?i)Traitement automatique des langues|tal/", $ligne)) {
                    if (strstr($Filiere, "TAL") == false) {
                        $Filiere = $Filiere . "TAL ";
                    }
                }
                if (preg_match("/(?i)Linguistique/", $ligne)) {
                    if (strstr($Filiere, "Linguistique") == false) {
                        $Filiere = $Filiere . "Linguistique ";
                    }
                }
                if (preg_match("/(?i)janvier|février|\bmars\b|avril|\bmai\b|\bjuin\b|juillet|août|septembre|octobre|novembre|décembre|january|february|\bmarch\b|april|\bmay\b|june|july|august|september|october|november|december/", $ligne)) {
                    if (strstr($TempsStage, $ligne) == false) {
                        $TempsStage = $TempsStage . $ligne ;
                    }
                }
                if (preg_match("/(?i)anglais|english/", $ligne)) {
                    $Anglais = 1 ;
                }
                if (preg_match("/(?i)télétravail/", $ligne)) {
                    $Teletravail = 1 ;
                }
                if (preg_match("/(?i)rémunération|gratification|salaire/", $ligne)) {
                    $Remuneration = 1 ;
                }
                if (preg_match("/(?i)lettre de recommandation/", $ligne)) {
                    $Recommandation = 1 ;
                }
            }
            $TempsStage = str_replace("'","''",$TempsStage);
            // écrire dans la base de donnée
            $sql = "INSERT INTO `InfoStage` (`Numéro`, `Titre`, `Date`, `Organisme`, `Niveaux_études`, `Filière`, `Lieu`, `realPath`, `TempsStage`, `Anglais`, `Télétravail`, `Rémunération`, `Recommandation`) VALUES ($i, '$titre', '$date', '$inst', '$NdE', '$Filiere', '$lieu', '$path', '$TempsStage', '$Anglais', '$Teletravail', '$Remuneration', '$Recommandation')";
            // vérifier l'action d'écrire
            if ($conn->query($sql) === TRUE) {
                // vider les variables avant la boucle
                $NdE = "";
                $Filiere = "";
                $TempsStage = "";
                $Anglais = 0;
                $Teletravail = 0;
                $Remuneration = 0;
                $Recommandation = 0;
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }

        }
    }
    closedir($dh);
}

// afficher les résultats sur la page web
$sql = "SELECT (@j:=@j+1) j, `Titre`,`Date`, `Organisme`, `Niveaux_études`, `Filière`, `Lieu`, `realPath` FROM `InfoStage`,(SELECT @j:=0) as j ORDER BY `Date` DESC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    $i = 0 ;
    foreach ($row as $data) {
        if ($i == 1) {        # ajouter href="XXXXX.html" dans le 2e colonne
            $file = str_replace(".txt",".html",$row[7]);
            $file = str_replace("text_files","fichier_html",$file);
            echo "<td> <a href=\"".$file."\">".$data."</a></td>";
            $i = $i + 1 ;
        } elseif ($i == 7) {  # ajouter href="XXXXX.txt" dans le dernier colonne
            $file = str_replace("text_files/","",$data);
            echo "<td> <a class=\"realPath\" href=\"".$data."\">".$file."</a></td>";
        } else {
            echo "<td>{$data}</td>";
            $i = $i + 1 ;
        }
    }
    $i = 0 ;
    echo '</tr>';
}

$conn->close();
?>