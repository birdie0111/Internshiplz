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

// afficher les résultats sur la page web
// SELECT  count(Titre) FROM `testAffich`
$sql = "SELECT count(Titre) FROM `testAffich`";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query);
echo $result[0];
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

$conn->close();

?>