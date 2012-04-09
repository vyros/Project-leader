<?php
class SITE {
    
    static public function init() {
        
    }

    static public function getUrl() {
        return "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']) . "/";
    }
    
    static public function chkSession() {
        
        if(isset($_SESSION['monUtilisateur']) 
                && $_SESSION['monUtilisateur'] instanceof UTILISATEUR) {
            return true;
        }
        
        return false;
    }
}
?>