<?php
/**
 * Description of Prestataire
 *
 * @author jimmy
 */
class Prestataire extends Statut {

    public function __construct() {

        parent::__construct(func_get_args());
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private static function getNIds($p_n = 0) {

        $requete = " SELECT uti_id FROM utilisateur " .
                " WHERE uti_statut = '" . strtolower(get_class()) . "'";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public static function getNObjs($p_n = 0) {

        $lstArray = self::getNIds($p_n);
        $objArray = null;

        if (is_null($lstArray) || !count($lstArray))
            return null;

        foreach ($lstArray as $value) {
            $objArray[] = new Utilisateur($value);
        }

        return $objArray;
    }

}

?>
