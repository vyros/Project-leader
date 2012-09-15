<?php

class Utilisateur extends Classe {

    /**
     *
     * @var array 
     */
    private $m_cv_array;

    /**
     *
     * @var array 
     */
    private $m_cpt_array;

    /**
     *
     * @var array 
     */
    private $m_private;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    /**
     * Ajoute un utilisateur.
     * 
     * @return Utilisateur Retourne le nouvel objet en cas de succès, sinon retourne null.
     */
    public static function addUtilisateur($p_log, $p_mail, $p_mdp, $p_statut) {

        $actif = 0;
        $hdp = sha1($p_mdp);
        $login = Connexion::getSafeString($p_log);
        $mail = Connexion::getSafeString($p_mail);
        $mdp = Connexion::getSafeString($p_mdp);
        $token = Utilisateur::getNewToken($p_mail);

        $requete = "INSERT INTO utilisateur (uti_login, uti_statut, uti_mail, uti_mdp, uti_hdp, uti_actif, uti_token, uti_nom, uti_prenom, uti_ddn, uti_adresse, uti_cp, uti_ville, uti_tel, uti_presentation, uti_date) " .
                "VALUES ('" . $login . "','" . $p_statut . "','" . $mail . "','" . $mdp . "','" . $hdp . "'," . $actif . ",'" . $token . "','','','','','','','','','" . date("c") . "')";

        $idUtilisateur = Site::getConnexion()->doSql($requete, "utilisateur");
        if ($idUtilisateur) {
            return new Utilisateur($idUtilisateur);
        }

        return null;
    }

    /**
     * Editer un utilisateur.
     * 
     * @return Utilisateur Retourne l'objet utilisateur en cas de succès, sinon retourne null.
     */
    public function editUtilisateur() {

        $requete = " UPDATE utilisateur SET uti_nom = '" . $this->getSafePrivate("nom") . "'," .
                " uti_actif = " . $this->getSafePrivate("actif") . ", uti_token = '" . $this->getSafePrivate("token") . "'," .
                " uti_prenom = '" . $this->getSafePrivate("prenom") . "', uti_ddn = '" . $this->getSafePrivate("ddn") . "'," .
                " uti_adresse = '" . $this->getSafePrivate("adresse") . "', uti_cp = '" . $this->getSafePrivate("cp") . "'," .
                " uti_ville = '" . $this->getSafePrivate("ville") . "', uti_tel = '" . $this->getSafePrivate("tel") . "'," .
                " uti_presentation = '" . $this->getSafePrivate("presentation") . "' WHERE uti_id = " . $this->getSafePrivate("id") . ";";

        $tabAjouter = array_diff($this->m_cpt_array, $this->getCompetenceIds());
        $tabSupprimer = array_diff($this->getCompetenceIds(), $this->m_cpt_array);

        if (Site::getConnexion()->doSql($requete)) {

            if (is_null($tabAjouter))
                $tabAjouter = $this->m_cpt_array;

            Posseder::addCompetences($this->getPrivate("id"), $tabAjouter);
            Posseder::removeCompetences($this->getPrivate("id"), $tabSupprimer);

            return $this;
        }
        return null;
    }

    public function exists($p_id) {

        if (!is_numeric($p_id))
            return null;

        $requete = " SELECT * FROM utilisateur " .
                " WHERE uti_id = " . Connexion::getSafeString($p_id) . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete, MYSQL_ASSOC));
           $arraytmp = Site::getConnexion()->getFetchArray($requete, MYSQL_ASSOC);
        
        
        if ($array != null) {
            foreach ($array as $key => $value) {
                $cle = split("_", $key);
                $this->m_private[$cle[1]] = Connexion::getOriginalString($value);
            }

            # Les competences
            $this->m_cpt_array = $this->getCompetenceIds();
            if (!is_null($this->m_cpt_array))
                sort($this->m_cpt_array);

            # Les CVs
            $this->m_cv_array = $this->getCvIds();
        }
    }

    /**
     * Fonction static d'authentification d'un couple login|mdp.
     * 
     * @param string $p_log Le login
     * @param string $p_mdp Le mot de passe
     * @return array Retourne un tableau avec l'id de l'utilisateur associé 
     *  au couple login|mdp, retourne null si aucun enregistrement.
     */
    public static function getAccessToId($p_log, $p_mdp) {

        $requete = " SELECT uti_id FROM utilisateur " .
                " WHERE uti_login = '" . Connexion::getSafeString($p_log) . "' " .
                " AND uti_mdp = '" . Connexion::getSafeString($p_mdp) . "' LIMIT 1;";

        return Site::getConnexion()->getFetchArray($requete);
    }

    public function getCompetences() {
        return $this->m_cpt_array;
    }

    public function getCompetenceIds() {
        return Posseder::getCompetencesIdsFromUserId($this->getPrivate("id"));
    }

    public function getCvs() {
        return $this->m_cv_array;
    }

    public function getCvIds($p_n = 0) {

        $requete = " SELECT cv_id FROM cv " .
                " WHERE uti_id = " . $this->getSafePrivate("id");

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }

    /**
     * Obtenir les N derniers projets de l'utilisateur. 
     * Tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getLstNLastClosedProjetIds($p_n = 0) {

        $requete = " SELECT pa.prj_id FROM participer as pa " .
                " INNER JOIN projet as pr ON pa.prj_id = pr.prj_id " .
                " WHERE pa.uti_id = " . $this->getSafePrivate("id") .
                " AND pr.eta_id = 3 ORDER BY pa.par_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Obtenir les N derniers projets de l'utilisateur. 
     * Tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getLstNLastProjetIds($p_n = 0) {

        $requete = " SELECT prj_id FROM participer " .
                " WHERE uti_id = " . $this->getSafePrivate("id") .
                " ORDER BY par_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    public function getLstNLastProjetObjs($p_n = 0) {
        $lstArray = $this->getLstNLastProjetIds($p_n);
        $objArray = null;

        if (is_null($lstArray))
            return null;

        foreach ($lstArray as $value) {
            $objArray[] = new Projet($value);
        }

        return $objArray;
    }

    public static function getLstProjetObjsFromArrayIds($p_array) {

        $objArray = null;

        if (is_null($p_array))
            return null;

        foreach ($p_array as $value) {
            $objArray[] = new Projet($value);
        }

        return $objArray;
    }

    /**
     *
     * @return type 
     */
    public function getNombreProjets() {
        $res = $this->getLstNLastProjetIds();
        $i = 0;

        if (is_null($res)) {
            foreach ($res as $idProjet) {
                $i++;
            }
        }

        return $i;
    }

    public static function getAllNomUti() {

        $requete = "SELECT uti_nom FROM utilisateur ";

        return Site::getConnexion()->getFetchArray($requete);
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
        $result = ($this->getCvs() !== "") ? $result + 1 : $result;
        $result = ($this->getPrivate("presentation") !== "") ? $result + 1 : $result;

        return $result * 10;
    }

    public function setCompetenses($p_value) {
        if (!is_null($p_value))
            sort($p_value);

        $this->m_cpt_array = $p_value;
    }

    public function setCvs($p_value) {
        $this->m_cv_array = $p_value;
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

}

?>
