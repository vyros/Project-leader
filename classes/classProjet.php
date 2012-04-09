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
            $this->exists($t_id);
            
        } elseif ($argc == 2) {
            
        }
    }

    public function exists($p_id) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM projet " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($ligne['prj_libelle']);
            $this->m_description = stripslashes($ligne['prj_description']);
            $this->m_budget = stripslashes($ligne['prj_budget']);
            $this->m_echeance = stripslashes($ligne['prj_echeance']);
            $this->m_date = stripslashes($ligne['prj_date']);
        }
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

    public static function getNLastProjet($p_n = 0) {

        $connexion = new Connexion();
        $requete = "SELECT * FROM projet ORDER BY prj_date DESC ";
        
        if($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }
        
        $resultat = Connexion::doSql($requete);
        
        mysql_query("SET NAMES 'utf8'");

        return $resultat;
    }

    public function addProjet($p_libelle, $p_description, $p_budget, $p_echeance) {

        $connexion = new Connexion();
        $date = date("c");
        
        $requete = "INSERT INTO projet (prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES ('" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_echeance . "','" . $date . "')";
        
        mysql_query($requete);
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
}
?>