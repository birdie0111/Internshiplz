<div id="recherche">
        <div id="options">
            <form action="../actions/action.php" method="post">
                <p class="options">Niveaux d’études</p>
                <div class="checkbox">
                    <label><input name="M[]" type="checkbox" value="Master 1 " />Master 1</label>
                    <label><input name="M[]" type="checkbox" value="Master 2 " />Master 2</label>
                </div>
            </form>
            <form action="../actions/action.php" method="post">
                <p class="options">Filière</p>
                <div class="checkbox">
                    <label><input name="F[]" type="checkbox" value="Informatique " />Informatique</label>
                    <label><input name="F[]" type="checkbox" value="TAL " />Traitement automatique des langues</label>
                    <label><input name="F[]" type="checkbox" value="Linguistique " />Linguistique</label>
                </div>
            </form>
            <form action="../actions/action.php" method="post">
                <p class="options">Temps de stage</p>
                <div class="checkbox">
                    <label><input name="T[]" type="checkbox" value="janvier" />Janvier</label>
                    <label><input name="T[]" type="checkbox" value="février" />Février</label>
                    <label><input name="T[]" type="checkbox" value="mars" />Mars</label>
                    <label><input name="T[]" type="checkbox" value="avril" />Avril</label>
                    <label><input name="T[]" type="checkbox" value="mai" />Mai</label>
                    <label><input name="T[]" type="checkbox" value="juin" />Juin</label>
                    <label><input name="T[]" type="checkbox" value="juillet" />Juillet</label>
                    <label><input name="T[]" type="checkbox" value="août" />Août</label>
                    <label><input name="T[]" type="checkbox" value="septembre" />Septembre</label>
                    <label><input name="T[]" type="checkbox" value="octobre" />Octobre</label>
                    <label><input name="T[]" type="checkbox" value="novembre" />Novembre</label>
                    <label><input name="T[]" type="checkbox" value="décembre" />Décembre</label>
                </div>
            </form>
            <form action="../actions/action.php" method="post">
                <p class="options">Compétence en langue</p>
                <div class="checkbox">
                    <label><input name="A[]" type="checkbox" value=1 />Anglais</label>
                </div>
            </form>
            <form action="../actions/action.php" method="post">
                <p class="options">Autres options</p>
                <div class="checkbox">
                    <label><input name="Tele[]" type="checkbox" value=1 />Télétravail</label>
                    <label><input name="R[]" type="checkbox" value=1 />Rémunération</label>
                    <label><input name="L[]" type="checkbox" value=1 />Lettre de recommandation</label>
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
                récent au plus ancien. Cliquez sur les titres pour plus d'informations. <br/> Cliquez à droite sur les fichiers pour enregistrer les fichiers .txt, par exemple : cliquez avec le bouton droit sur "stage0.txt" ---> Enregistrer le lien sous...</p>
            <table id="tableAffiche">
                <tr>
                    <th>Veuillez attendre...</th>
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
