<?php

/**
 * Description of Statut
 *
 * @author jimmy
 */
abstract class Statut {

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

    public function __toString() {
        $res = strtolower(get_class($this));
        return $res;
    }

}

?>
