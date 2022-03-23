<html>
    <head>
        <meta charset="utf-8">
        <title>login in</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <form action="inscrit.php" id = "ins_form" method="post">
            <h3>username:</h3>
            <input type="text" name = "new_user">
            <h3>password:</h3>
            <input type="text" name = "new_psword">
            <button type="submit">create</button>
        </form>

    </body>
</html>





<?php

$username = $_POST["username"];
$password = $_POST["password"];


// connection avec mysql
$db_host = "localhost";
$db_user = "liuqinyu";
$db_pwd = "L9Q9Y0l1qy;:";
$db_name = "liuqinyu";
$db_port = 3306;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



$connect = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
mysqli_set_charset($connect, 'utf8mb4');


// verifier la connection
if(!$connect){
    die("error while connecting to the database: ".mysqli_connect_error());
}

// verifier dans la base de donnee
$query = "select * from Users where Username = '".$username."';";
$result = mysqli_query($connect,$query);

// verifier Si l'utilisateur existe
if ($result->num_rows == 0){
    print " <div id='no_account'>
                <p>Votre username pas trouve, creez un compte plz</p>
                <button id = 'new_account' >create</button>
            </div>";
        
}else{
    $query = "select * from Users where Psword = '".$password."'"."and Username = '".$username."';";
    $result = mysqli_query($connect,$query);
    if($result->num_rows == 0){
        echo "Mots de passe pas correct";
    }else{
        echo "Login succeeded";
        $connect->close();
        header('Location: /~liuqinyu/connected.php?connected='.$username);
    }
}








mysqli_close($connect);
?>

<script>
    $(document).ready(function(){
        $("#ins_form").hide();
        $("#new_account").click(function(){
            $("#ins_form").show();
            $("#no_account").hide();
        })
    })
    
</script>
