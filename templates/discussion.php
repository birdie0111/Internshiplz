<div id="discussion">
    <div>
        Listes des commentaires :
        <input type="text" id="phpUsername" readonly=true style="display:none" value="<?php echo $username; ?> ">
        <ol id="listCom">

        </ol>
    </div>

    <div>
        Écrivez ici :
        <br />(Veuillez bien respecter les autres, tous les commentaires inappropriés seront supprimés.)
        <br />
        <div>
            <textarea id="commentaire" name="commentaire"></textarea>
            <button id="bCom" class="grand">
                Envoyer
            </button>
        </div>
    </div>
</div>