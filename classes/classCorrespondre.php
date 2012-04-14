<?php

include_once("classConnexion.php");

class CORRESPONDRE {

    private $m_prj_id;
    private $m_cat_id;

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

        $requete = " SELECT * FROM correspondre " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            $this->m_prj_id = $p_id;
            $this->m_cat_id = stripslashes($array[0][cat_id]);
        }
    }

    public function addCorrespondance($p_prj_id, $p_cat_id) {

        $requete = "INSERT INTO correspondre (prj_id, cat_id) " .
                "VALUES ('" . $p_prj_id . "','" . $p_cat_id . "')";

        return SITE::getConnexion()->doSql($requete);
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCategorie() {
        return $this->m_cat_id;
    }

}

?>