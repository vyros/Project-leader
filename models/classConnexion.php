<?php

/**
 * Description of Connexion
 *
 * @author jimmy
 */
class Connexion {

    CONST SERVEUR = 'localhost';
    CONST UTILISATEUR = 'project-leader';
    CONST PASSWORD = 'L9psTTUGyZUArLE6';
    CONST SEL_PASSWORD = '';
    CONST BASE = 'project-leader';

    private $m_connection = false;

    public function __construct() {
        $this->m_connection = $this->doConnection();
    }

    public function __destruct() {
        mysql_close($this->m_connection);
    }

    public function __wakeup() {
        $this->m_connection = $this->doConnection();
    }

    public function doConnection() {

        $resultat = mysql_connect(self::SERVEUR, self::UTILISATEUR, self::PASSWORD)
                or die("Erreur connexion serveur : " . mysql_error());

        mysql_select_db(self::BASE) or die("Erreur de selection de base : " . mysql_error());
        mysql_query("SET NAMES 'utf8'");

        return $resultat;
    }

    /**
     * Fonction de verification de la connexion.
     * 
     * @return boolean Retourne vari si une connexion existe, sinon retourne faux.
     */
    public function isConnected() {

        if (!$this->m_connection) {
            return false;
        }
        return true;
    }

    /**
     * Fonction executant une requête SQL
     * 
     * @param  string $requete
     * @param  type   $table La table a verouiller.
     * @return array Retourne vrai en cas de succès de la requête, sinon retourne 
     *  faux. 
     *  Si une table est precisée alors la fonction retourne le last_insert_id
     *  en cas de succès, sinon retourne faux.
     */
    public function doSql($requete, $table = null) {

        if (is_null($table))
            return mysql_query($requete);

        else {
            mysql_query("LOCK TABLES $table WRITE;");

            $lastInsertId = false;

            /* @var $resultat boolean */
            if ($resultat = mysql_query($requete)) {
                $lastInsertId = mysql_insert_id();
            }
            mysql_query("UNLOCK TABLES;");

            return $lastInsertId;
        }
    }

    public function getIds($p_requete, $p_n = 0) {

        if ($p_n != 0) {
            $p_requete .= " LIMIT $p_n;";
        } else {
            $p_requete .= ";";
        }
        
        $res = Site::getConnexion()->getFetchIntArray($p_requete);
        return $res;
    }

    /**
     *
     * @param array $p_array Un tableau à plusieurs niveaux.
     * @return array Un tableau à un niveau. 
     */
    static public function getOneLevelArray($p_array) {
        $t_array = null;
        while (is_array($p_array[0])) {
            if (is_null($t_array))
                $t_array = array();

            // Tableau d'IDs
            if (array_key_exists(0, $p_array[0])) {
                array_push($t_array, $p_array[0][0]);
            } else {
                // Tableau associatif d'information
                $t_array = array_merge($p_array[0]);
            }

            if (isset($p_array[1])) {
                for ($i = 0; $i < count($p_array); $i++) {
                    $p_array[$i] = $p_array[$i + 1];
                }
                unset($p_array[--$i]);
            } else {
                unset($p_array);
            }
        }
        return $t_array;
    }

    /**
     * Retourne un tableau contenant le resultat d'une requête.
     * 
     * @param string $requete
     * @param type $type Type de retour depuis la base. Type MYSQL_ASSOC par défaut.
     * @return array Retourne null si aucun resultat.
     */
    public function getFetchArray($requete, $type = MYSQL_BOTH) {

        $resultat = mysql_query($requete);

        for ($array = null, $i = 0, $obj = mysql_fetch_array($resultat, $type); $obj != false; $obj = mysql_fetch_array($resultat, $type), $i++)
            $array[$i] = $obj;

        mysql_free_result($resultat);

        $res = $this->getOneLevelArray($array);
        return $res;
    }

    /**
     * Retourne un tableau contenant le resultat d'une requête, clés chaînées uniqement.
     * 
     * @param string $requete
     * @param type $type Type de retour depuis la base. Type MYSQL_ASSOC par défaut.
     * @return array Retourne null si aucun resultat.
     */
    public function getFetchAssArray($requete) {
        return $this->getFetchArray($requete, MYSQL_ASSOC);
    }

    /**
     * Retourne un tableau contenant le resultat d'une requête, clés numériques uniqement.
     * 
     * @param string $requete
     * @param type $type Type de retour depuis la base. Type MYSQL_ASSOC par défaut.
     * @return array Retourne null si aucun resultat.
     */
    public function getFetchIntArray($requete) {
        return $this->getFetchArray($requete, MYSQL_NUM);
    }

    public static function getSafeString($p_value) {
        return mysql_real_escape_string($p_value);
    }

    public static function getOriginalString($p_value) {
        return stripslashes($p_value);
    }

}

?>