<?php
include_once("classes/classSite.php");
SITE::init();

if(SITE::chkUtilisateur()) {
    if (isset($_GET['idProjet'])) {
        echo 'ok';
    } else {
        // afficher liste des projets de l'utilisateur
    }
    
} else {
    
}
?>