<div id="discussion">
    <div>
        Listes des commentaires :
        <ol id="listCom">
        </ol>
    </div>;
        
    <?php
        if ($result->num_rows > 0) {
            while($msgs = $result->fetch_assoc()) {
                print $msgs['Username'].': '.$msgs['Comment'].'<br/>';
            }
        } else {
            print "Pas de commentaire";
        };
    ?>
        
    <div>
        Écrivez ici : 
        <br/>(Veuillez bien respecter les autres, tous les commentaires inappropriés seront supprimés.)
        <br/>
        <form method="post">
            <textarea id="commentaire" name="commentaire"></textarea>
            <button id="bCom" class="grand" type="submit">
                Envoyer
            </button>
        </form>
    </div>
</div>