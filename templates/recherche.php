<div id="recherche">
        <div id="options">
            <form action="../actions/action.php" method="get">
                <p class="options">Niveaux d’études</p>
                <div class="checkbox">
                    <label><input name="M[]" type="checkbox" value="Master 1 " />Master 1</label>
                    <label><input name="M[]" type="checkbox" value="Master 2 " />Master 2</label>
                </div>
            </form>
            <form action="../actions/action.php" method="get">
                <p class="options">Filière</p>
                <div class="checkbox">
                    <label><input name="F[]" type="checkbox" value="Informatique " />Informatique</label>
                    <label><input name="F[]" type="checkbox" value="TAL " />Traitement automatique des langues</label>
                    <label><input name="F[]" type="checkbox" value="Linguistique " />Linguistique</label>
                </div>
            </form>
            <form action="../actions/action.php" method="get">
                <p class="options">Date de début</p>
                <div class="checkbox">
                    <label><input name="D[]" type="checkbox" value="Mars" />Mars</label>
                    <label><input name="D[]" type="checkbox" value="Avril" />Avril</label>
                    <label><input name="D[]" type="checkbox" value="Mai" />Mai</label>
                    <label><input name="D[]" type="checkbox" value="Septembre" />Septembre</label>
                    <label><input name="D[]" type="checkbox" value="Novembre" />Novembre</label>
                </div>
            </form>
            <form action="../actions/action.php" method="get">
                <p class="options">Lieu</p>
                <div class="checkbox">
                    <label><input name="L[]" type="checkbox" value="Grenoble" />Grenoble</label>
                    <label><input name="L[]" type="checkbox" value="Lyon" />Lyon</label>
                    <label><input name="L[]" type="checkbox" value="Paris" />Paris</label>
                    <label><input name="L[]" type="checkbox" value="Strasbourg" />Strasbourg</label>
                    <label><input name="L[]" type="checkbox" value="Marseille" />Marseille</label>
                    <label><input name="L[]" type="checkbox" value="Toulouse" />Toulouse</label>
                    <label><input name="L[]" type="checkbox" value="Autres" />Autres</label>
                </div>
            </form>

            <div id="operer">
                <button class="grand" id="btRec">
                    rechercher
                </button>
            </div>
        </div>

        <div id="resultat">
        <p id="consigne"><span id="nbWebscrap"></span> résultats - Les résultats de webscraping sont affichés par ordre chronologique, du plus
                récent au plus ancien.</p>
            <table id="tableAffiche">
                <tr>
                    <th>Numéro</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Organisme</th>
                    <th>Niveaux d'études</th>
                    <th>Filière</th>
                    <th>Lieu</th>
                    <th>Fichier</th>
                </tr>

            </table>

        </div>

    </div>
