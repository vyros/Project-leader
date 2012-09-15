<?php

class Correspondre extends Classe {

    private $m_prj_id;
    private $m_cat_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM correspondre " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_prj_id = $p_id;
            $this->m_cat_id = stripslashes($array[cat_id]);
        }
    }
    
    public static function addCategories($p_prj_id, $p_cat_array) {

         if (is_null($p_cat_array) || count($p_cat_array) == 0)
            return null;

        foreach ($p_cat_array as $cat_id) {
            $requete = "INSERT INTO correspondre (prj_id, cat_id) " .
                    "VALUES (" . $cat_id . ", " . $p_prj_id . ");";

            Site::getConnexion()->doSql($requete);
        }
    }
    
    public static function removeCategories($p_prj_id, $p_cat_array) {

        if (is_null($p_cat_array) || count($p_cat_array) == 0)
            return null;

        foreach ($p_cat_array as $cat_id) {
            $requete = " DELETE FROM correspondre WHERE cat_id = " . $cat_id .
                    " AND prj_id = " . $p_prj_id . ";";

            Site::getConnexion()->doSql($requete);
        }
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCategorie() {
        return $this->m_cat_id;
    }
    
    public static function getCategorieIdsFromPjtId($p_id) {

        $requete = " SELECT cat_id FROM correspondre " .
                " WHERE prj_id = " . $p_id . ";";

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }
}

?>