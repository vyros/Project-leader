<?php

class CORRESPONDRE extends CLASSE {

    private $m_prj_id;
    private $m_cat_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM correspondre " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getOneLevelArray(SITE::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_prj_id = $p_id;
            $this->m_cat_id = stripslashes($array[cat_id]);
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