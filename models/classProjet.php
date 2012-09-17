<?php

class Projet extends Classe {

    /**
     *
     * @var array 
     */
    private $m_cat_array;

    /**
     *
     * @var array 
     */
    private $m_cpt_array;

    /**
     *
     * @var Etat 
     */
    private $m_etat_obj;

    /**
     *
     * @var array 
     */
    private $m_private;

    /**
     *
     * @var String 
     */
    private static $suffix = "prj";

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM projet " .
                " WHERE prj_id = " . Connexion::getSafeString($p_id) . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete, MYSQL_ASSOC));
        if ($array != null) {
            foreach ($array as $key => $value) {
                $cle = split("_", $key);
                if ($cle[0] != self::$suffix) {
                    $this->m_private[$cle[0]] = Connexion::getOriginalString($value);
                } else {
                    $this->m_private[$cle[1]] = Connexion::getOriginalString($value);
                }
            }

            $this->m_cat_array = $this->getCategorieIds();
            if (!is_null($this->m_cat_array))
                sort($this->m_cat_array);

            $this->m_cpt_array = $this->getCompetenceIds();
            if (!is_null($this->m_cpt_array))
                sort($this->m_cpt_array);

            $this->getEtatObj();
        } else {
            unset($this);
        }
    }

    public function getDocumentIds() {

        $requete = " SELECT doc_id FROM document " .
                " WHERE prj_id = " . $this->getSafePrivate("id") . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Contrôle, instancie et retourne
     * 
     * @return Etat 
     */
    public function getEtatObj() {

        if (!$this->m_etat_obj instanceof Etat) {

            if ($idEtat = Site::isValidId($this->getPrivate("eta"))) {
                $this->m_etat_obj = new Etat($idEtat);
            } else {
                return null;
            }
        }

        return $this->m_etat_obj;
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
    static public function add($p_etat, $p_libelle, $p_description, $p_budget, $p_echeance) {

        // Controle

        $requete = "INSERT INTO projet (eta_id, prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES (" . $p_etat . ", '" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_echeance . "','" . date("c") . "')";

        $idProjet = Site::getConnexion()->doSql($requete, "projet");
        if ($idProjet) {
            return new Projet($idProjet);
        }

        return null;
    }

    /**
     * Ajoute une participation au projet.
     * 
     * @param int $p_idUtilisateur Id de l'utilisateur.
     * 
     * @return boolean Retourne vrai si succès, sinon retourne non.
     */
    public function addParticipation($p_idUtilisateur) {

        $requete = "INSERT INTO participer (prj_id, uti_id, par_date) " .
                "VALUES (" . $this->getSafePrivate("id") . "," . $p_idUtilisateur . ",'" . date("c") . "')";

        return Site::getConnexion()->doSql($requete);
    }

    public function edit() {

        $requete = " UPDATE projet SET prj_libelle = '" . $this->getSafePrivate("libelle") . "'," .
                " prj_description = '" . $this->getSafePrivate("description") . "', prj_budget = '" . $this->getSafePrivate("budget") . "'," .
                " prj_echeance = '" . $this->getSafePrivate("echeance") . "', etat_id = " . $this->getSafePrivate("eta") . "," .
                " WHERE pjr_id = " . $this->getSafePrivate("id") . ";";

        $tabAjouterCat = array_diff($this->m_cat_array, $this->getCategorieIds());
        $tabSupprimerCat = array_diff($this->getCategorieIds(), $this->m_cat_array);

        $tabAjouterComp = array_diff($this->m_cpt_array, $this->getCompetenceIds());
        $tabSupprimerComp = array_diff($this->getCompetenceIds(), $this->m_cpt_array);

        if (Site::getConnexion()->doSql($requete)) {

            if (is_null($tabAjouterCat))
                $tabAjouterCat = $this->m_cat_array;

            Correspondre::addCorrespondance($this->getPrivate("id"), $tabAjouterCat);
            Correspondre::removeCategorie($this->getPrivate("id"), $tabSupprimerCat);

            // Y A UN BUG ICI?!?
            //return $this;

            if (is_null($tabAjouterComp))
                $tabAjouterComp = $this->m_cat_array;

            Correspondre::addCorrespondance($this->getPrivate("id"), $tabAjouterComp);
            Correspondre::removeCategorie($this->getPrivate("id"), $tabSupprimerCat);

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
                " WHERE prj_id = " . $this->getSafePrivate("id") . ";";

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
                " WHERE prj_id = " . $this->getSafePrivate("id") . ";";

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

    public static function getProjetSimilaire($idCategorie) {

        $requete = " SELECT p.prj_id FROM categorie cat, demander d, correspondre c, projet p " .
                " WHERE cat.cat_id = '" . $idCategorie . "' " .
                " AND cat.cat_id = c.cat_id " .
                " AND p.prj_id = c.prj_id ";

        echo $requete;

        return Site::getConnexion()->getFetchArray($requete);
    }

    // Accesseurs privés
    private function getPrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->m_private))
            return null;

        return $this->m_private[$key];
    }

    private function getSafePrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->m_private))
            return null;

        return Connexion::getSafeString($this->m_private[$key]);
    }

    private function setPrivate($key = null, $value = null) {
        if (!is_string($key) || $key == "")
            return false;

        if (!array_key_exists($key, $this->m_private) || is_null($value))
            return false;

        $this->m_private[$key] = $value;

        return true;
    }

    // Accesseurs publics
    public function getId() {
        return $this->getPrivate("id");
    }

    public function getEtatId() {
        return $this->getPrivate("eta");
    }

    public function getLibelle() {
        return $this->getPrivate("libelle");
    }

    public function getDescription() {
        return $this->getPrivate("description");
    }

    public function getBudget() {
        return $this->getPrivate("budget");
    }

    public function getEcheance() {
        return $this->getPrivate("echeance");
    }

    public function getDate() {
        return $this->getPrivate("date");
    }

    public function getPorteurIds() {
        $requete = "SELECT u.uti_id FROM utilisateur u, participer p " .
                " WHERE u.uti_statut = 'client' " .
                " AND u.uti_id = p.uti_id " .
                " AND p.prj_id = " . $this->getSafePrivate("id") . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    public function getPrestataireIds() {
        $requete = "SELECT u.uti_id FROM utilisateur u, participer p " .
                " WHERE u.uti_statut = 'prestataire' " .
                " AND u.uti_id = p.uti_id " .
                " AND p.prj_id = " . $this->getSafePrivate("id") . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Retourne vrai si l'utilisateur est un porteur du projet, sinon retourne faux.
     * 
     * @param Utilisateur $p_porteur
     * @return boolean 
     */
    public function isPorteur($p_porteur) {
        if ($lstPorteurIds = $this->getPorteurIds()) {
            foreach ($lstPorteurIds as $value) {
                if ($value[0] == $p_porteur->getId())
                    return true;
            }
        }
        
        return false;
    }

    public function isPrestataire($p_prestataire) {
        if ($lstPrestataireIds = $this->getPrestataireIds()) {
            foreach ($lstPrestataireIds as $value) {
                if ($value[0] == $p_prestataire->getId())
                    return true;
            }
        }
        
        return false;
    }

    public function __toString() {
        return "id : " . $this->getPrivate("id") . " ; libelle : " . $this->getPrivate("libelle");
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

    public function setBudget($p_value) {
        return $this->setPrivate("budget", $p_value);
    }

    public function setDescription($p_value) {
        return $this->setPrivate("description", $p_value);
    }

    public function setEcheance($p_value) {
        return $this->setPrivate("echeance", $p_value);
    }

    public function setEtat($p_value) {
        return $this->setPrivate("eta", $p_value);
    }

    public function setLibelle($p_value) {
        return $this->setPrivate("libelle", $p_value);
    }

}

?>