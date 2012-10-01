<?php

/**
 * Description of Utilisateur
 *
 * @author jimmy
 */
class Utilisateur extends Classe {
//    const PREFIX = 'uti';
//    const TABLE = 'utilisateur';

    /**
     *
     * @var array 
     */
    private $cv_ids;

    /**
     *
     * @var array 
     */
    private $competence_ids;

    public function __construct($p_id) {

        $this->prefix = 'uti';
        $this->table = 'utilisateur';

        parent::__construct($p_id);

        if ($this->checkPrivate()) {
            # Les competences
            $this->getCompetenceIds();

            # Les CVs
            $this->getCvIds();
        }
    }

    /**
     * Ajoute un utilisateur.
     * 
     * @return Utilisateur Retourne le nouvel objet en cas de succès, sinon retourne null.
     *  Permet instanceof Object.
     */
    public static function add($p_log, $p_mail, $p_mdp, $p_statut) {

        $actif = 0;
        $hdp = sha1($p_mdp);
        $login = Connexion::getSafeString($p_log);
        $mail = Connexion::getSafeString($p_mail);
        $mdp = Connexion::getSafeString($p_mdp);
        $token = Utilisateur::getNewToken($p_mail);

        $requete = "INSERT INTO utilisateur (uti_login, uti_statut, uti_mail, uti_mdp, uti_hdp, uti_actif, uti_token, uti_nom, uti_prenom, uti_ddn, uti_adresse, uti_cp, uti_ville, uti_tel, uti_presentation, uti_date) " .
                "VALUES ('" . $login . "','" . $p_statut . "','" . $mail . "','" . $mdp . "','" . $hdp . "'," . $actif . ",'" . $token . "','','','','','','','','','" . date("c") . "')";

        if ($idUtilisateur = Site::getConnexion()->doSql($requete, "utilisateur")) {
            return new Utilisateur($idUtilisateur);
        }

        return null;
    }

    // Gestion des compétences
    public function addCompetences($p_cpt_ids) {

        if (is_null($p_cpt_ids) || !count($p_cpt_ids))
            return null;

        foreach ($p_cpt_ids as $cpt_id) {

            if (is_null($idCompetence = Site::isValidId($cpt_id)))
                continue;

            $requete = "INSERT INTO posseder (uti_id, cpt_id, pos_date) " .
                    "VALUES (" . $this->getPrivate("id") . ", " . $idCompetence . ", '" . date("c") . "');";

            Site::getConnexion()->doSql($requete);
        }
    }

    public function removeCompetences($p_cpt_ids) {

        if (is_null($p_cpt_ids) || !count($p_cpt_ids))
            return null;

        foreach ($p_cpt_ids as $cpt_id) {

            if (is_null($idCompetence = Site::isValidId($cpt_id)))
                continue;

            $requete = " DELETE FROM posseder WHERE cpt_id = " . $idCompetence .
                    " AND uti_id = " . $this->getPrivate("id") . ";";

            Site::getConnexion()->doSql($requete);
        }
    }

    /**
     * Editer un utilisateur.
     * 
     * @return Utilisateur Retourne l'objet utilisateur en cas de succès, sinon retourne null.
     *  Permet instanceof Utilisateur.
     */
    public function edit() {

        $requete = " UPDATE utilisateur SET uti_nom = '" . $this->getSafePrivate("nom") . "'," .
                " uti_actif = " . $this->getSafePrivate("actif") . ", uti_token = '" . $this->getSafePrivate("token") . "'," .
                " uti_prenom = '" . $this->getSafePrivate("prenom") . "', uti_ddn = '" . $this->getSafePrivate("ddn") . "'," .
                " uti_adresse = '" . $this->getSafePrivate("adresse") . "', uti_cp = '" . $this->getSafePrivate("cp") . "'," .
                " uti_ville = '" . $this->getSafePrivate("ville") . "', uti_tel = '" . $this->getSafePrivate("tel") . "'," .
                " uti_presentation = '" . $this->getSafePrivate("presentation") . "' WHERE uti_id = " . $this->getPrivate("id") . ";";

        $tabAjouter = array_diff($this->competence_ids, $this->getCompetenceIds());
        $tabSupprimer = array_diff($this->getCompetenceIds(), $this->competence_ids);

        if (Site::getConnexion()->doSql($requete)) {

            if (is_null($tabAjouter))
                $tabAjouter = $this->competence_ids;

            $this->addCompetences($tabAjouter);
            $this->removeCompetences($tabSupprimer);

            return $this;
        }
        return null;
    }

