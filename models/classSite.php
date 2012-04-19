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
     *  UTILISATEUR, CONNEXION et CLASSE.
     */
    static public function init($p_min = false) {

        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        if ($p_min) {
            include_once('models/classConnexion.php');
            include_once('models/classClasse.php');
            include_once('models/classUtilisateur.php');
        } else {
            if ($handle = opendir('models/')) {
                while (false !== ($file = readdir($handle))) {
                    $input[] = $file;
                }
                closedir($handle);

                $clsInput = preg_grep('/^(class)+/', $input);
                foreach ($clsInput as $value) {
                    if ($value != "classSite.php")
                        include_once("models/$value");
                }
            }
        }

        session_start();
        // la connexion existe
        
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
            if (!$_SESSION[connexion]->isConnected()) {
                $_SESSION[connexion]->doConnection();
            }
        } else {
            $_SESSION[connexion] = new CONNEXION();
        }

        return $_SESSION[connexion];
    }

    /**
     * Vérifie qu'il existe un utilisateur instancié dans la variable de session,
     *  et le retourne le cas échéant.
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

    /**
     *
     * @param array $p_array Un tableau à plusieurs niveuax.
     * @return array Un tableau à un niveau. 
     */
    static public function getOneLevelArray($p_array) {
        while (is_array($p_array[0])) {
            $t_array = $p_array[0];
            unset($p_array);
            $p_array = $t_array;
            unset($t_array);
        }
        
        return $p_array;
    }

}

?>