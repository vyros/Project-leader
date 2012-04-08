<?php
include_once("classConnect.php");

class PROJET {

    private $m_id;
    private $m_libelle;
    private $m_description;
    private $m_budget;
    private $m_delai;
    private $m_dateCreation;

    public function __construct() {
        // distinction existant/ nouveau en fonction du nombre d'arguments
        $nombreArgument = func_num_args();
        if ($nombreArgument == 1) {
            // l'id
            $t_code = func_get_arg(0);

            // appel du constructeur existant avec l'id
            $this->existant($t_code);
            
        } elseif ($nombreArgument == 2) {
            
        }
    }

    public function existant($p_code) {

        $connexion = new Connexion();
        $requete = " SELECT * FROM PROJET " .
                " WHERE projet_id = " . $p_code . " LIMIT 1;";

        // execution et renvoi de la resource
        $resultat = Connexion::executeSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_code = $p_code;
            $this->m_libelle = stripslashes($ligne['projet_libelle']);
            $this->m_description = stripslashes($ligne['projet_description']);
            $this->m_budget = stripslashes($ligne['projet_budget']);
            $this->m_delai = stripslashes($ligne['projet_delai']);
            $this->m_dateCreation = stripslashes($ligne['projet_dateCreation']);
        }
    }

    public static function maxPjt() {

        $connexion = new Connexion();
        $requete = "SELECT projet_id FROM PROJET ORDER BY projet_id DESC LIMIT 1 ";
        $result = Connexion::executeSql($requete);

        if ($result == false) {
            die(mysql_error());
        }

        if (mysql_num_rows($result) == 1) {
            $object = mysql_fetch_object($result);
            $codeProjet = $object->projet_id;
        } else {
            $codeProjet = "1";
        }

        return $codeProjet;
    }

    public static function dernierProjet() {

        $connexion = new Connexion();
        $requete = "SELECT * FROM PROJET";
        $result = Connexion::executeSql($requete);
        mysql_query("SET NAMES 'utf8'");

        return $result;
    }

    public function inserProjet($p_libelle, $p_description, $p_budget, $p_delai) {

        $connexion = new Connexion();
        $dateCreation = date("Y-m-d");
        $query = "INSERT INTO PROJET (projet_libelle ,projet_description, projet_budget, projet_delai, projet_dateCreation) " .
                "VALUES ('" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_delai . "','" . $dateCreation . "')";
        
        mysql_query($query);
    }

// accesseurs
    public function getCode() {
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

    public function getDelai() {
        return $this->m_delai;
    }

    public function getDateCreation() {
        return $this->m_dateCreation;
    }
}
?>