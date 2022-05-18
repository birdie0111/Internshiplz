<?php
// connection à la base de donnée
$db_host = "localhost";
$db_user = "liuqinyu";
$db_pwd = "L9Q9Y0l1qy;:";
$db_name = "liuqinyu";
$db_port = 3306;
/* établir la connection */
$conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
mysqli_set_charset($conn, 'utf8mb4');

// verifier la connection
if(!$conn){
    die("error while connecting to the database: ".mysqli_connect_error());
}

// afficher les résultats sur la page web
$sql = "SELECT * FROM Users";    # nbCompte
$query = mysqli_query($conn, $sql);

$result = array(strval($query->num_rows));

$sql = "SELECT * FROM Comments"; # nbCommentaire
$query = mysqli_query($conn, $sql);
array_push($result, strval($query->num_rows));

$output = $result[0].",".$result[1];
echo $output;
$conn->close();

?>