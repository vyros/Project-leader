<?php

class SITE {

    /**
     * Initialisation du site, des classes et de la variable de session.
     * 
     * @param boolean $p_uu Pour "utilisateur uniquement" :
     *  charge uniquement la classe UTILISATEUR.
     */
    static public function init($p_uu = false) {

        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

        if ($p_uu) {
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
    }

    /**
     * Déconnexion.
     * 
     */
    static public function kill() {

        SITE::init(true);
        if (SITE::chkUtilisateur()) {
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
     * @return UTILISATEUR 
     */
    static public function getUtilisateur() {
        return $_SESSION[utilisateur];
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