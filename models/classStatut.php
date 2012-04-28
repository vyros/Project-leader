<?php

/**
 * Description of STATUT
 *
 * @author jimmy
 */
abstract class STATUT {

    protected $m_libelle;

    public function __construct() {
        
        if (func_num_args() == 1) {
            $t_argv = func_get_arg(0);
            if (is_array($t_argv)) {
                $this->m_libelle = $t_argv[0][sta_libelle];
            } else {
                $this->m_libelle = $t_argv;
            }
        } else {
            
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    private static function getLstNIds($p_n) {}

    public function __toString() {
        $res = strtolower(get_class($this));
        return $res;
    }

}

?>
