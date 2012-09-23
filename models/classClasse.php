<?php

/**
 * Description of Classe
 *
 * @author jimmy
 */
abstract class Classe {

    /**
     *
     * @var String
     */
    protected $prefix;

    /**
     *
     * @var String
     */
    protected $table;

    /**
     *
     * @var array 
     */
    protected $private;

    public function __construct() {
        $t_argv = Site::getOneLevelArray(func_get_arg(0));
        $this->exists($t_argv[0]);
    }

    public function exists($p_id) {

        if (!is_numeric($p_id))
            return null;

        $requete = " SELECT * FROM " . $this->getTable() .
                " WHERE " . $this->getPrefix() . "_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete, MYSQL_ASSOC));
        if ($array != null) {
            foreach ($array as $key => $value) {
                $cle = split("_", $key);
                if ($cle[0] != $this->getPrefix()) {
                    $this->private[$cle[0]] = Connexion::getOriginalString($value);
                } else {
                    $this->private[$cle[1]] = Connexion::getOriginalString($value);
                }
            }
        } else {
            unset($this);
        }
    }

    protected function getPrefix() {
        return $this->prefix;
    }

    protected function getTable() {
        return $this->table;
    }

    // Accesseurs
    protected function getPrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->private))
            return null;

        return $this->private[$key];
    }

    protected function getSafePrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->private))
            return null;

        return Connexion::getSafeString($this->private[$key]);
    }

    protected function setPrivate($key = null, $value = null) {
        if (!is_string($key) || $key == "")
            return false;

        if (!array_key_exists($key, $this->private) || is_null($value))
            return false;

        $this->private[$key] = $value;

        return true;
    }

}

?>
