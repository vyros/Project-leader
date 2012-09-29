<!-- FAVORIS -->

<?php
/*
 * Contrôleur de favoris.
 * 
 * @author folin
 */

header("Content-Type: text/plain");
include_once("models/classSite.php");
Site::init();

$utilisateur = (isset($_POST["idUti"])) ? $_POST["idUti"] : null;
$projet = (isset($_POST["idPjt"])) ? $_POST["idPjt"] : null;

if ((!is_null($utilisateur) && (!is_null($projet)))) {
    $requete = "INSERT INTO aimer (prj_id, uti_id) " .
            "VALUES ('" . $projet . "', '" . $utilisateur . "');";

    Site::getConnexion()->doSql($requete);

    echo "ok";
}
?>
