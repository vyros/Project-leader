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
    
    public function addCorrespondance($p_prj_id, $p_cat_id) {

        $requete = "INSERT INTO correspondre (prj_id, cat_id) " .
                "VALUES ('" . $p_prj_id . "','" . $p_cat_id . "')";

        return Site::getConnexion()->doSql($requete);
    }
    
    public function modifCorrespondance($p_prj_id, $p_tab_categ) {
        
        if(is_null($p_tab_categ))
            return null;
        
        foreach ($p_tab_categ as $p_categ_id) {
            $requete = " UPDATE correspondre SET cat_id = ". $p_categ_id." WHERE prj_id = ".$p_prj_id;
            echo $requete;
//            Site::getConnexion()->doSql($requete);
        }
        
        
    }
    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCategorie() {
        return $this->m_cat_id;
    }

}

?>