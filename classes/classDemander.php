<?php

include_once("classConnexion.php");

class DEMANDER {

    private $m_prj_id;
    private $m_cpt_id;

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

        $requete = " SELECT * FROM demander " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            $this->m_prj_id = $p_id;
            $this->m_cpt_id = stripslashes($array[0][cpt_id]);
        }
    }

    public function addDemande($p_prj_id, $p_tab_cpt) {

        foreach ($p_tab_cpt as $t_cpt_id) {
            $requete = "INSERT INTO demander (prj_id, cpt_id) " .
                    "VALUES ('" . $p_prj_id . "', '" . $t_cpt_id . "')";

            SITE::getConnexion()->doSql($requete);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getLstNIds($p_n = 0) {

        $requete = " SELECT cpt_id FROM demander " .
                " WHERE prj_id = " . $this->m_prj_id . " ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return SITE::getConnexion()->getFetchArray($requete);
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCompetence() {
        return $this->m_cpt_id;
    }

}

?>