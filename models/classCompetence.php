<?php

class Competence extends Classe {

    /**
     *
     * @var int 
     */
    private $m_id;

    /**
     *
     * @var string 
     */
    private $m_libelle;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM competence " .
                " WHERE cpt_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[cpt_libelle]);
        } else {
            unset($this);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public static function getLstNIds($p_n = 0) {

        $requete = "SELECT cpt_id FROM competence ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    /**
     * Retourne l'id correspondant au libelle.
     * 
     * @param  string Le libelle a rechercher.
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public static function getIdFromLibelle($p_libelle) {

        $requete = "SELECT cpt_id FROM competence " .
                "WHERE cpt_libelle = '" . $p_libelle . "'";


        $array = Site::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            return $array[cpt_id];
        }

        return null;
    }

    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

}

?>