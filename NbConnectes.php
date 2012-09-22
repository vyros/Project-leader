<!-- NbConnectés -->

<?php
header("Content-Type: text/plain");
include_once("models/classSite.php");
Site::init();

$requeteNbConnecte = "SELECT COUNT(uti_id) FROM utilisateur" .
        " WHERE uti_connected = 'ok' ;";
$requeteNbUtilisateur = "SELECT COUNT(uti_id) FROM utilisateur";
$requeteNbProjet = "SELECT COUNT(prj_id) FROM projet";

$arrayNbConnecte = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requeteNbConnecte));
$arrayNbUtilisateur = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requeteNbUtilisateur));
$arrayNbProjets = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requeteNbProjet));

echo $arrayNbConnecte[0] . "/" . $arrayNbUtilisateur[0] . "/" . $arrayNbProjets[0];
?>
