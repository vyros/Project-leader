<?php

/**
 * Description of Projet
 *
 * @author nicolas.gard
 */
class Projet extends Classe {
//    const PREFIX = 'prj';
//    const TABLE = 'projet';

    /**
     *
     * @var array 
     */
    private $competence_ids;

    /**
     *
     * @var Etat 
     */
    private $etat_obj;

    public function __construct($p_id) {

        $this->prefix = 'prj';
        $this->table = 'projet';

        parent::__construct($p_id);

        if ($this->checkPrivate()) {
            # Les competences
            $this->getCompetenceIds();

            # L'objet état
            $this->getEtatObj();
        }
    }

    /**
     * Ajoute un projet.
     * 
     * @return Projet Retourne le nouvel objet en cas de succès, sinon retourne null.
     *  Permet instanceof Object.
     */
    static public function add($p_etat_id, $p_libelle, $p_description, $p_budget, $p_echeance) {

        if (is_null($idEtat = Site::isValidId($p_etat_id)))
            return null;

        $libelle = Connexion::getSafeString($p_libelle);
        $description = Connexion::getSafeString($p_description);
        $budget = Connexion::getSafeString($p_budget);
        $echeance = Connexion::getSafeString($p_echeance);

        $requete = "INSERT INTO projet (etat_id, prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES (" . $idEtat . ", '" . $libelle . "','" . $description . "','" . $budget . "','" . $echeance . "','" . date("c") . "');";

        if ($idProjet = Site::getConnexion()->doSql($requete, "projet")) {
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

        if (is_null($idUtilisateur = Site::isValidId($p_idUtilisateur)))
            return false;

        $requete = "INSERT INTO participer (prj_id, uti_id, par_date) " .
                "VALUES (" . $this->getPrivate("id") . "," . $idUtilisateur . ",'" . date("c") . "')";

        return Site::getConnexion()->doSql($requete);
    }

    // Gestion des compétences
    public function addCompetences($p_cpt_ids) {

        if (is_null($p_cpt_ids) || !count($p_cpt_ids))
            return null;

        foreach ($p_cpt_ids as $cpt_id) {

            if (is_null($idCompetence = Site::isValidId($cpt_id)))
                continue;

            $requete = "INSERT INTO demander (prj_id, cpt_id) " .
                    "VALUES (" . $this->getPrivate("id") . ", " . $idCompetence . ");";

            Site::getConnexion()->doSql($requete);
        }
    }

    public function removeCompetences($p_cpt_array) {

        if (is_null($p_cpt_array) || !count($p_cpt_array))
            return null;

        foreach ($p_cpt_array as $cpt_id) {

            if (is_null($idCompetence = Site::isValidId($cpt_id)))
                continue;

            $requete = " DELETE FROM demander WHERE cpt_id = " . $idCompetence .
                    " AND prj_id = " . $this->getPrivate("id") . ";";

            Site::getConnexion()->doSql($requete);
        }
    }

    public function addDocuments($p_doc_ids) {

        if (is_null($p_doc_ids) || !count($p_doc_ids))
            return null;

        foreach ($p_doc_ids as $doc_id) {

            if (is_null($idDocument = Site::isValidId($doc_id)))
                continue;

            ;
        }
    }
    
    public function edit() {

        $requete = " UPDATE projet SET prj_libelle = '" . $this->getSafePrivate("libelle") . "'," .
                " prj_description = '" . $this->getSafePrivate("description") . "', prj_budget = '" . $this->getSafePrivate("budget") . "'," .
                " prj_echeance = '" . $this->getSafePrivate("echeance") . "', etat_id = " . $this->getSafePrivate("eta") . "," .
                " WHERE pjr_id = " . $this->getPrivate("id") . ";";

        $tabAjouterComp = array_diff($this->competence_ids, $this->getCompetenceIds());
        $tabSupprimerComp = array_diff($this->getCompetenceIds(), $this->competence_ids);

        if (Site::getConnexion()->doSql($requete)) {

            if (is_null($tabAjouterComp))
                $tabAjouterComp = $this->competence_ids;

            $this->addCompetences($tabAjouterComp);
            $this->removeCompetences($tabSupprimerComp);

            return $this;
        }
        return null;
    }

    /**
     * Retourne la competence associée au projet.
     * 
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    private function getCompetenceIds($p_n) {

        if (!isset($this->competence_ids)) {

            $requete = "SELECT cpt_id FROM demander " .
                    " WHERE prj_id = " . $this->getPrivate("id");

            $this->competence_ids = Site::getConnexion()->getIds($requete, $p_n);

            if (Site::isValidIds($this->competence_ids))
                sort($this->competence_ids);
            else
                $this->competence_ids = array();
        }
        return $this->competence_ids;
    }

    /**
     * Retourne la competence associée au projet.
     * 
     * @return array Retourne un tableau contenant l'objet de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCompetenceObjs() {

        $lstObjs = null;
        if (is_null($this->competence_ids) || !count($this->competence_ids))
            return null;

        foreach ($this->competence_ids as $idObj) {
            $lstObjs[] = new Competence($idObj);
        }
        return $lstObjs;
    }

    public function getDocumentIds($p_n = 0) {

        $requete = " SELECT doc_id FROM document " .
                " WHERE projet_id = " . $this->getPrivate("id") . ";";

        return Site::getConnexion()->getIds($requete, $p_n);
    }
    
    public function getDocumentObjs($p_n = 0) {

        $lstIds = $this->getDocumentIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Document($idObj);
        }

        return $lstObjs;
    }

    /**
     * Contrôle, instancie et retourne.
     * 
     * @return Etat Retourne null sinon.
     */
    public function getEtatObj() {

        if (!$this->etat_obj instanceof Etat) {
            $this->etat_obj = new Etat($this->getPrivate("etat"));
        }

        return $this->etat_obj;
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private static function getNIds($p_n = 0) {

        $requete = "SELECT prj_id FROM projet ORDER BY prj_date DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public static function getNObjs($p_n = 0) {

        $lstIds = self::getNIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Projet($idObj);
        }

        return $lstObjs;
    }

    public function getProjetSimilaireIds($p_n = 0) {

        $lstIds = array();

        if (!is_null($this->competence_ids) && count($this->competence_ids)) {
            foreach ($this->competence_ids as $cpt_id) {

                if (is_null($idCompetence = Site::isValidId($cpt_id)))
                    continue;

                $requete = " SELECT prj_id FROM demander" .
                        " WHERE cpt_id = " . $idCompetence . ";";

                $lstIds[] = Site::getConnexion()->getIds($requete, $p_n);
            }
        }

        return $lstIds;
    }

    // Accesseurs publics
    public function getId() {
        return $this->getPrivate("id");
    }

    public function getEtatId() {
        return $this->getPrivate("etat");
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

    /**
     *
     * @return String 
     */
    public function getDate() {
        return Site::dateMysql2Picker($this->getPrivate("date"));
    }

    public function getPorteurIds($p_n = 0) {

        $requete = "SELECT u.uti_id FROM utilisateur u, participer p " .
                " WHERE u.uti_statut = 'client' " .
                " AND u.uti_id = p.uti_id " .
                " AND p.prj_id = " . $this->getPrivate("id");

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getPrestataireIds($p_n = 0) {

        $requete = "SELECT u.uti_id FROM utilisateur u, participer p " .
                " WHERE u.uti_statut = 'prestataire' " .
                " AND u.uti_id = p.uti_id " .
                " AND p.prj_id = " . $this->getPrivate("id");

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    /**
     * Retourne vrai si l'utilisateur est un porteur du projet, sinon retourne faux.
     * 
     * @param Utilisateur $p_porteur
     * @return boolean 
     */
    public function isPorteur($p_porteur) {
        if (!is_null($lstPorteurIds = $this->getPorteurIds())) {
            foreach ($lstPorteurIds as $value) {
                if ($value[0] == $p_porteur->getId())
                    return true;
            }
        }

        return false;
    }

    public function isPrestataire($p_prestataire) {
        if (!is_null($lstPrestataireIds = $this->getPrestataireIds())) {
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

    public function setCompetenceIds($p_value) {
        if (!is_null($p_value))
            sort($p_value);

        $this->competence_ids = $p_value;
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