<?php

class Projet extends Classe {

    private $m_id;
    private $m_eta_id;
    private $m_libelle;
    private $m_description;
    private $m_budget;
    private $m_echeance;
    private $m_date;
    private $m_cat_array;
    private $m_cpt_array;
    
    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM projet " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_eta_id = stripslashes($array[eta_id]);
            $this->m_libelle = stripslashes($array[prj_libelle]);
            $this->m_description = stripslashes($array[prj_description]);
            $this->m_budget = stripslashes($array[prj_budget]);
            $this->m_echeance = stripslashes($array[prj_echeance]);
            $this->m_date = stripslashes($array[prj_date]);
            
            $this->m_cat_array = $this->getCategorieIds();
            if(!is_null($this->m_cat_array))
                sort($this->m_cat_array); 
            
            $this->m_cpt_array = $this->getCompetenceIds();
            if(!is_null($this->m_cpt_array))
                sort($this->m_cpt_array);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public static function getLstNIds($p_n = 0) {

        $requete = "SELECT prj_id FROM projet ORDER BY prj_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    public static function getLstNObjs($p_n = 0) {
        $lstArray = self::getLstNIds($p_n);
        $objArray = null;

        if (is_null($lstArray))
            return null;

        foreach ($lstArray as $value) {
            $objArray[] = new Projet($value);
        }

        return $objArray;
    }

    /**
     * Ajoute un projet.
     * 
     * @return Projet Retourne le nouvel objet en cas de succès, sinon retourne null.
     */
    static public function addProjet($p_etat, $p_libelle, $p_description, $p_budget, $p_echeance) {

        $requete = "INSERT INTO projet (eta_id, prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES (" . $p_etat . ", '" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_echeance . "','" . date("c") . "')";

        $idProjet = Site::getConnexion()->doSql($requete, "projet");
        if ($idProjet) {
            return new Projet($idProjet);
        }
        return null;
    }
    
    static public function editProjet() {

         $requete = " UPDATE projet SET prj_nom = '" . $this->getLibelle() . "'," .
                " prj_description = " . $this->getActif() . ", prj_budget = '" . $this->getBudget() . "'," .
                " prj_echeance = '" . $this->getEcheance() . "', etat_id = '" . $this->getEtatId() . "'," .
                " WHERE pjr_id = " . $this->getId() . ";";

        $tabAjouterCat = array_diff($this->m_cat_array, $this->getCategorieIds());
        $tabSupprimerCat = array_diff($this->getCategorieIds(), $this->m_cat_array);
        
        $tabAjouterComp = array_diff($this->m_cpt_array, $this->getCompetenceIds());
        $tabSupprimerComp = array_diff($this->getCompetenceIds(), $this->m_cpt_array);
        
        if (Site::getConnexion()->doSql($requete)) {
            
            if(is_null($tabAjouterCat))
                $tabAjouterCat = $this->m_cat_array;
            
            Correspondre::addCorrespondance($this->m_id, $tabAjouterCat);
            Correspondre::removeCategorie($this->m_id, $tabSupprimerCat);
            
            return $this;
            
            if(is_null($tabAjouterComp))
                $tabAjouterComp = $this->m_cat_array;
            
            Correspondre::addCorrespondance($this->m_id, $tabAjouterComp);
            Correspondre::removeCategorie($this->m_id, $tabSupprimerCat);
            
            return $this;
            
        }
        return null;
    }

    /**
     * Retourne la categorie associée au projet.
     * 
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCategorieIds() {

        $requete = "SELECT cat_id FROM correspondre " .
                " WHERE prj_id = " . $this->m_id . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Retourne la categorie associée au projet.
     * 
     * @return array Retourne un tableau contenant l'objet de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCategorieObjs() {
        $lstArray = $this->getCategorieIds();
        $objArray = null;

        if (is_null($lstArray))
            return null;

        foreach ($lstArray as $value) {
            $objArray[] = new Categorie($value);
        }

        return $objArray;
    }

    /**
     * Retourne la competence associée au projet.
     * 
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCompetenceIds() {

        $requete = "SELECT cpt_id FROM demander " .
                " WHERE prj_id = " . $this->m_id . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Retourne la competence associée au projet.
     * 
     * @return array Retourne un tableau contenant l'objet de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCompetenceObjs() {
        $lstArray = $this->getCompetenceIds();
        $objArray = null;

        if (is_null($lstArray))
            return null;

        foreach ($lstArray as $value) {
            $objArray[] = new Competence($value);
        }

        return $objArray;
    }

    public static function getProjetSimilaire($idCategorie){
        
        $requete = " SELECT p.prj_id FROM categorie cat, demander d, correspondre c, projet p " .
                   " WHERE cat.cat_id = '".$idCategorie."' " .
                   " AND cat.cat_id = c.cat_id " .
                   " AND p.prj_id = c.prj_id " ;
        
        echo $requete;
        
        return Site::getConnexion()->getFetchArray($requete);
        
    }

    public function getId() {
        return $this->m_id;
    }

    public function getEtatId() {
        return $this->m_eta_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

    public function getDescription() {
        return $this->m_description;
    }

    public function getBudget() {
        return $this->m_budget;
    }

    public function getEcheance() {
        return $this->m_echeance;
    }

    public function getDate() {
        return $this->m_date;
    }

    public function __toString() {
        return "id : $this->m_id ; libelle : $this->m_libelle";
    }
    
    public function setCategories($p_value) {
		if (!is_null($p_value))
        	sort($p_value);

        $this->m_cat_array = $p_value;
    }
    
    public function setCompetences($p_value) {
        if (!is_null($p_value))
        	sort($p_value);

        $this->m_cpt_array = $p_value;
    }
    
    public function setDescription($p_value) {
        $this->m_description = $p_value;
    }
    
    public function setBudget($p_value) {
        $this->m_budget = $p_value;
    }
    
    public function setEcheance($p_value) {
        $this->m_echeance = $p_value;
    }
    
    public function setStatut($p_value) {
        $this->m_eta_id = $p_value;
    }
}

?>