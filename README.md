# Intershiplz
Project of M1S2, a website where you can find information of internships (or jobs maybe) of nlp

#### compte et mots de passe:

    username    mots de passe
    schnappi    schnappi
    Mibo        Mibo
    Yuhe        Yuhe
*ou vous pouvez aussi créer votre propre compte*

#### structure de fichiers

    /actions (contient les fichiers de script pour traiter base de données de php pure (sauf login.php))
        nbWebscrap.php  # affiche nombre de recherche
        login.php       # base de données pour utilisateurs et affichage de la formulaire d'inscritption
        inscrit.php     # base de données pour utilisateurs
        etatSite.php    # affiche nombre de comptes, de stages etc.
        discuter.php    # base de données pour les messages
        action.php      # base de données pour les stages
    /backend
        pyWebscrap.php  # script python pour le webscraping
    /templates (contient les fichiers qui rendre la page par différents parties)
        recherche.php       # page qui affiche les stages
        discussion.php      # page de forum
        acceuil.php         # page template avant la connection
        acc_connected.php   # page template après la connection
    /text_files
        (les fichiers .txt qui sauvegardent les informations de stage)
    /fichier_html
        (les fichiers .html qui sauvegardent les informations de stage)

    connected.php   # gérer les templates après la connection, et aussi lancement de script python
    main_posi.css   # positions des éléments css
    main_style.css  # styles des éléments css
    index.php       # page avant la connection
    script.js       # js pour les boutons etc.
    recherche_yuhe.php  # script php pour afficher la discussion
    discussion_yuhe.php # script php pour rechercher dans bdd des stages