    /**
     * Fonction static d'authentification d'un couple login|mdp.
     * 
     * @param string $p_log Le login
     * @param string $p_mdp Le mot de passe
     * @return array Retourne un tableau avec l'id de l'utilisateur associé 
     *  au couple login|mdp, retourne null si aucun enregistrement.
     */
    public static function access2Id($p_log, $p_mdp) {

        $requete = " SELECT uti_id FROM utilisateur " .
                " WHERE uti_login = '" . Connexion::getSafeString($p_log) . "' " .
                " AND uti_mdp = '" . Connexion::getSafeString($p_mdp) . "'";

        return Site::getConnexion()->getIds($requete, 1);
    }
    
    public static function login2Id($p_log) {

        $requete = " SELECT uti_id FROM utilisateur " .
                " WHERE uti_login = '" . Connexion::getSafeString($p_log) . "'";

        return Site::getConnexion()->getIds($requete, 1);
    }

    /**
     * 
     * @return Competence[] Retourne un tableau d'objets compétences, ou null.
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

    private function getCompetenceIds($p_n = 0) {

        if (!isset($this->competence_ids)) {

            $requete = "SELECT cpt_id FROM posseder " .
                    " WHERE uti_id = " . $this->getPrivate("id");

            $this->competence_ids = Site::getConnexion()->getIds($requete, $p_n);

            if (Site::isValidIds($this->competence_ids))
                sort($this->competence_ids);
            else
                $this->competence_ids = array();
        }
        return $this->competence_ids;
    }

    public function getCvObjs() {

        $lstIds = $this->cv_ids;
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Document($idObj);
        }

        return $lstObjs;
    }

    private function getCvIds($p_n = 0) {

        if (!isset($this->cv_ids)) {

            $requete = " SELECT doc_id FROM document " .
                    " WHERE utilisateur_id = " . $this->getPrivate("id") .
                    " AND doc_nature = 'curriculum' ";

            $this->cv_ids = Site::getConnexion()->getIds($requete, $p_n);

            if (Site::isValidIds($this->cv_ids))
                sort($this->cv_ids);
            else
                $this->cv_ids = array();
        }
        return $this->cv_ids;
    }

    public function getMessageCount($p_lu = null) {
        return count($this->getMessageIds($p_lu));
    }
    
    public function getMessageIds($p_lu = null) {

        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND receveur_id = " . $this->getPrivate('id');
        
        if(!is_null($p_lu) && is_numeric($lu = $p_lu))
            $requete .= " AND not_lu = " .$lu;
        
        $requete .= ";";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getMessageObjs($p_lu = null) {

        $lstIds = $this->getMessageIds($p_lu);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Notification($idObj);
        }

        return $lstObjs;
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private static function getNIds($p_n = 0) {

        $requete = "SELECT uti_id FROM utilisateur ORDER BY uti_date DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public static function getNObjs($p_n = 0) {

        $lstIds = self::getNIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Utilisateur($idObj);
        }

        return $lstObjs;
    }

    /**
     * Obtenir les N derniers projets fermés de l'utilisateur. 
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getNClosedProjetIds($p_n = 0) {

        $requete = " SELECT pa.prj_id FROM participer as pa " .
                " INNER JOIN projet as pr ON pa.prj_id = pr.prj_id " .
                " WHERE pa.uti_id = " . $this->getPrivate("id") .
                " AND pr.etat_id = 3 ORDER BY pa.par_date DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getNClosedProjetObjs($p_n = 0) {

        $lstIds = $this->getNClosedProjetIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Projet($idObj);
        }

        return $lstObjs;
    }

    /**
     * Obtenir les N derniers projets ouverts de l'utilisateur. 
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getNOpenedProjetIds($p_n = 0) {

        $requete = " SELECT pa.prj_id FROM participer as pa " .
                " INNER JOIN projet as pr ON pa.prj_id = pr.prj_id " .
                " WHERE pa.uti_id = " . $this->getPrivate("id") .
                " AND pr.etat_id = 2 ORDER BY pa.par_date DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getNOpenedProjetObjs($p_n = 0) {

        $lstIds = $this->getNOpenedProjetIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Projet($idObj);
        }

        return $lstObjs;
    }

    public function getNCommentaireIds($p_n = 0) {

        $requete = " SELECT prj_id FROM participer " .
                " WHERE uti_id = " . $this->getPrivate("id") .
                " ORDER BY par_date DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getNCommentaireObjs($p_n = 0) {

        $lstIds = $this->getNCommentaireIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Projet($idObj);
        }

        return $lstObjs;
    }

    /**
     * Obtenir les N derniers projets de l'utilisateur. 
     * Tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private function getNProjetIds($p_n = 0) {

        $requete = " SELECT prj_id FROM participer " .
                " WHERE uti_id = " . $this->getPrivate("id") .
                " ORDER BY prj_id DESC ";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public function getNProjetObjs($p_n = 0) {

        $lstIds = $this->getNProjetIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Projet($idObj);
        }

        return $lstObjs;
    }

    /**
     *
     * @return int 
     */
    public function getNombreProjets() {
        return count($this->getNProjetIds());
    }

