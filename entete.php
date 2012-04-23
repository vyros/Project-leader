<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
SITE::init();

if (SITE::getUtilisateur()) {
    ?>
    <!--div style="position: relative; left: 82px; top: 57px;"--> 
    <div> 
        Bonjour <?php echo SITE::getUtilisateur()->getLogin(); ?> ! 
        <a href="#monProfil" class="button style2"><span>Mon profil</span></a> /
        <a href="#deconnexion" class="button style2"><span>Se déconnecter</span></a>
    </div>
<?php } else { ?>
    <form id="accueil">
        <input type="hidden" name="action" value="getUtilisateur"/>
        <!--div style="position: relative; left: 82px; top: 57px;"--> 
        <div> 
            Login :<input type='text' name='log' size='18' maxlength='100' value="" />
            Password :<input type='password' name='mdp' size='18' maxlength='100' value="" />
            <input type="button" onclick="getRequest('accueil');" value="Valider" />
        </div>
    </form>
    <?php
}

if (SITE::getUtilisateur()) {
    if (SITE::getUtilisateur()->getStatut() == "client") {
        ?>
        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a href="#accueil" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a href="#projetAdd">Créer votre projet</a></li>
                    <li><a href="#projetLst">Mes projets</a></li>
                    <li class="sublast"><a href="#projetEnd">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a href="#recherche" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>

    <?php } else if (SITE::getUtilisateur()->getStatut() == "prestataire") { ?>

        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a href="#accueil" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a href="#projetLst">Mes projets</a></li>
                    <li class="sublast"><a href="#projetEnd">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a href="#recherche" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Start css3menu.com BODY section -->
    <ul id="css3menu1" class="topmenu">
        <li class="topmenu"><a href="#accueil" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
        <li class="topmenu"><a href="#presentation" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Présentation"/>Présentation</span></a></li>
        <li class="topmenu"><a href="#projetLst" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
    </ul>
    <?php
}
?>