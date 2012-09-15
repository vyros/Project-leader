<?php

class Participer extends Classe {

    private $m_prj_id;
    private $m_uti_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM participer " .
                " WHERE uti_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_uti_id = $p_id;
            $this->m_prj_id = stripslashes($array[prj_id]);
        }
    }

    /**
     * Ajoute une participation.
     * 
     * @param int $p_uti_id Id de l'utilisateur.
     * @param int $p_prj_id Id du projet.
     * @return boolean Retourne vrai si succès, sinon retourne non.
     */
    public static function addParticipation($p_uti_id, $p_prj_id) {

        $requete = "INSERT INTO participer (prj_id, uti_id, par_date) " .
                "VALUES ('" . $p_prj_id . "','" . $p_uti_id . "','" . date("c") . "')";

        return Site::getConnexion()->doSql($requete);
    }
    
    public static function voirParticipationPresta($p_prj_id) {
        $requete = " SELECT u.uti_id FROM utilisateur u, participer p " .
                   " WHERE u.uti_statut = 'prestataire' ".
                   " AND u.uti_id = p.uti_id " .
                   " AND p.prj_id = " . $p_prj_id .";";
//         echo $requete;        
        
        return Site::getConnexion()->getFetchArray($requete);
        
    }
    
    public static function voirParticipationCli($p_prj_id) {
        $requete = "SELECT u.uti_id FROM utilisateur u, participer p " .
                   " WHERE u.uti_statut = 'client' ".
                   " AND u.uti_id = p.uti_id " .
                   " AND p.prj_id = " . $p_prj_id ." LIMIT 1;";
//        echo $requete;   
        return Site::getConnexion()->getFetchRessource($requete);
        
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdUtilisateur() {
        return $this->m_uti_id;
    }

}

?>
