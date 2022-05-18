<?php
// obtenir les choix
$m = $_POST['ficm'];
$f = $_POST['ficf'];
$temps = $_POST['fictemps'];
$a = $_POST['fica'];
$tele = $_POST['fictele'];
$r = $_POST['ficr'];
$l = $_POST['ficl'];

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

// afficher les résultats sur la page web
//$sql = " SELECT * FROM `testAffich` WHERE `Date` LIKE '$d' AND `Filière` LIKE '$f' AND `Niveaux_études` LIKE '$m' AND `Lieu` LIKE '$l' ";
//$sql = " SELECT * FROM `testAffich` WHERE `Niveaux_études` IN ('Master 2') AND `Filière` IN ('TAL')
$sql = "SELECT (@j:=@j+1) j, `Titre`,`Date`, `Organisme`, `Niveaux_études`, `Filière`, `Lieu`, `realPath` FROM `InfoStage`,(SELECT @j:=0) as j WHERE `Niveaux_études` REGEXP '$m' AND `Filière` REGEXP '$f' AND `TempsStage` REGEXP '$temps' AND `Anglais` LIKE '%$a%' AND `Télétravail` LIKE '%$tele%' AND `Rémunération` LIKE '%$r%' AND `Recommandation` LIKE '%$l%' ORDER BY `Date` DESC ";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    $i = 0 ;
    foreach ($row as $data) {
        if ($i == 1) { 
            $file = str_replace(".txt",".html",$row[7]);
            $file = str_replace("text_files","fichier_html",$file);
            echo "<td> <a href=\"".$file."\">".$data."</a></td>";
            $i = $i + 1 ;
        } elseif ($i == 7) {
            $file = str_replace("text_files/","",$data);
            echo "<td> <a class=\"fakePath\" href=\"".$data."\">".$file."</a></td>";
        } else {
            echo "<td>{$data}</td>";
            $i = $i + 1 ;
        }
    }
    $i = 0 ;
    echo '</tr>';
}
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

$conn->close();

?>