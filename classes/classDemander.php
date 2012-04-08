<?php
include_once("classConnexion.php");

class DEMANDER {

    private $m_prj_id;
    private $m_cpt_id;

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
        $requete = " SELECT * FROM demander " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_prj_id = $p_id;
            $this->m_cpt_id = stripslashes($ligne['cpt_id']);
        }
    }

    public function addDemande($p_prj_id, $p_tab_cpt) {

        $connexion = new Connexion();
        $i = 0;

        while ($p_tab_cpt[$i] != "") {

            $requete = "INSERT INTO demander (prj_id, cpt_id) " .
                    "VALUES ('" . $p_prj_id . "', '" . $p_tab_cpt[$i] . "')";
            
            if (mysql_query($requete) === false) {
                return false;
            }
            $i++;
        }
    }

    public function getAll() {
        
        $connexion = new Connexion();
        $requete = " SELECT cpt_id FROM demander " .
                " WHERE prj_id = " . $this->m_prj_id . ";";

        $resultat = Connexion::doSql($requete);
        mysql_query("SET NAMES 'utf8'");

        return $resultat;
    }

// accesseurs
    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCompetence() {
        return $this->m_cpt_id;
    }
}
?>