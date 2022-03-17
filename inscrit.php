<?php
if (isset($_POST["new_user"]) and isset($_POST["new_psword"])){
    $new_user = $_POST["new_user"];
    $new_psword = $_POST["new_psword"];
    $db_host = "localhost";
    $db_user = "root";
    $db_pwd = "";
    $db_name = "login_m1s2";
    $db_port = 3306;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



    $connect = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    mysqli_set_charset($connect, 'utf8mb4');


    // verifier la connection
    if(!$connect){
        die("error while connecting to the database: ".mysqli_connect_error());
    }
    
    $query = "INSERT INTO Users(Username, Psword) VALUES('".$new_user."','".$new_psword."'".")";
    mysqli_query($connect, $query);

    header('Location: index.php');
}
?>