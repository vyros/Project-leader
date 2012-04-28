<?php

class CATEGORIE extends CLASSE {

    private $m_id;
    private $m_libelle;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM categorie " .
                " WHERE cat_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getOneLevelArray(SITE::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[cat_libelle]);
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

        return SITE::getConnexion()->getFetchArray($requete);
    }

    public static function getIdFromLibelle($p_libelle) {

        $requete = "SELECT cat_id FROM categorie " .
                "WHERE cat_libelle = '" . $p_libelle . "'";

        $array = SITE::getConnexion()->getFetchArray($requete);
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

}

?>