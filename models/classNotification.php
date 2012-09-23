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
    public static function add($p_idUtilisateur, $p_idNotification) {

        /**
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         */
        $utilisateur = Connexion::getSafeString($p_idUtilisateur);
        $notification = Connexion::getSafeString($p_idNotification);

        $requete = "INSERT INTO effectuer (uti_id, not_id) " .
                "VALUES ('" . $utilisateur . "','" . $notification . "')";

        $idNotification = Site::getConnexion()->doSql($requete, "notification");
        if ($idNotification) {
            return new Notification($idNotification);
        }

        return null;
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

    public static function getConvers($idUtilisateurCourant, $idUtilisateur1, $idUtilisateur2) {


//        $requete = " SELECT * FROM notification n, utilisateur u, effectuer e " .
//                   " WHERE u.uti_id = '".$idUtilisateurCourant."' " .
//                   " AND u.uti_id = e.uti_id " .
//                   " AND e.uti_id = n.uti_id " .
//                   " AND n.not_titre = '". $titre ."' " . 
//                   " AND n.not_nom = '".$nom."' " .
//                   " AND n.uti_id2 = '".$idUtilisateur2."' " .
//                   " AND n.not_date = '".$date."'";

        $requete = " SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND (emetteur_id = " . $idUtilisateurCourant . " OR receveur_id = " . $idUtilisateurCourant . ") " .
                " AND (emetteur_id = " . $idUtilisateur1 . " OR receveur_id = " . $idUtilisateur1 . ") " .
                " ORDER BY not_id DESC ";

        return Site::getConnexion()->getIds($requete);
    }

    public function editMsgLu() {

        $requete = " UPDATE notification SET not_lu = '1'" .
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

    public function getEmetteur() {
        return $this->getPrivate('emetteur');
    }

    public function getReceveur() {
        return $this->getPrivate('receveur');
    }

    public function setLu($value) {
        $this->setPrivate('lu', $value);
    }

}

?>
