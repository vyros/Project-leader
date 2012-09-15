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
        <p class="libellEntete">Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> ! 
            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil'});" class="button style2"><span>Mon profil</span></a> /
            <a onclick="getController({'controller' : 'utilisateur', 'action' : 'deconnexion'});" class="button style2"><span>Se déconnecter</span></a>
        </p>
    </div>
<?php } else { ?>
    <form id="en1">

        <input type="hidden" name="action" value="valider"/>
        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="view" value="accueil"/>

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
            <li class="topmenu"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'accueil'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer votre projet</a></li>
                    <li><a onclick="getView({'controller' : 'projet', 'view' : 'liste'});">Mes projets</a></li>
                    <li class="sublast"><a onclick="getView({'controller' : 'projet', 'view' : 'fini'});">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController({'controller' : 'recherche'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a>
                <ul>
                    <li class="subfirst"><a onclick="getView({'controller' : 'projet', 'view' : 'favori'});">Mes favoris</a></li>
                </ul>
            </li>
            <li class="topmenu"><a onclick="getView({'controller' : 'notification', 'view' : 'messagerie'});" style="height:24px;line-height:24px;"><img src="images/icone_messagerie.png" alt="Messagerie"/></a></li>
        </ul>

    <?php } else if (Site::getUtilisateur()->getStatut() == "prestataire") { ?>

        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'accueil'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a style="height:24px;line-height:24px;"><span><img src="css/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a onclick="getView({'controller' : 'projet', 'view' : 'liste'});">Mes projets</a></li>
                    <li class="sublast"><a onclick="getView({'controller' : 'projet', 'view' : 'fini'});">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController({'controller' : 'recherche'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a>
                <ul>
                    <li class="sublast"><a onclick="getView({'controller' : 'projet', 'view' : 'favori'});">Mes favoris</a></li>
                </ul>
            </li>
            <li class="topmenu"><a onclick="getView({'controller' : 'notification', 'view' : 'messagerie'});" style="height:24px;line-height:24px;"><img src="images/icone_messagerie.png" alt="Messagerie"/></a></li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Start css3menu.com BODY section -->
    <ul id="css3menu1" class="topmenu">
        <li class="topmenu"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'accueil'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
        <li class="topmenu"><a onclick="getView({'controller' : 'projet', 'view' : 'liste'});" style="height:24px;line-height:24px;"><img src="css/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
    </ul>
    <?php
}
?>