<?php
include_once("classConnexion.php");

class CATEGORIE {

    private $m_id;
    private $m_libelle;

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
        $requete = " SELECT * FROM CATEGORIE " .
                " WHERE cat_id = " . $p_id . " LIMIT 1;";

        // echo $requete."<br/>";
        // execution et renvoi de la resource
        $resultat = Connexion::doSql($requete)
                or die("erreur requete!<br/><br/>(" . $requete . ")");
        
        $ligne = Connexion::fetchArray($resultat);

        if ($ligne != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($ligne['cat_libelle']);
        }
    }

    public static function getAll() {

        $connexion = new Connexion();
        $requete = "SELECT * FROM categorie";
        $resultat = Connexion::doSql($requete);
        
        mysql_query("SET NAMES 'utf8'");

        return $resultat;
    }

    public static function getIdFromLibelle($p_libelle) {

        $connexion = new Connexion();
        $requete = "SELECT cat_id FROM categorie " .
                "WHERE cat_libelle = '" . $p_libelle . "'";
        
        $resultat = Connexion::doSql($requete);

        if ($resultat == false) {
            die(mysql_error());
        }

        if (mysql_num_rows($resultat) == 1) {
            $object = mysql_fetch_object($resultat);
            $idCategorie = $object->cat_id;
        }

        return $idCategorie;
    }

    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }
}
?>