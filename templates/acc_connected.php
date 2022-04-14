<div id="begin">
    <div id="icone"><img src="UGA.jpg" id="imguga">Internshiplz</div>
    <div id="menu">
        <li class="plaque" id="pageAcc"> Accueil </li>
        <li class="plaque" id="pageRec"> Recherche </li>
        <li class="plaque" id="pageDis"> Discussion </li>
    </div>
    <div id="user">
        <?php echo "Bonjour, ".$_GET["connected"]?>
    </div>

</div>

<div id="content">
    <div id="login">
        <div class="a-text">
            <h1>Bonjour, bienvenu dans le site Internshiplz !</h1>
            <h2>Qui sommes-nous ? </h2>
            <p>· Nous sommes étudiantes en Master 1 Sciences du Langages parcours Industrie de la langue à l'Université
                Grenoble Alpes.</p>
            <h2>C'est quoi ce site ?</h2>
            <p>· Il s'agit d'un site regroupant les annonces de stages dans le domaine TAL pour les étudiants en master.
                Nous avons utilisé la méthode de webscraping pour recueillir des informations. Les sites qu'on a
                parcouri comme sources sont les suivants : <a
                    href="http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html" target="_blank">Offres d'emploi en
                    TAL</a>, <a href="http://" target="_blank">LinkedIn</a>, <a href="http://" target="_blank">site3</a>
            </p>
        </div>

        <div id="compte">
            <br />
            <br />
            <p>État du site :</p>
            <p>Nombre de compte :<span id="nbCompte"></span></p>
            <p>Nombre de résultat : sur la page "Recherche"</p>
            <p>Nombre de commentaire :<span id="nbCommentaire"></span></p>
        </div>
    </div>
    <div class="a-img1"></div>
    <div class="a-text1">
        <h2>Qu'est-ce que je peux faire ici ?</h2>
        <p>· Si vous êtes étudiant.e en Master TAL, ce site est ici pour réduire votre temps consacré à chercher les
            postes et pour vous aider à se familiariser avec le marché du travail. Bien sûr, ce site est accessible
            à tous qui sont intéressés. </p>
        <p>· Nous ne nous contentons pas de présenter les résultats de webscraping, nous proposons également les
            sélections des stages selon différentes conditions (niveaux d’études, filières, compétences, etc). </p>
        <p>· Les utilisateurs peuvent sauvegarder les informations recherchées sur leurs ordinateurs et ils peuvent
            laisser des commentaires en signalant des bogues, faisant des suggestions, en nous félicitant ou nous
            critiquant.</p>
        <h2>... et comment le faire ?</h2>
        <p>· Accueil - se connecter ; Recherche - rechercher et sauvegarder ; Discussion - commentaires</p>
        <p>· Avant de commencer, il vous faut une minute pour créer un compte simple, c'est vraiment rapide ! →→→
        </p>
    </div>
    <div class="a-img2"></div>
</div>
