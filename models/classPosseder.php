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

    public static function addCompetences($p_uti_id, $p_cat_array) {

        if (is_null($p_cat_array) || count($p_cat_array) == 0)
            return null;

        foreach ($p_cat_array as $cat_id) {
            $requete = "INSERT INTO posseder (cat_id, uti_id) " .
                    "VALUES (" . $cat_id . ", " . $p_uti_id . ");";

            Site::getConnexion()->doSql($requete);
        }
    }

    public static function getCompetencesIdsFromUserId($p_id) {

        $requete = " SELECT cat_id FROM posseder " .
                " WHERE uti_id = " . $p_id . ";";

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }

    public static function getUserIdsFromCompetenceId($p_id) {

        $requete = " SELECT uti_id FROM posseder " .
                " WHERE cat_id = " . $p_id . ";";

        return Site::getOneLevelIntArray(Site::getConnexion()->getFetchArray($requete));
    }

    public static function removeCompetences($p_uti_id, $p_cat_array) {

        if (is_null($p_cat_array) || count($p_cat_array) == 0)
            return null;

        foreach ($p_cat_array as $cat_id) {
            $requete = " DELETE FROM posseder WHERE cat_id = " . $cat_id .
                    " AND uti_id = " . $p_uti_id . ";";

            Site::getConnexion()->doSql($requete);
        }
    }
    
}
?>
