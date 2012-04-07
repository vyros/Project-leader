<?php 

include_once("classConnect.php");

 class DEMANDER
{
	private $m_idProjet;
	private $m_idCompetence;
	
	
	public function __construct(){	
            // distinction existant/ nouveau en fonction du nombre d'arguments
            $nombreArgument = func_num_args();
            if($nombreArgument == 1){
                // l'id
                $t_code = func_get_arg(0);

                // appel du constructeur existant avec l'id
                $this->existant($t_code);
            }
            elseif ($nombreArgument == 2){

            }
	}
	
	public function existant($p_code){
	
			$connexion = new Connexion();
			
            $requete = " SELECT * FROM demander " .
                       " WHERE idProjet = " . $p_code . " LIMIT 1;";

            // echo $requete."<br/>";

            // execution et renvoi de la resource
            $resultat = Connexion::executeSql($requete)
                    or die("erreur requete!<br/><br/>(" . $requete . ")");
            $ligne = Connexion::fetchArray($resultat);

            if ($ligne != null)
            {
                $this->m_idProjet = $p_code;
				$this->m_idCompetence = stripslashes($ligne['idCompetence']);
				
            }
    }
	
	
	public function inserDem($p_idProjet, $p_tabIdCompetence){
	
		$connexion = new Connexion();
		
		$i = 0;

		while($p_tabIdCompetence[$i] != "")
		{
		
			$query="INSERT INTO demander (idProjet , idCompetence) VALUES ('".$p_idProjet."','".$p_tabIdCompetence[$i]."')";
			mysql_query($query);
			$i++;
		}
	}
	
	public function getLesCompetences()
	{
		$connexion = new Connexion();
		
		$requete = " SELECT idCompetence FROM demander " .
                   " WHERE idProjet = " . $this->m_idProjet . ";";

		$result = Connexion::executeSql($requete);
		
		mysql_query("SET NAMES 'utf8'"); 

		return $result;
	}
// accesseurs
     public function getIdProjet(){return $this->m_idProjet; }
	 public function getIdCompetence(){return $this->m_idCompetence; }


}

?>