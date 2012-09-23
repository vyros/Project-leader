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

        $today = date("Y/m/d");

//        $requete = "INSERT INTO notification (not_sujet, not_nom, not_libelle, not_nature, not_date, not_lu, uti_id, uti_id2, projet_id) " .
        $requete = "INSERT INTO notification (not_sujet, not_corps, not_nature, not_date, not_lu, emetteur_id, receveur_id, projet_id) " .
                "VALUES ('" . $p_titre . "','" . $libelle . "','commentaire','" . date('c') . "','0','" . $idEmetteur . "','" . $idReceveur . "','" . $idProjet . "')";
        echo $requete;
//        return Site::getConnexion()->doSql($requete);
    }
    
    public static function getCommentaireProjetIds($p_idProjet) {

        
        
        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'commentaire'" .
                " AND projet_id = " . $idProjet . ";";
        //echo $requete;

        return Site::getConnexion()->getFetchIntArray($requete);
    }
    
    public static function msgNonLu($idUtilisateur) {

        $requete = "SELECT not_id FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND not_lu = '0' " .
                " AND receveur_id = " . $idUtilisateur . ";";
//        echo $requete;

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public static function msgLu($idUtilisateur) {

        $requete = "SELECT * FROM notification " .
                " WHERE not_nature = 'message' " .
                " AND not_lu = '1' " .
                " AND receveur_id = " . $idUtilisateur . ";";
//        echo $requete;

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public static function getNbreNonLu($idUtilisateur) {

        $res = Notification::msgNonLu($idUtilisateur);
        $i = 0;

        if (!is_null($res)) {
            foreach ($res as $idMsg) {
                $i++;
            }
        }

        return $i;
    }

    public static function getNbreLu($idUtilisateur) {

        $res = Notification::msgLu($idUtilisateur);
        $i = 0;

        if (!is_null($res)) {
            foreach ($res as $idMsg) {
                $i++;
            }
        }

        return $i;
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
                " AND (uti_id = '" . $idUtilisateurCourant . "' OR uti_id2 = '" . $idUtilisateurCourant . "') " .
                " AND (uti_id = '" . $idUtilisateur1 . "' OR uti_id2 = '" . $idUtilisateur1 . "') " .
                " ORDER BY not_id";

        echo $requete;

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public function editMsgLu($idMsg) {

        $requete = " UPDATE notification SET not_lu = '1'" .
                " WHERE not_id = " . $this->getPrivate('id') . ";";

        if (Site::getConnexion()->doSql($requete)) {
            return $this;
        }
        return null;
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
