<?php
include_once("classConnexion.php");

class COMPETENCE {

    private $m_id;
    private $m_libelle;

    public function __construct() {
        // distinction existant/ nouveau en fonction du nombre d'arguments
        $argc = func_num_args();
        if ($argc == 1) {
            // l'id
            $t_id = func_get_arg(0);

            // appel du constructeur existant avec l'id
            $this->exists($t_id);
            
        } elseif ($argc == 2) {
            
        }
    }

    public function exists($p_id) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM competence " .
                " WHERE cpt_id = " . $p_id . " LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($ligne['cpt_libelle']);
        }
    }

    public static function getAll() {

        $connexion = new Connexion();
        $requete = "SELECT * FROM competence";
        $resultat = Connexion::doSql($requete);

        mysql_query("SET NAMES 'utf8'");

        return $resultat;
    }

    public static function getId($p_libelle) {

        $connexion = new Connexion();
        $requete = "SELECT cpt_id FROM categorie " .
                "WHERE cpt_libelle = '" . $p_libelle . "'";

        $resultat = Connexion::doSql($requete);

        if ($resultat == false) {
            die(mysql_error());
        }

        if (mysql_num_rows($resultat) == 1) {
            $object = mysql_fetch_object($resultat);
            $idCompetence = $object->cpt_id;
        }

        return $idCompetence;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }
}
?>