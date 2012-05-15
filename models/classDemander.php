<?php

class Demander extends Classe {

    private $m_prj_id;
    private $m_cpt_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM demander " .
                " WHERE prj_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_prj_id = $p_id;
            $this->m_cpt_id = stripslashes($array[cpt_id]);
        }
    }

    public function addDemande($p_prj_id, $p_tab_cpt) {

        foreach ($p_tab_cpt as $t_cpt_id) {
            $requete = "INSERT INTO demander (prj_id, cpt_id) " .
                    "VALUES ('" . $p_prj_id . "', '" . $t_cpt_id . "')";

            Site::getConnexion()->doSql($requete);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournés par défaut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau à retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public function getLstNIds($p_n = 0) {

        $requete = " SELECT cpt_id FROM demander " .
                " WHERE prj_id = " . $this->m_prj_id . " ";

        if ($p_n != 0) {
            $requete .= " LIMIT $p_n;";
        } else {
            $requete .= ";";
        }

        return Site::getConnexion()->getFetchArray($requete);
    }

    public function getIdProjet() {
        return $this->m_prj_id;
    }

    public function getIdCompetence() {
        return $this->m_cpt_id;
    }

}

?>