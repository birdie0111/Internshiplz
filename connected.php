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

        include "templates/acc_connected.php";
        include "templates/recherche.php";
        include "templates/discussion.php";
        
        }
        else{
            echo "Ne trichez pas, encore 5 secondes pour retourner à la page index.php";
            echo "
            <head>
                <meta http-equiv='refresh' content='5; url=index.php' />    
            </head>"
            ;
        };
        
        
?>
  
<script type="text/javascript" src="script.js" ></script>
</body>

</html>
