<?php
/*
 * Contrôleur.
 * 
 * @author folin
 */

header("Content-Type: text/plain");
include_once("models/classSite.php");
Site::init();

$requeteNbConnecte = "SELECT COUNT(uti_id) FROM utilisateur" .
        " WHERE uti_enligne = 'ok' ;";

$requeteNbUtilisateur = "SELECT COUNT(uti_id) FROM utilisateur";
$requeteNbProjet = "SELECT COUNT(prj_id) FROM projet";

$arrayNbConnecte = Site::getConnexion()->getFetchIntArray($requeteNbConnecte);
$arrayNbUtilisateur = Site::getConnexion()->getFetchIntArray($requeteNbUtilisateur);
$arrayNbProjets = Site::getConnexion()->getFetchIntArray($requeteNbProjet);

echo $arrayNbConnecte[0] . "/" . $arrayNbUtilisateur[0] . "/" . $arrayNbProjets[0];
?>
