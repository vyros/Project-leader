<?php

/**
 * Description of Notification
 *
 * @author nicolas.gard
 */
class Notification extends Classe {

//    const PREFIX = 'not';
//    const TABLE = 'notification';

    public function __construct($p_id) {

        $this->prefix = 'not';
        $this->table = 'notification';

        parent::__construct($p_id);
    }

    /**
     * Ajoute une notification.
     * 
     * @return Notification Retourne le nouvel objet en cas de succès, sinon retourne null.
     *  Permet instanceof Object.
     */
    public static function add($p_nature, $p_sujet, $p_corps, $p_idEmetteur, $p_idReceveur, $p_idProjet) {

        $nature = Connexion::getSafeString($p_nature);
        $sujet = Connexion::getSafeString($p_sujet);
        $corps = Connexion::getSafeString($p_corps);
        
        if(is_null($idEmetteur = Site::isValidId($p_idEmetteur)))
            return null;
        
        if(is_null($idReceveur = Site::isValidId($p_idReceveur)))
            return null;

        if(is_null($idProjet = Site::isValidId($p_idProjet)))
            $idProjet = 'null';

        $requete = "INSERT INTO notification (not_nature, not_sujet, not_date, not_lu, not_corps, emetteur_id, receveur_id, projet_id) " .
                "VALUES ('" . $nature . "','" . $sujet . "','" . date('c') . "', 0,'" . $corps . "'," . $idEmetteur . "," . $idReceveur . "," . $idProjet . ")";

        return Site::getConnexion()->doSql($requete);
    }

    public static function addCommentaire($p_titre, $libelle, $p_idEmetteur, $p_idReceveur, $p_idProjet) {

        $requete = "INSERT INTO notification (not_sujet, not_corps, not_nature, not_date, not_lu, emetteur_id, receveur_id, projet_id) " .
                "VALUES ('" . $p_titre . "','" . $libelle . "','commentaire','" . date('c') . "','0','" . $idEmetteur . "','" . $idReceveur . "','" . $idProjet . "')";

        return Site::getConnexion()->doSql($requete);
    }

    public static function getCommentaireProjetIds($p_idProjet, $p_n = 0) {

        if (is_null($idProjet = Site::isValidId($p_idProjet)))
            return null;

        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'commentaire'" .
                " AND projet_id = " . $idProjet . ";";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public static function msgNonLu($p_idUtilisateur, $p_n = 0) {

        if (is_null($idUtilisateur = Site::isValidId($p_idUtilisateur)))
            return null;

        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND not_lu = '0' " .
                " AND receveur_id = " . $idUtilisateur . ";";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public static function msgLu($p_idUtilisateur, $p_n = 0) {

        if (is_null($idUtilisateur = Site::isValidId($p_idUtilisateur)))
            return null;

        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND not_lu = '1' " .
                " AND receveur_id = " . $idUtilisateur . ";";

        return Site::getConnexion()->getIds($requete, $p_n);
    }

    public static function getNbreNonLu($p_idUtilisateur) {

        return count(self::msgNonLu($p_idUtilisateur));
    }

    public static function getNbreLu($p_idUtilisateur) {

        return count(self::msgLu($p_idUtilisateur));
    }

    public static function getMaxNot() {

        $requete = "SELECT MAX(not_id) FROM notification ";
        return Site::getConnexion()->doSql($requete);
    }

    public static function getConversationIds($idUtilisateurCourant, $idUtilisateur) {

        $requete = " SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND (emetteur_id = " . $idUtilisateurCourant . " OR receveur_id = " . $idUtilisateurCourant . ") " .
                " AND (emetteur_id = " . $idUtilisateur . " OR receveur_id = " . $idUtilisateur . ") " .
                " ORDER BY not_id DESC ";

        return Site::getConnexion()->getIds($requete);
    }

    public static function getConversationObjs($idUtilisateurCourant, $idUtilisateur) {

        $lstIds = self::getConversationIds($idUtilisateurCourant, $idUtilisateur);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Notification($idObj);
        }

        return $lstObjs;
    }

    public function editMsgLu() {

        $requete = " UPDATE notification SET not_lu = 1 " .
                " WHERE not_id = " . $this->getPrivate('id') . ";";

        return Site::getConnexion()->doSql($requete);
    }

    public function getId() {
        return $this->getPrivate('id');
    }

    public function getSujet() {
        return $this->getPrivate('sujet');
    }

    public function getTitre() {
        return $this->getPrivate('sujet');
    }

    public function getLibelle() {
        return $this->getPrivate('corps');
    }

    /**
     *
     * @return String 
     */
    public function getDate() {
        return Site::dateMysql2Picker($this->getPrivate("date"));
    }

    public function getEmetteurId() {
        return $this->getPrivate('emetteur');
    }

    public function getEmetteurObj() {
        return new Utilisateur($this->getPrivate('emetteur'));
    }

    public function getReceveurId() {
        return $this->getPrivate('receveur');
    }

    public function getReceveurObj() {
        return new Utilisateur($this->getPrivate('receveur'));
    }

    public function setLu($value) {
        $this->setPrivate('lu', $value);
    }

}

?>
