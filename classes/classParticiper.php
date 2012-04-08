<?php
include_once("classConnexion.php");

class PARTICIPER {

    private $m_prj_id;
    private $m_uti_id;

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
        $requete = " SELECT * FROM participer " .
                " WHERE uti_id = " . $p_id . " LIMIT 1;";

        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_uti_id = $p_id;
            $this->m_prj_id = stripslashes($ligne['prj_id']);
        }
    }

    public function addParticipation($p_prj_id, $p_uti_id) {

        $connexion = new Connexion();
        $date = date("c");
        
        $requete = "INSERT INTO participer (prj_id, uti_id, par_date) " .
                "VALUES ('" . $p_prj_id . "','" . $p_uti_id . "','" . $date . "')";
        
        return mysql_query($requete);
    }

// accesseurs
    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdUtilisateur() {
        return $this->m_uti_id;
    }
}
?>