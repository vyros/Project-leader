<?php

/**
 * Description of Classe
 *
 * @author jimmy
 */
abstract class Classe {

    public function __construct() {
        $t_argv = Site::getOneLevelArray(func_get_arg(0));
        $this->exists($t_argv[0]);
    }

    public abstract function exists($p_id);
}

?>
