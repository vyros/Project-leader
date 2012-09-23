<?php

/**
 * Description of Client
 *
 * @author jimmy
 */
class Client extends Statut {

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
                " WHERE uti_statut = '" . strtolower(get_class()) . "' ";
        
        return Site::getConnexion()->getIds($requete, $p_n);
    }

}

?>
