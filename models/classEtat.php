<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classEtat
 *
 * @author nicolas.gard
 */
class Etat extends Classe{

    private $m_id;
    private $m_libelle;
    private $m_date;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM categorie " .
                " WHERE cat_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[eta_libelle]);
            $this->$m_date = stripslashes($array[eta_date]);
        }
    }
    
    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }
    
    public function getDate() {
        return $this->m_date;
    }
    
}

?>
