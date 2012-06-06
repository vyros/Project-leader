<?php

/**
 *  Cette classe travail essentiellement sur la variable de session.
 * 
 * @author jimmy
 */
class Site {

    /**
     *
     * @var Site 
     */
    private static $instance = false;
    
    /**
     *
     * @var Connexion 
     */
    private static $connexion = false;

    public function __construct() {
        // Ici la connexion existe
        self::getConnexion();
    }

    /**
     * Initialisation du site, des classes et de la variable de session.
     * 
     * @param boolean $p_min Pour utilisation minimum, charge uniquement les classes
     *  Utilisateur, Connexion et Classe.
     */
    static public function init() {

        include_once 'models/classClasse.php';
        include_once 'models/classStatut.php';
        include_once 'models/classCategorie.php';
        include_once 'models/classClient.php';
        include_once 'models/classCompetence.php';
        include_once 'models/classConnexion.php';
        include_once 'models/classCorrespondre.php';
        include_once 'models/classDemander.php';
        include_once 'models/classParticiper.php';
        include_once 'models/classPrestataire.php';
        include_once 'models/classProjet.php';
        include_once 'models/classUtilisateur.php';
        include_once 'models/classEtat.php';
        
        echo '<script type="text/javascript">';
        echo '      getHeader();';
        echo '</script>';
        
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        session_start();
        return self::getInstance();
    }

    /**
     * Déconnexion.
     * 
     */
    static public function kill() {

        Site::init();
        if (Site::getUtilisateur()) {
            session_destroy();
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
     * @return Connexion La connexion a utiliser.
     */
    static public function getConnexion() {
        if (isset(self::$connexion) && self::$connexion instanceof Connexion) {
            if (!self::$connexion->isConnected()) {
                self::$connexion->doConnection();
            }
        } else {
            self::$connexion = new Connexion();
        }

        return self::$connexion;
    }

    /**
     * Inclut le controleur demandé par la variable $_POST 
     */
    static public function getController($check = false) {
        if (isset($_POST[controller]) && !$check) {
            include "$_POST[controller].php";
        } elseif (isset($_POST[controller])) {
            return true;
        }

        return false;
    }

    static public function setController($p_controller) {
        $_POST[controller] = "$p_controller";
    }

    static public function getInformation($p_libelle = null) {
        if (!is_null($p_libelle)) {
            if (isset($_SESSION[$p_libelle]))
                return $_SESSION[$p_libelle];
        }

        return null;
    }

    static public function setInformation($p_libelle, $p_information) {
        $_SESSION[$p_libelle] = $p_information;
    }

    
    // bug
    public static function getInstance() {
        if (!isset($_SESSION[site]) || !self::$instance instanceof Site) {
            $_SESSION[site] = new Site();
        }

        return self::$instance;
    }

    static public function getMessage() {
        if (isset($_POST[succes]) || isset($_POST[erreur])) {
            ;
        }
    }

    /**
     * Inclut le controleur demandé par la variable $_POST 
     */
    static public function getView() {
        if (isset($_POST[view])) {
            include 'views/message.php';
            include "views/$_POST[view]";
        }
    }

    static public function setView($p_view) {
        $_POST[view] = "$p_view.php";
    }

    /**
     * Vérifie qu'il existe un utilisateur instancié dans la variable de session,
     *  et le retourne le cas échéant.
     * 
     * @return Utilisateur Retourne faux si aucun utilisateur instancié.
     */
    static public function getUtilisateur() {
        if (isset($_SESSION[utilisateur]) && $_SESSION[utilisateur] instanceof Utilisateur) {
            return $_SESSION[utilisateur];
        }

        return false;
    }

    /**
     * Enregistre l'utilisateur en paramètre dans la variable de session.
     * 
     * @param Utilisateur $p_objUtilisateur L'instance a enregistrer dans la variable
     *  de session.
     * @return boolean Retourne vrai si l'utilisateur en paramètre est une instance
     *  d'Utilisateur, sinon retourne faux.
     */
    static public function setUtilisateur($p_objUtilisateur) {
        if ($p_objUtilisateur instanceof Utilisateur) {
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