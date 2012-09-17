<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evaluation
 *
 * @author jimmy
 */
class Evaluation extends Classe {

    /**
     *
     * @var array 
     */
    private $m_private;

    /**
     *
     * @var String 
     */
    private static $suffix = "eva";

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM evaluation " .
                " WHERE eva_id = " . Connexion::getSafeString($p_id) . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete, MYSQL_ASSOC));
        if ($array != null) {
            foreach ($array as $key => $value) {
                $cle = split("_", $key);
                if ($cle[0] != self::$suffix) {
                    $this->m_private[$cle[0]] = Connexion::getOriginalString($value);
                } else {
                    $this->m_private[$cle[1]] = Connexion::getOriginalString($value);
                }
            }
        } else {
            unset($this);
        }
    }

    public static function add($p_projet, $p_evaluateur, $p_utilisateur, $p_formulaire, $p_score) {

        if (!$idProjet = Site::isValidId($p_projet))
            return null;

        if (!$idEvaluateur = Site::isValidId($p_evaluateur))
            return null;

        if (!$idUtilisateur = Site::isValidId($p_utilisateur))
            return null;

        $requete = "INSERT INTO evaluation (eva_date, utilisateur_id, evaluateur_id, projet_id) " .
                "VALUES ('" . date('c') . "'," . $idUtilisateur . "," . $idEvaluateur . "," . $idProjet . ");";

        $idEvaluation = Site::getConnexion()->doSql($requete, "evaluation");
        if ($idEvaluation) {
            $objEvaluation = new Evaluation($idEvaluation);

            if (!is_null($objEvaluation))
                return $objEvaluation->addFormulaire($p_formulaire, $p_score);
        }

        return null;
    }

    public function addFormulaire($p_formulaire, $p_score) {

        if (!$idEvaluation = Site::isValidId($this->getPrivate("id")))
            return null;

        if (!$idFormulaire = Site::isValidId($p_formulaire))
            return null;

        if (!is_numeric($p_score))
            return null;

        $score = $p_score;

        $requete = "INSERT INTO completer (eva_id, for_id, com_score, com_date) " .
                "VALUES (" . $idEvaluation . "," . $idFormulaire . "," . $score . ",'" . date('c') . "');";

        if (Site::getConnexion()->doSql($requete)) {
            return $this;
        }

        unset($this);
        return null;
    }

    // Accesseurs privés
    private function getPrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->m_private))
            return null;

        return $this->m_private[$key];
    }

    private function getSafePrivate($key = null) {
        if (!is_string($key) || $key == "")
            return null;

        if (!array_key_exists($key, $this->m_private))
            return null;

        return Connexion::getSafeString($this->m_private[$key]);
    }

    private function setPrivate($key = null, $value = null) {
        if (!is_string($key) || $key == "")
            return false;

        if (!array_key_exists($key, $this->m_private) || is_null($value))
            return false;

        $this->m_private[$key] = $value;

        return true;
    }

    public static function check($p_utilisateur, $p_evaluateur, $p_formulaire, $p_projet) {
        
        if ($idUtilisateur = Site::isValidId($p_utilisateur))
            ;

        if ($idEvaluateur = Site::isValidId($p_evaluateur))
            ;

        if ($idFormulaire = Site::isValidId($p_formulaire))
            ;

        if ($idProjet = Site::isValidId($p_projet))
            ;

        $requete = " SELECT COUNT(1) FROM evaluation e, completer c WHERE e.utilisateur_id = " . $idUtilisateur .
                " AND e.evaluateur_id = " . $idEvaluateur . " AND e.projet_id = " . $idProjet .
                " AND e.eva_id = c.eva_id AND c.for_id = " . $idFormulaire . ";";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if (empty($array))
            return true;
        
        return false;
    }

}

?>
