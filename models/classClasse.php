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

    /**
     * 
     * @param int $p_id
     */
    public function __construct($p_id) {

        // Id depuis un int, tableau numérique ou tableau associatif.
        if (is_array($p_id)) {
            while (!array_key_exists(0, $p_id)) {
                $p_id = array_values($p_id);
            }
            $idTmp = $p_id[0];
        } else {
            $idTmp = $p_id;
        }

        // Test de l'id.
        if (is_null($id = Site::isValidId($idTmp))) {
            return;
        }

        // Requête de construction.
        $requete = " SELECT * FROM " . $this->getTable() .
                " WHERE " . $this->getPrefix() . "_id = " . $id . " LIMIT 1;";

        // Construction de la variable private.
        if (!is_null($array = Site::getConnexion()->getFetchAssArray($requete))) {
            foreach ($array as $key => $value) {
                $cle = split("_", $key);
                if ($cle[0] != $this->getPrefix()) {
                    $this->private[$cle[0]] = Connexion::getOriginalString($value);
                } else {
                    $this->private[$cle[1]] = Connexion::getOriginalString($value);
                }
            }
        }
    }

    protected function getPrefix() {
//        return self::PREFIX;
        return $this->prefix;
    }

    protected function getTable() {
//        return self::TABLE;
        return $this->table;
    }

    // Accesseurs
    public function checkPrivate() {
        if (is_null($this->private))
            return false;
        
        return true;
    }
    
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
