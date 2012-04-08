<?php
include_once("classConnect.php");

class UTILISATEUR {

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
    private $m_dateInscription;

    public function __construct() {
        // distinction existant/ nouveau en fonction du nombre d'arguments
        $nombreArgument = func_num_args();
        if ($nombreArgument == 1) {
            // l'id
            $t_code = func_get_arg(0);

            // appel du constructeur existant avec l'id
            $this->existant($t_code);
            
        } elseif ($nombreArgument == 2) {
            
        }
    }

    public function existant($p_code) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM UTILISATEUR " .
                " WHERE uti_id = " . $p_code . " LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::executeSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_id = $p_code;
            $this->m_login = stripslashes($ligne['uti_login']);
            $this->m_mail = stripslashes($ligne['uti_mail']);
            $this->m_mdp = stripslashes($ligne['uti_mdp']);
            $this->m_nom = stripslashes($ligne['uti_nom']);
            $this->m_prenom = stripslashes($ligne['uti_prenom']);
            $this->m_ddn = stripslashes($ligne['uti_ddn']);
            $this->m_adresse = stripslashes($ligne['uti_adresse']);
            $this->m_cp = stripslashes($ligne['uti_cp']);
            $this->m_ville = stripslashes($ligne['uti_ville']);
            $this->m_tel = stripslashes($ligne['uti_tel']);
            $this->m_presentation = stripslashes($ligne['uti_presentation']);
            $this->m_statut = stripslashes($ligne['uti_statut']);
            $this->m_dateInscription = stripslashes($ligne['uti_dateInscription']);
        }
    }

    public static function verifAccess($p_log, $p_mdp) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM UTILISATEUR " .
                " WHERE uti_login = '" . $p_log . "' " .
                " AND uti_mdp = '" . $p_mdp . "' LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::executeSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");

        return $resultat;
    }

    public static function voirParticipation($p_id) {

        $connexion = new Connexion();

        //requete qui donne resultat si l'id de l'uti en parametre existe dans la table Participer
    }

    public function inserUti($p_log, $p_mail, $p_mdp, $p_statut) {

        $connexion = new Connexion();
        $dateInscription = date("Y-m-d");
        
        $query = "INSERT INTO UTILISATEUR (uti_login, uti_statut, uti_mail, uti_mdp, uti_nom, uti_prenom, uti_ddn, uti_adresse, uti_cp, uti_ville, uti_tel, uti_presentation, uti_date_entree) " .
                "VALUES ('" . $p_log . "','" . $p_statut . "','" . $p_mail . "','" . $p_mdp . "','','','','','','','','','" . $dateInscription . "')";
        var_dump($query);
        return mysql_query($query);
    }

// accesseurs
    public function getId() {
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

    public function getAdr() {
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

    public function getStatut() {
        return $this->m_statut;
    }
}
?>