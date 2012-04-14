<?php

class PROJET {

    private $m_id;
    private $m_libelle;
    private $m_description;
    private $m_budget;
    private $m_echeance;
    private $m_date;

    public function __construct() {

        if (func_num_args() == 1) {
            $t_argv = func_get_arg(0);
            if (is_array($t_argv)) {
                $this->exists($t_argv[0][0]);
            }
        } else {
            
        }
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM projet " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = SITE::getConnexion()->getFetchArray($requete);
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[0][prj_libelle]);
            $this->m_description = stripslashes($array[0][prj_description]);
            $this->m_budget = stripslashes($array[0][prj_budget]);
            $this->m_echeance = stripslashes($array[0][prj_echeance]);
            $this->m_date = stripslashes($array[0][prj_date]);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public static function getLstNIds($p_n = 0) {

        $requete = "SELECT prj_id FROM projet ORDER BY prj_date DESC ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return SITE::getConnexion()->getFetchArray($requete);
    }

    /**
     * Ajoute un projet.
     * 
     * @return boolean Retourne vrai si succès, sinon retourne non.
     */
    public function addProjet($p_libelle, $p_description, $p_budget, $p_echeance) {

        $requete = "INSERT INTO projet (prj_libelle, prj_description, prj_budget, prj_echeance, prj_date) " .
                "VALUES ('" . $p_libelle . "','" . $p_description . "','" . $p_budget . "','" . $p_echeance . "','" . date("c") . "')";

        return SITE::getConnexion()->doSql($requete);
    }

    /**
     * Retourne la categorie associée au projet.
     * 
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCategorieIds() {

        $requete = "SELECT cat_id FROM correspondre " .
                " WHERE prj_id = '" . $this->m_id . "';";

        return SITE::getConnexion()->getFetchArray($requete);
    }

    /**
     * Retourne la competence associée au projet.
     * 
     * @return array Retourne un tableau contenant l'id de l'enregistrement,
     *  retourne null si aucun.
     */
    public function getCompetenceIds() {

        $requete = "SELECT cpt_id FROM demander " .
                " WHERE prj_id = '" . $this->m_id . "';";

        return SITE::getConnexion()->getFetchArray($requete);
    }

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