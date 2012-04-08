<?php
include_once("classConnexion.php");

class CORRESPONDRE {

    private $m_prj_id;
    private $m_cat_id;

    public function __construct() {
        // distinction existant/ nouveau en fonction du nombre d'arguments
        $argc = func_num_args();
        if ($argc == 1) {
            // l'id
            $t_id = func_get_arg(0);

            // appel du constructeur existant avec l'id
            $this->exists($t_id);
            
        } elseif ($argc == 2) {
            
        }
    }

    public function exists($p_id) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM correspondre " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_prj_id = $p_id;
            $this->m_cat_id = stripslashes($ligne['cat_id']);
        }
    }

    public function addCorrespondance($p_prj_id, $p_cat_id) {

        $connexion = new Connexion();

        $requete = "INSERT INTO correspondre (prj_id, cat_id) " .
                "VALUES ('" . $p_prj_id . "','" . $p_cat_id . "')";
        
        return mysql_query($requete);
    }

// accesseurs
    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCategorie() {
        return $this->m_cat_id;
    }
}
?>