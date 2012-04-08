<?php
class Connexion {
    
    CONST SERVEUR = 'localhost';
    CONST UTILISATEUR = 'project-leader';
    CONST PASSWORD = 'L9psTTUGyZUArLE6';
    CONST SEL_PASSWORD = '';
    CONST BASE = 'project-leader';

    public function __construct() {
        $this->doConnection();
    }

    public static function doConnection() {

        $resultat = mysql_connect(self::SERVEUR, self::UTILISATEUR, self::PASSWORD) or die("Erreur connexion serveur : " . mysql_error());
        mysql_select_db(self::BASE) or die("Erreur selection base : " . mysql_error());

        return $resultat;
    }

    public static function doSql($requete) {
        $resultat = mysql_query($requete);
        if (!mysql_error()) {
            return $resultat;
        }
        
        return null;
    }

    public static function fetchArray($resultat) {
        if ($resultat != NULL) {
            //return mysql_fetch_array($resultat, MYSQL_ASSOC);
            $res = mysql_fetch_array($resultat);
            return $res;
        }
        
        return null;
    }
}
?>