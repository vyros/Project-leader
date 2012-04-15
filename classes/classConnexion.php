<?php

class CONNEXION {

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

    private function doConnection() {

        $resultat = mysql_connect(self::SERVEUR, self::UTILISATEUR, self::PASSWORD)
                or die("Erreur connexion serveur : " . mysql_error());

        mysql_select_db(self::BASE) or die("Erreur selection base : " . mysql_error());
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

    /**
     * Retourne un tableau contenant le resultat d'une requête.
     * 
     * @param string $requete
     * @param type $type Type de retour depuis la base. Type MYSQL_ASSOC par défaut.
     * @return array Retourne null si aucun resultat.
     */
    public function getFetchArray($requete, $type = MYSQL_BOTH) {
        $array = null;
        $resultat = mysql_query($requete);
        
        $i = 0;
        while ($obj = mysql_fetch_array($resultat, $type)) {
            $array[$i] = $obj;
            $i++;
        }
        mysql_free_result($resultat);

        return $array;
    }
    
    /**
     * Retourne la ressource associée au resultat d'une requête.
     * 
     * @param string $requete
     * @return ressource Retourne la ressource, si aucun resultat retourne faux.
     */
    public function getFetchRessource($requete) {
        $resultat = mysql_query($requete);
        return $resultat;
    }

}

?>