    public function getRatio() {

        $result = 1;

        $result = ($this->getPrivate("nom") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("prenom") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("ddn") !== "0000-00-00") ? $result + 1 : $result;
        $result = ($this->getPrivate("adresse") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("cp") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("ville") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("tel") !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("presentation") !== "") ? $result + 1 : $result;

        $result = (count($this->getCvIds(1))) ? $result + 1 : $result;
        $result = (count($this->getCompetenceIds(1)) !== "") ? $result + 1 : $result;

        return $result * 10;
    }

    public function setCompetenseIds($p_ids) {
        if (Site::isValidIds($p_ids)) {
            sort($p_ids);
            $this->competence_ids = $p_ids;
        }
    }

    public function setCvIds($p_ids) {
        if (Site::isValidIds($p_ids)) {
            sort($p_ids);
            $this->cv_ids = $p_ids;
        }
    }

    // Token
    public function chkToken($p_token) {
        if ($p_token == $this->getPrivate("token")) {
            return true;
        }

        return false;
    }

    private static function getNewToken($p_mail) {
        return sha1(rand(0, getrandmax()) . "&$p_mail%" . rand(0, getrandmax()));
    }

    public function setNewToken() {
        $this->setPrivate("token", Utilisateur::getNewToken($this->getPrivate("mail")));
    }

    // Accesseurs publics
    public function __toString() {
        return $this->getPrivate("login") . " depuis " . $this->getPrivate("date");
    }

    public function getActif() {
        return $this->getPrivate("actif");
    }

    public function getAdresse() {
        return $this->getPrivate("adresse");
    }

    public function getCp() {
        return $this->getPrivate("cp");
    }

    /**
     *
     * @return String 
     */
    public function getDate() {
        return Site::dateMysql2Picker($this->getPrivate("date"));
    }

    public function getDdn() {
        return Site::dateMysql2Picker($this->getPrivate("ddn"));
    }

    public function getHdp() {
        return $this->getPrivate("hdp");
    }

    public function getId() {
        return $this->getPrivate("id");
    }

    public function getLogin() {
        return $this->getPrivate("login");
    }

    public function getMail() {
        return $this->getPrivate("mail");
    }

    public function getMdp() {
        return $this->getPrivate("mdp");
    }

    public function getNom() {
        return $this->getPrivate("nom");
    }

    public function getPrenom() {
        return $this->getPrivate("prenom");
    }

    public function getPresentation() {
        return $this->getPrivate("presentation");
    }

    public function getStatut() {
        return $this->getPrivate("statut");
    }

    public function getTel() {
        return $this->getPrivate("tel");
    }

    public function getToken() {
        return $this->getPrivate("token");
    }

    public function getVille() {
        return $this->getPrivate("ville");
    }

    public function setActif($p_value) {
        if (!is_bool($p_value))
            return false;

        return $this->setPrivate("actif", $p_value);
    }

    public function setAdresse($p_value) {
        return $this->setPrivate("adresse", $p_value);
    }

    public function setCp($p_value) {
        return $this->setPrivate("cp", $p_value);
    }

    public function setDdc($p_value) {
        return $this->setPrivate("ddc", Site::datePicker2Mysql($p_value));
    }

    public function setDdn($p_value) {
        return $this->setPrivate("ddn", Site::datePicker2Mysql($p_value));
    }

    public function setNom($p_value) {
        return $this->setPrivate("nom", $p_value);
    }

    public function setPrenom($p_value) {
        return $this->setPrivate("prenom", $p_value);
    }

    public function setPresentation($p_value) {
        return $this->setPrivate("presentation", $p_value);
    }

    public function setTel($p_value) {
        return $this->setPrivate("tel", $p_value);
    }

    public function setVille($p_value) {
        return $this->setPrivate("ville", $p_value);
    }

    /**
     * A revoir
     */
    public function isFavoris($p_prjId) {

        $requete = " SELECT * FROM aimer " .
                " WHERE prj_id = '" . $p_prjId . "'" .
                " AND uti_id = '" . $this->getPrivate("id") . "'";

        $array = Site::getConnexion()->getFetchIntArray($requete);
        if ($array != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function StatutConnecte($idUti) {
        $requete = " UPDATE utilisateur SET uti_enligne = 'ok'" .
                " WHERE uti_id = '" . $idUti . "';";

        Site::getConnexion()->doSql($requete);
    }

    public static function StatutDeconnecte($idUti) {
        $requete = " UPDATE utilisateur SET uti_enligne = ''" .
                " WHERE uti_id = '" . $idUti . "';";

        Site::getConnexion()->doSql($requete);
    }

    public function getProjetsFavoriIds() {

        $requete = " SELECT prj_id FROM aimer " .
                " WHERE uti_id = " . $this->getPrivate("id") . ";";

        return Site::getConnexion()->getFetchIntArray($requete);
    }

}

?>
