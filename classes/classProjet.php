<?php
include_once("classConnexion.php");

class PROJET {

    private $m_id;
    private $m_libelle;
    private $m_description;
    private $m_budget;
    private $m_echeance;
    private $m_date;

    public function __construct() {
        // distinction existant/ nouveau en fonction du nombre d'arguments
        $argc = func_num_args();
        if ($argc == 1) {
            // l'id
            $t_id = func_get_arg(0);

            // appel du constructeur existant avec l'id
            $connexion = new Connexion();
            $this->exists($t_id);
        } elseif ($argc == 2) {
            
        }
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM projet " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $resultat = mysql_query($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");

        $ligne = mysql_fetch_array($resultat);

        if ($ligne != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($ligne['prj_libelle']);
            $this->m_description = stripslashes($ligne['prj_description']);
            $this->m_budget = stripslashes($ligne['prj_budget']);
            $this->m_echeance = stripslashes($ligne['prj_echeance']);
            $this->m_date = stripslashes($ligne['prj_date']);
        }
        
        mysql_free_result($resultat);
    }

    public static function maxPjt() {

        $connexion = new Connexion();
        $requete = "SELECT prj_id FROM projet ORDER BY prj_id DESC LIMIT 1 ";
        $resultat = Connexion::doSql($requete);

        if ($resultat == false) {
            die(mysql_error());
        }

        if (mysql_num_rows($resultat) == 1) {
            $object = mysql_fetch_object($resultat);
            $idProjet = $object->prj_id;
        } else {
            $idProjet = "1";
        }

        return $idProjet;
    }

    /**
     * Obtenir les N derniers projets.
     * 
     * @param type $p_n Les N derniers projets.
     * @return array Retourne un tableau contenant l'id des N derniers projets. 
     */
    public static function getNLastProjetId($p_n = 0) {

        $connexion = new Connexion();
        $requete = "SELECT * FROM projet ORDER BY prj_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        $resultat = mysql_query($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");

        $array = NULL;
        while ($obj = mysql_fetch_object($resultat)) {
            $array[] = $obj->prj_id;
        }
        mysql_free_result($resultat);

        return $array;
    }

    public function addProjet($p_libelle, $p_description, $p_budget, $p_echeance) {

        $connexion = new Connexion();
        $date = date("c");
        
        $requete = "INSERT INTO projet (prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES ('" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_echeance . "','" . $date . "')";

        mysql_query("LOCK TABLES projet WRITE;");
        /* @var $res boolean */
        if($res = mysql_query($requete)) {
            $this->exists(mysql_insert_id());
        }
        mysql_query("UNLOCK TABLES;");
        
        return $res;
    }

    public function getAllCategorie() {
        $connexion = new Connexion();
        $requete = "SELECT cat_id FROM correspondre " .
                " WHERE prj_id = '" . $this->m_id . "';";

        $resultat = mysql_query($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");

        $array = NULL;
        while ($obj = mysql_fetch_object($resultat)) {
            $array[] = $obj->cat_id;
        }
        mysql_free_result($resultat);

        return $array;
    }

    public function getAllCompetence() {
        $connexion = new Connexion();
        $requete = "SELECT cpt_id FROM demander " .
                " WHERE prj_id = '" . $this->m_id . "';";

        $resultat = mysql_query($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");

        $array = NULL;
        while ($obj = mysql_fetch_object($resultat)) {
            $array[] = $obj->cpt_id;
        }
        mysql_free_result($resultat);

        return $array;
    }

// accesseurs
    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

    public function getDescription() {
        return $this->m_description;
    }

    public function getBudget() {
        return $this->m_budget;
    }

    public function getEcheance() {
        return $this->m_echeance;
    }

    public function getDateCreation() {
        return $this->m_date;
    }
    
    public function __toString() {
        return "id : $this->m_id ; libelle : $this->m_libelle";
    }
}
?>