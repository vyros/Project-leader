<?php

/**
 * Description of CLASSE
 *
 * @author jimmy
 */
abstract class CLASSE {

    public function __construct() {
        $t_argv = SITE::getOneLevelArray(func_get_arg(0));
        $this->exists($t_argv[0]);
    }

    public abstract function exists($p_id);
}

?>
