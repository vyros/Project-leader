<?php


class Connexion
{

		CONST SERVEUR = 'localhost';
        CONST UTILISATEUR = '';
        CONST PASSWORD = '';
        CONST SEL_PASSWORD = '';
        CONST BASE = 'bdd_pl';

//	private  $m_serveur;
//	private  $m_utilisateur;
//	private  $m_password;
//	private  $m_base;
//        private  $m_connexion;

        public function __construct(){
            $this->connecter();
	}

	public static function Connecter(){
		
            $result = mysql_connect(self::SERVEUR,self::UTILISATEUR, self::PASSWORD) or die ("Pb connexion serveur ".mysql_error());
            mysql_select_db(self::BASE) or die ("Pb selection base ".mysql_error());

            return $result;
	}

        public  static  function executeSql($requete){
            $resultat = mysql_query($requete);
            if (!mysql_error())
            {
                return $resultat;
            }
            return null;
        }

         public  static function fetchArray($resultat){
            if ($resultat != NULL){
                //return mysql_fetch_array($resultat, MYSQL_ASSOC);
                $res = mysql_fetch_array($resultat);
                return $res;
            }
            return null;
        }
}
?>