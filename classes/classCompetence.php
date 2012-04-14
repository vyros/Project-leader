<?php

class COMPETENCE {

    private $m_id;
    private $m_libelle;

    public function __construct() {

        if (func_num_args() == 1) {
            $t_argv = func_get_arg(0);
            if (is_array($t_argv)) {
                $this->exists($t_argv[0][0]);
            }
        } else {
            
        }
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM competence " .
                " WHERE cpt_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[0][cpt_libelle]);
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

        return SITE::getConnexion()->getFetchArray($requete);
    }
    
    
    public static function getNRessource($p_n = 0) {

        $requete = "SELECT * FROM competence ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return SITE::getConnexion()->getFetchRessource($requete);
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


        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            return $array[cpt_id];
        }

        return null;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

}

?>