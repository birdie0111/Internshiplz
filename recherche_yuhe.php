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
$sql = "DELETE FROM `testAffich` WHERE 1";
$retval = mysqli_query( $conn, $sql );
if(! $retval ) {
  die('Erreur: ' . mysqli_error($conn));
}

// obtenir les résultats de webscraping
$dir = "text_files";
$i = 0;
$NdE = "";
$Filiere = "";
if (is_dir($dir)) {
    $dh = opendir($dir);
    while (($file = readdir($dh)) !== false) {
        // les informations à obtenir
        if (!is_dir($file)) {
            $hfic = fopen("$dir/$file", "r");
            $Path = "$dir/$file";
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
            }
            // écrire dans la base de donnée
            $sql = "INSERT INTO `testAffich` (`Numéro`, `Titre`, `Date`, `Organisme`, `Niveaux_études`, `Filière`, `Lieu`, `realPath`) VALUES ($i, '$titre', '$date', '$inst', '$NdE', '$Filiere', '$lieu', '$Path')";
            // vérifier l'action d'écrire
            if ($conn->query($sql) === TRUE) {
                // vider les variables avant la boucle
                $NdE = "";
                $Filiere = "";
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }

        }
    }
    closedir($dh);
}

// afficher les résultats sur la page web
$sql = "SELECT (@j:=@j+1) j, `Titre`,`Date`, `Organisme`, `Niveaux_études`, `Filière`, `Lieu`, `realPath` FROM `testAffich`,(SELECT @j:=0) as j ORDER BY `Date` DESC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    $i = 0 ;
    foreach ($row as $data) {
        if ($i == 1) {  # ajouter href="XXX.txt" dans le 2e colonne
            // obtenir le path du fichier .txt
            // SELECT `realPath` FROM `testAffich` WHERE `Titre` REGEXP $data 
            //$seg = str_replace("'","''",$data);
            //$sql = "SELECT realPath FROM testAffich WHERE Titre LIKE %$seg% ";
            //$path = mysqli_query($conn, $sql);
            //echo "<td> <a href=\"".$path."\">".$data."</a></td>";
            echo "<td>{$data}</td>";
            $i = $i + 1 ;
        } elseif ($i == 7) {
            echo "<td> <a href=\"".$data."\">".$data."</a></td>";
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