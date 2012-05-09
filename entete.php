<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
SITE::init();

if (SITE::getUtilisateur()) {
    ?>
    <!--div style="position: relative; left: 82px; top: 57px;"--> 
    <div> 
        Bonjour <?php echo SITE::getUtilisateur()->getLogin(); ?> ! 
        <a href="#monProfil.php" class="button style2"><span>Mon profil</span></a> /
        <!--a href="#deconnexion.php" class="button style2"><span>Se déconnecter</span></a-->
        <a onclick="getController('deconnexion');" class="button style2"><span>Se déconnecter</span></a>
    </div>
<?php } else { ?>
    <form id="en1">
        
        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="getUtilisateur"/>
        
        <!--div style="position: relative; left: 82px; top: 57px;"--> 
        <div> 
            Login :<input type='text' name='log' size='18' maxlength='100' value="" />
            Password :<input type='password' name='mdp' size='18' maxlength='100' value="" />
            <input type="button" onclick="getFormulaire('en1');" value="Valider" />
        </div>
    </form>
    <?php
}

if (SITE::getUtilisateur()) {
    if (SITE::getUtilisateur()->getStatut() == "client") {
        ?>
        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <!--li class="topmenu"><a href="#accueil.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li-->
            <li class="topmenu"><a onclick="getController('accueil');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a href="#projetAdd.php">Créer votre projet</a></li>
                    <li><a href="#projetLst.php">Mes projets</a></li>
                    <li class="sublast"><a href="#projetEnd.php">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>

    <?php } else if (SITE::getUtilisateur()->getStatut() == "prestataire") { ?>

        <!-- Start css3menu.com BODY section -->
        <ul id="css3menu1" class="topmenu">
            <li class="topmenu"><a onclick="getController('accueil');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
            <li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
                <ul>
                    <li class="subfirst"><a href="#projetLst.php">Mes projets</a></li>
                    <li class="sublast"><a href="#projetEnd.php">Projets finis</a></li>
                </ul></li>
            <li class="topmenu"><a onclick="getController('recherche');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Start css3menu.com BODY section -->
    <ul id="css3menu1" class="topmenu">
        <li class="topmenu"><a onclick="getController('accueil');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
        <li class="topmenu"><a onclick="getController('projet');" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
    </ul>
    <?php
}
?>