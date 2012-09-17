<?php

class Categorie extends Classe {

    private $m_id;
    private $m_libelle;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM categorie " .
                " WHERE cat_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[cat_libelle]);
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

        $requete = "SELECT cat_id FROM categorie ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    public static function getIdFromLibelle($p_libelle) {

        $requete = "SELECT cat_id FROM categorie " .
                "WHERE cat_libelle = '" . $p_libelle . "'";

        $array = Site::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            return $array[cat_id];
        }

        return null;
    }

    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

    public static function getListCategoriesFilsByCode($p_codePere) {

        $requete = "SELECT C.cat_libelle, C.cat_id FROM categorie AS C , appartenir AS A " .
                "WHERE C.cat_id = A.cat_id_fils " .
                "AND cat_id_pere = '" . $p_codePere . "'";

        $array = Site::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            return $array;
        }
    }

}

?>