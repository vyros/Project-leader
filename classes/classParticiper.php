<?php

include_once("classConnexion.php");

class PARTICIPER {

    private $m_prj_id;
    private $m_uti_id;

    public function __construct() {

        if (func_num_args() == 1) {
            $t_argv = func_get_arg(0);
            if (is_array($t_argv)) {
                $this->exists($t_argv[0][0]);
            }
        } else {
            
        }
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM participer " .
                " WHERE uti_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            $this->m_uti_id = $p_id;
            $this->m_prj_id = stripslashes($array[0][prj_id]);
        }
    }

    /**
     * Ajoute une participation.
     * 
     * @param int $p_uti_id Id de l'utilisateur.
     * @param int $p_prj_id Id du projet.
     * @return boolean Retourne vrai si succès, sinon retourne non.
     */
    public function addParticipation($p_uti_id, $p_prj_id) {

        $requete = "INSERT INTO participer (prj_id, uti_id, par_date) " .
                "VALUES ('" . $p_prj_id . "','" . $p_uti_id . "','" . date("c") . "')";

        return SITE::getConnexion()->doSql($requete);
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdUtilisateur() {
        return $this->m_uti_id;
    }

}

?>