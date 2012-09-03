<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Posseder
 *
 * @author jimmy
 */
class Posseder {

    public static function addCompetences($p_uti_id, $p_cpt_array) {

        if (is_null($p_cpt_array) || count($p_cpt_array) == 0)
            return null;

        foreach ($p_cpt_array as $cpt_id) {
            $requete = "INSERT INTO posseder (cpt_id, uti_id) " .
                    "VALUES (" . $cpt_id . ", " . $p_uti_id . ");";

            Site::getConnexion()->doSql($requete);
        }
    }

    public static function getCompetencesIdsFromUserId($p_id) {

        $requete = " SELECT cpt_id FROM posseder " .
                " WHERE uti_id = " . $p_id . ";";

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }

    public static function getUserIdsFromCompetenceId($p_id) {

        $requete = " SELECT uti_id FROM posseder " .
                " WHERE cpt_id = " . $p_id . ";";

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }

    public static function removeCompetences($p_uti_id, $p_cpt_array) {

        if (is_null($p_cpt_array) || count($p_cpt_array) == 0)
            return null;

        foreach ($p_cpt_array as $cpt_id) {
            $requete = " DELETE FROM posseder WHERE cpt_id = " . $cpt_id .
                    " AND uti_id = " . $p_uti_id . ";";

            Site::getConnexion()->doSql($requete);
        }
    }
    
}
?>
