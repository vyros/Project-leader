<?php

class UTILISATEUR extends CLASSE {

    private $m_id;
    private $m_login;
    private $m_mail;
    private $m_mdp;
    private $m_nom;
    private $m_prenom;
    private $m_ddn;
    private $m_adresse;
    private $m_cp;
    private $m_ville;
    private $m_tel;
    private $m_presentation;
    private $m_statut;
    private $m_date;
    private $m_ddc;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM utilisateur " .
                " WHERE uti_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getOneLevelArray(SITE::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_login = stripslashes($array[uti_login]);
            $this->m_mail = stripslashes($array[uti_mail]);
            $this->m_mdp = stripslashes($array[uti_mdp]);
            $this->m_nom = stripslashes($array[uti_nom]);
            $this->m_prenom = stripslashes($array[uti_prenom]);
            $this->m_ddn = stripslashes($array[uti_ddn]);
            $this->m_adresse = stripslashes($array[uti_adresse]);
            $this->m_cp = stripslashes($array[uti_cp]);
            $this->m_ville = stripslashes($array[uti_ville]);
            $this->m_tel = stripslashes($array[uti_tel]);
            $this->m_presentation = stripslashes($array[uti_presentation]);
            # Le statut
            $this->m_statut = $this->chkStatut(stripslashes($array[uti_statut]));
            $this->m_date = stripslashes($array[uti_date]);
            $this->m_ddc = stripslashes($array[uti_ddc]);
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
                " WHERE uti_login = '" . $p_log . "' " .
                " AND uti_mdp = '" . $p_mdp . "' LIMIT 1;";

        return SITE::getConnexion()->getFetchArray($requete);
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
                " WHERE uti_id = '" . $this->m_id . "'" .
                " ORDER BY par_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return SITE::getConnexion()->getFetchArray($requete);
    }
    
    
    public function getLstNLastProjetObjs($p_n = 0) {
        $lstArray = $this->getLstNLastProjetIds($p_n);
        $objArray = null;
        
        foreach ($lstArray as $value) {
            $objArray[] = new PROJET($value);
        }
        
        return $objArray;
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
                " WHERE pa.uti_id = " . $this->m_id . " " .
                " AND pr.eta_id = 3 ORDER BY pa.par_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return SITE::getConnexion()->getFetchArray($requete);
    }

    
    /**
     * Ajoute un utilisateur.
     * 
     * @return UTILISATEUR Retourne le nouvel objet en cas de succès, sinon retourne null.
     */
    public function addUtilisateur($p_log, $p_mail, $p_mdp, $p_statut) {

        $requete = "INSERT INTO utilisateur (uti_login, uti_statut, uti_mail, uti_mdp, uti_nom, uti_prenom, uti_ddn, uti_adresse, uti_cp, uti_ville, uti_tel, uti_presentation, uti_date) " .
                "VALUES ('" . $p_log . "','" . $p_statut . "','" . $p_mail . "','" . $p_mdp . "','','','','','','','','','" . date("c") . "')";

        $idUtilisateur = SITE::getConnexion()->doSql($requete, "utilisateur");
        if ($idUtilisateur) {
            return new UTILISATEUR($idUtilisateur);
        }
        return null;
    }

    private function chkStatut($p_statut) {
        if ($p_statut == "client") {
            return new CLIENT($p_statut);
        } elseif ($p_statut == "prestataire") {
            return new PRESTATAIRE($p_statut);
        }

        return null;
    }

    public function getId($p_log = null, $p_mdp = null) {
        return $this->m_id;
    }

    public function getLogin() {
        return $this->m_login;
    }

    public function getMdp() {
        return $this->m_mdp;
    }

    public function getNom() {
        return $this->m_nom;
    }

    public function getPrenom() {
        return $this->m_prenom;
    }

    public function getDdn() {
        return $this->m_ddn;
    }

    public function getAdresse() {
        return $this->m_adresse;
    }

    public function getCp() {
        return $this->m_cp;
    }

    public function getVille() {
        return $this->m_ville;
    }

    public function getTel() {
        return $this->m_tel;
    }

    public function getMail() {
        return $this->m_mail;
    }

    /**
     * Retourne le statut de l'utilisateur.
     * 
     * @return UTILISATEUR 
     */
    public function getStatut() {
        return $this->m_statut;
    }

    public function getDateCreation() {
        return $this->m_date;
    }

    public function __toString() {
        return "$this->m_login depuis $this->m_date";
    }

}

?>