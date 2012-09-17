<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classEffectuer
 *
 * @author nicolas.gard
 */
class Effectuer extends Classe {

    private $m_uti_id;
    private $m_not_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM effectuer " .
                " WHERE uti_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_uti_id = $p_id;
            $this->m_not_id = stripslashes($array[not_id]);
        } else {
            unset($this);
        }
    }

    public static function addEvent($idUti, $idNot) {

        $requete = "INSERT INTO effectuer (uti_id, not_id) " .
                "VALUES ('" . $idUti . "','" . $idNot . "')";
        echo $requete;
//        return Site::getConnexion()->doSql($requete);
    }

}

?>
