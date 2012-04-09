<?php
include_once("classes/classUtilisateur.php");
session_start();
include_once("classes/classSite.php");

if(!SITE::chkSession()) {
    echo ("<script language = \"JavaScript\">");
    echo ("location.href = 'index.php';");
    echo ("</script>");
}

print_r($_GET);
if (isset($_GET['idProjet'])) {
    echo 'ok';
} else {
    // afficher liste des projets de l'utilisateur
}
?>