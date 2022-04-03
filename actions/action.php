<?php
// obtenir les choix
$m = $_POST['ficm'];
$f = $_POST['ficf'];

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
$sql = "SELECT * FROM `testAffich` WHERE `Niveaux_études` REGEXP '$m' AND `Filière` REGEXP '$f' ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    echo '<tr>';
    $i = 0 ;
    foreach ($row as $data) {
        if ($i == 7) {
            echo "<td> <a href=\"".$data."\">".$data."</a></td>";
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