<?php
        $db_host = "localhost";
        $db_user = "liuqinyu";
        $db_pwd = "L9Q9Y0l1qy;:";
        $db_name = "liuqinyu";
        $db_port = 3306;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $connect = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
        mysqli_set_charset($connect, 'utf8mb4');
        // vérifier la connection
        if(!$connect){
            die("error while connecting to the database: ".mysqli_connect_error());
        }

        if($_POST['par'] != ""){
            $par = str_replace("'","''",$_POST['par']);
            $u = $_POST['user'];
            $query = "select * from Comments where Comment = '$par' and Username = '$u';";
            $result = mysqli_query($connect,$query);

            # Si un nouveau commentaire a été écrit :
            if($result->num_rows == 0){
                $query = "INSERT INTO Comments(Username,Comment) VALUES('$u','$par');";
               
                $result = mysqli_query($connect,$query);
            }
        }

        $query = "select * from Comments;";
        $result = mysqli_query($connect,$query);

        if ($result->num_rows > 0) {
            while($msgs = $result->fetch_assoc()) {
                echo '<li>';
                echo $msgs['Username'].': '.$msgs['Comment'].'<br/>';
                echo '</li>';
            }
        } else {
            echo "Pas de commentaire.";
        };
?>
