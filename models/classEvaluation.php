<?php
/**
 * Description of Evaluation
 *
 * @author jimmy
 */
class Evaluation extends Classe {

//    const PREFIX = 'eva';
//    const TABLE = 'evaluation';
    
    public function __construct($p_id) {

        $this->prefix = 'eva';
        $this->table = 'evaluation';

        parent::__construct($p_id);
    }

    /**
     * Ajoute une evaluation.
     * 
     * @return Evaluation Retourne le nouvel objet en cas de succès, sinon retourne null.
     *  Permet instanceof Object.
     */
    public static function add($p_projet, $p_evaluateur, $p_utilisateur, $p_formulaire, $p_score) {

        if (is_null($idProjet = Site::isValidId($p_projet)))
            return null;

        if (is_null($idEvaluateur = Site::isValidId($p_evaluateur)))
            return null;

        if (is_null($idUtilisateur = Site::isValidId($p_utilisateur)))
            return null;

        $requete = "INSERT INTO evaluation (eva_date, utilisateur_id, evaluateur_id, projet_id) " .
                "VALUES ('" . date('c') . "'," . $idUtilisateur . "," . $idEvaluateur . "," . $idProjet . ");";

        if ($idEvaluation = Site::getConnexion()->doSql($requete, "evaluation")) {
            $objEvaluation = new Evaluation($idEvaluation);

            if ($objEvaluation->addFormulaire($p_formulaire, $p_score))
                return $objEvaluation;
                
        }

        return null;
    }

    /**
     * Ajoute un evaluation.
     * 
     * @param int $p_formulaire
     * @param int $p_score
     * @return boolean Retourne true en cas de succès, sinon retourne false.
     */
    public function addFormulaire($p_formulaire, $p_score) {

        if (is_null($idFormulaire = Site::isValidId($p_formulaire)))
            return false;

        if (is_null($score = Site::isValidId($p_score)))
            return false;

        $requete = "INSERT INTO completer (eva_id, for_id, com_score, com_date) " .
                "VALUES (" . $this->getPrivate("id") . "," . $idFormulaire . "," . $score . ",'" . date('c') . "');";

        if (Site::getConnexion()->doSql($requete)) {
            return true;
        }
        
        return false;
    }

    /**
     * Test si l'evaluateur n'a pas déjà evalué l'utilisateur via le formulaire 
     *  et concernant le projet.
     * 
     * @param int $p_utilisateur
     * @param int $p_evaluateur
     * @param int $p_formulaire
     * @param int $p_projet
     * @return boolean Retourne true en cas de succès, sinon retourne false.
     */
    public static function check($p_utilisateur, $p_evaluateur, $p_formulaire, $p_projet) {

        if (is_null($idUtilisateur = Site::isValidId($p_utilisateur)))
            return false;

        if (is_null($idEvaluateur = Site::isValidId($p_evaluateur)))
            return false;

        if (is_null($idFormulaire = Site::isValidId($p_formulaire)))
            return false;

        if (is_null($idProjet = Site::isValidId($p_projet)))
            return false;

        $requete = " SELECT COUNT(1) FROM evaluation e, completer c WHERE e.utilisateur_id = " . $idUtilisateur .
                " AND e.evaluateur_id = " . $idEvaluateur . " AND e.projet_id = " . $idProjet .
                " AND e.eva_id = c.eva_id AND c.for_id = " . $idFormulaire . ";";

        $array = Site::getConnexion()->getFetchIntArray($requete);
        if (empty($array))
            return true;

        return false;
    }

}

?>
