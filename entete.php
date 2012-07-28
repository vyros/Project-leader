<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

echo '<script type="text/javascript">';
echo '      getHeader();';
echo '</script>';

/**
 * Formule
 */
if (Site::getUtilisateur()) {
    ?>
    <!--div style="position: relative; left: 82px; top: 57px;"--> 
    <div> 
        <p class="libellEntete">Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> ! 
        <a onclick="getView('utilisateur', 'profil');" class="button style2"><span>Mon profil</span></a> /
        <a onclick="getController('utilisateur', 'deconnexion');" class="button style2"><span>Se déconnecter</span></a>
        </p>
    </div>
<?php } else { ?>
    <form id="en1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="valider"/>

        <!--div style="position: relative; left: 82px; top: 57px;"--> 
        <div> 
            <label for="log">Login : </label>
            <input id="log" accesskey="l" type='text' name='log' size='18' maxlength='100' value="" />
            
            <label for="mdp">Password : </label>
            <input id="mdp" accesskey="p" type='password' name='mdp' size='18' maxlength='100' value="" />
            
            <input class="btn" type="button" onclick="getFormulary('en1');" value="Valider" />
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
            <li class="topmenu"><a onclick="getController('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getView('projet','ajouter');">Créer votre projet</a></li>
                    <li><a onclick="getView('projet','liste');">Mes projets</a></li>
                    <li class="sublast"><a onclick="getView('projet','fini');">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>

    <?php } else if (Site::getUtilisateur()->getStatut() == "prestataire") { ?>

        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a onclick="getView('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getView('projet','liste');">Mes projets</a></li>
                    <li class="sublast"><a onclick="getView('projet','fini');">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Start css3menu.com BODY section -->
    <ul id="css3menu1" class="topmenu">
        <li class="topmenu"><a onclick="getView('accueil');" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
        <li class="topmenu"><a onclick="getView('projet', 'liste');" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
    </ul>
    <?php
}
?>