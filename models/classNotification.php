<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classNotification
 *
 * @author nicolas.gard
 */
class Notification extends Classe {
     
    private $m_id;
    private $m_titre;
    private $m_nom;
    private $m_libelle;
    private $m_nature;
    private $m_date;
    private $m_lu;
    private $m_uti_id;
    private $m_uti_id2;
    private $m_projet_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM notification " .
                " WHERE not_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_titre = stripslashes($array[not_titre]);
            $this->m_nom = stripslashes($array[not_nom]);
            $this->m_libelle = stripslashes($array[not_libelle]);
            $this->m_nature = stripslashes($array[not_nature]);
            $this->m_date = stripslashes($array[not_date]);
            $this->m_lu = stripslashes($array[not_lu]);
            $this->m_uti_id = stripslashes($array[uti_id]);
            $this->m_uti_id2 = stripslashes($array[uti_id2]);
            $this->m_projet_id = stripslashes($array[projet_id]);
        }
    }
    
    
    public static function getComProjet($idProjet) {
    
        $requete = "SELECT * FROM notification " .
                   " WHERE not_nature = 'commentaire'" .
                   " AND projet_id = " . $idProjet . ";";
        //echo $requete;
        
        return Site::getConnexion()->getFetchArray($requete);
        
    }
    
    public static function addCom($titre, $nom, $libelle, $idUti, $idUti2, $idPjt) {
        
        $today = date("Y/m/d"); 
        
        $requete = "INSERT INTO notification (not_titre, not_nom, not_libelle, not_nature, not_date, not_lu, uti_id, uti_id2, projet_id) " .
                "VALUES ('". $titre ."','" . $nom . "','" . $libelle . "','commentaire','" . $today . "','0','" . $idUti . "','". $idUti2 ."','" . $idPjt . "')";
        echo $requete;
//        return Site::getConnexion()->doSql($requete);
        
    }
    public static function msgNonLu($idUtilisateur) {
        
        $requete = "SELECT * FROM notification " .
                   " WHERE not_nature = 'message' " .
                   " AND not_lu = '0' " .
                   " AND uti_id2 = " . $idUtilisateur . ";";
//        echo $requete;
        
        return Site::getConnexion()->getFetchArray($requete);
        
    }    
    
    public static function msgLu($idUtilisateur) {
        
        $requete = "SELECT * FROM notification " .
                   " WHERE not_nature = 'message' " .
                   " AND not_lu = '1' " .
                   " AND uti_id2 = " . $idUtilisateur . ";";
        echo $requete;
        
        return Site::getConnexion()->getFetchArray($requete);
        
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
    
    public static function getMaxNot(){
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
        
        $requete = " SELECT * FROM notification " . 
                   " WHERE not_nature = 'message' " .
                   " AND (uti_id = '".$idUtilisateurCourant."' OR uti_id2 = '".$idUtilisateurCourant."') " .
                   " AND (uti_id = '".$idUtilisateur1."' OR uti_id2 = '".$idUtilisateur1."') " .
                   " ORDER BY not_id";
        
        echo $requete;
        
        return Site::getConnexion()->getFetchArray($requete);
        
    }  
    public function editMsgLu($idMsg) {

        $requete = " UPDATE notification SET not_lu = '1'" .
                   " WHERE not_id = " . $idMsg . ";";
        echo $requete;
        if (Site::getConnexion()->doSql($requete)) {
            return $this;
        }
        return null;
    }
    
    public function getId() {
        return $this->m_id;
    }
    
    public function getNom(){
        return $this->m_nom;
    }
    public function getTitre(){
        return $this->m_titre;
    }
    public function getLibelle(){
        return $this->m_libelle;
    }
    public function getDate(){
        return $this->m_date;
    }
    
    public function getUti(){
        return $this->m_uti_id;
    }
    
    public function getUti2(){
        return $this->m_uti_id2;
    }
   
    public function setLu($p_value){
        $this->m_lu = $p_value;
    }
}

?>
