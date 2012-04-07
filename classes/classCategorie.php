<?php
include_once("classConnect.php");

class CATEGORIE {

    private $m_id;
    private $m_libelle;

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
        $requete = " SELECT * FROM categorie " .
                " WHERE categorie_id = " . $p_code . " LIMIT 1;";

        // echo $requete."<br/>";
        // execution et renvoi de la resource
        $resultat = Connexion::executeSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_id = $p_code;
            $this->m_libelle = stripslashes($ligne['categorie_libelle']);
        }
    }

    public static function toutes() {

        $connexion = new Connexion();
        $requete = "SELECT * FROM categorie";
        $result = Connexion::executeSql($requete);
        mysql_query("SET NAMES 'utf8'");

        return $result;
    }

    public static function getIdViaLib($p_libelle) {

        $connexion = new Connexion();
        $requete = "SELECT categorie_id FROM categorie " .
                "WHERE categorie_libelle = '" . $p_libelle . "'";
        
        $result = Connexion::executeSql($requete);

        if ($result == false) {
            die(mysql_error());
        }

        if (mysql_num_rows($result) == 1) {
            $object = mysql_fetch_object($result);
            $codeCateg = $object->categorie_id;
        }

        return $codeCateg;
    }

    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

}

?>