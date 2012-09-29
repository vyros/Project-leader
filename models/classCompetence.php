<?php

/**
 * Description of Competence
 *
 * @author jimmy
 */
class Competence extends Classe {

//    const PREFIX = 'cpt';
//    const TABLE = 'competence';

    public function __construct($p_id) {

        $this->prefix = 'cpt';
        $this->table = 'competence';

        parent::__construct($p_id);
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private static function getNIds($p_n = 0) {

        $requete = "SELECT cpt_id FROM competence ";
        
        return Site::getConnexion()->getIds($requete, $p_n);
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public static function getNObjs($p_n = 0) {

        $lstIds = self::getNIds($p_n);
        $lstObjs = null;

        if (is_null($lstIds) || !count($lstIds))
            return null;

        foreach ($lstIds as $idObj) {
            $lstObjs[] = new Competence($idObj);
        }

        return $lstObjs;
    }

    /**
     * Retourne l'id correspondant au libelle.
     * 
     * @param  string Le libelle a rechercher.
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public static function getIdFromLibelle($p_libelle) {

        $libelle = Connexion::getSafeString($p_libelle);
        
        $requete = "SELECT cpt_id FROM competence " .
                "WHERE cpt_libelle = '" . $libelle . "'";

        return Site::getConnexion()->getIds($requete);
    }

    public function getId() {
        return $this->getPrivate('id');
    }

    public function getLibelle() {
        return $this->getPrivate('libelle');
    }

    public static function getCompetenceMereIds() {

        $requete = "SELECT DISTINCT A.cpt_id_mere " .
                " FROM appartenir AS A, comptence AS C " .
                " WHERE A.cpt_id_mere = C.cpt_id ;";

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public static function getCompetenceFilleIds($p_cpt_id) {

        if(is_null($idCompetence = Site::isValidId($p_cpt_id)))
            return null;
        
        $requete = " SELECT C.cpt_id FROM competence AS C , appartenir AS A " .
                " WHERE C.cpt_id = A.cpt_id_fils " .
                " AND cpt_id_mere = " . $idCompetence . ";";

        return Site::getConnexion()->getFetchIntArray($requete);
    }

}

?>