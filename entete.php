<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

/**
 * Formule
 */
if (Site::getUtilisateur()) {
    ?>
    <!--div style="position: relative; left: 82px; top: 57px;"--> 
    <div> 
        Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> ! 
        <a onclick="getControllerView('utilisateur', 'profil');" class="button style2"><span>Mon profil</span></a> /
        <a onclick="getControllerAction('utilisateur', 'deconnexion');" class="button style2"><span>Se déconnecter</span></a>
    </div>
<?php } else { ?>
    <form id="en1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="valider"/>

        <!--div style="position: relative; left: 82px; top: 57px;"--> 
        <div> 
            Login :<input type='text' name='log' size='18' maxlength='100' value="" />
            Password :<input type='password' name='mdp' size='18' maxlength='100' value="" />
            <input type="button" onclick="getFormulaire('en1');" value="Valider" />
        </div>
    </form>
    <?php
}

/**
 * Menu
 */
if (Site::getUtilisateur()) {
    if (Site::getUtilisateur()->getStatut() == "client") {
        ?>
        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a onclick="getControllerView('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getControllerView('projet','ajouter');">Créer votre projet</a></li>
                    <li><a onclick="getControllerView('projet','liste');">Mes projets</a></li>
                    <li class="sublast"><a onclick="getControllerView('projet','fini');">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>

    <?php } else if (Site::getUtilisateur()->getStatut() == "prestataire") { ?>

        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a onclick="getControllerView('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getControllerView('projet','liste');">Mes projets</a></li>
                    <li class="sublast"><a onclick="getControllerView('projet','fini');">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Start css3menu.com BODY section -->
    <ul id="css3menu1" class="topmenu">
        <li class="topmenu"><a onclick="getControllerView('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
        <li class="topmenu"><a onclick="getControllerView('projet', 'liste');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
    </ul>
    <?php
}
?>