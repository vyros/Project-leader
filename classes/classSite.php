<?php

/**
 *  Cette classe travail essentiellement sur la variable de session.
 * 
 * @author jimmy
 */
class SITE {

    /**
     * Initialisation du site, des classes et de la variable de session.
     * 
     * @param boolean $p_min Pour utilisation minimum, charge uniquement les classes
     *  UTILISATEUR et CONNEXION.
     */
    static public function init($p_min = false) {

        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        if ($p_min) {
            include_once('classes/classConnexion.php');
            include_once('classes/classUtilisateur.php');
            
        } else {
            if ($handle = opendir('classes/')) {
                while (false !== ($file = readdir($handle))) {
                    $input[] = $file;
                }
                closedir($handle);

                $clsInput = preg_grep('/^(class)+/', $input);
                foreach ($clsInput as $value) {
                    if ($value != "classSite.php")
                        include_once("classes/$value");
                }
            }
        }

        session_start();
        self::getConnexion();
    }

    /**
     * Déconnexion.
     * 
     */
    static public function kill() {

        SITE::init(true);
        if (SITE::getUtilisateur()) {
            session_destroy();
            echo ("<script language = \"JavaScript\">alert('Vous êtes déconnecté');");
            echo ("location.href = 'index.php';");
            echo ("</script>");
        }
    }

    /**
     * Retourne l'URL courant.
     * 
     * @return string 
     */
    static public function getUrl() {
        return "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']) . "/";
    }
    
    /**
     * Test la connexion instanciée dans la variable de session. En créée une nouvelle
     *  si aucune n'existe ou si fermée.
     * 
     * @return CONNEXION La connexion a utiliser.
     */
    static public function getConnexion() {
        if (isset($_SESSION[connexion]) && $_SESSION[connexion] instanceof CONNEXION) {
            if ($_SESSION[connexion]->isConnected()) {
                return $_SESSION[connexion];
            }
            unset($_SESSION[connexion]);
        }
        
        $_SESSION[connexion] = new CONNEXION();
        return $_SESSION[connexion];
    }

    /**
     * Vérifie qu'il existe un utilisateur instancié dans la variable de session.
     * 
     * @return boolean Retourne vrai si un utilisateur est instancié dans 
     *  la variable de session, sinon retourne faux.
     */
    static public function chkUtilisateur() {

        if ($_SESSION[utilisateur] instanceof UTILISATEUR) {
            return true;
        }

        return false;
    }

    /**
     * Retourne l'utilisateur instancié dans la variable de session.
     * 
     * @return UTILISATEUR Retourne faux si aucun utilisateur instancié.
     */
    static public function getUtilisateur() {
        if (isset($_SESSION[utilisateur]) && $_SESSION[utilisateur] instanceof UTILISATEUR) {
            return $_SESSION[utilisateur];
        }

        return false;
    }
    
    /**
     * Enregistre l'utilisateur en paramètre dans la variable de session.
     * 
     * @param UTILISATEUR $p_objUtilisateur L'instance a enregistrer dans la variable
     *  de session.
     * @return boolean Retourne vrai si l'utilisateur en paramètre est une instance
     *  d'UTILISATEUR, sinon retourne faux.
     */
    static public function setUtilisateur($p_objUtilisateur) {
        if ($p_objUtilisateur instanceof UTILISATEUR) {
            $_SESSION[utilisateur] = $p_objUtilisateur;
            return true;
        }
        return false;
    }
}
?>