<?php 

include_once("classConnect.php");

 class PARTICIPER
{
	private $m_idProjet;
	private $m_idUtilisateur;
	
	
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
			
            $requete = " SELECT * FROM participer " .
                       " WHERE idUtilisateur = " . $p_code . " LIMIT 1;";

            //echo $requete."<br/>";

            // execution et renvoi de la resource
            $resultat = Connexion::executeSql($requete)
                    or die("erreur requete!<br/><br/>(" . $requete . ")");
            $ligne = Connexion::fetchArray($resultat);

            if ($ligne != null)
            {
                $this->m_idUtilisateur = $p_code;
				$this->m_idProjet = stripslashes($ligne['idProjet']);
				
            }
    }
	

	public function inserParticip($p_idProjet, $p_idUti){
	
		$connexion = new Connexion();

		$query="INSERT INTO participer (idProjet , idUtilisateur) VALUES ('".$p_idProjet."','".$p_idUti."')";
		mysql_query($query);
		// echo $query;
	}
	
	
// accesseurs
     public function getIdProjet(){return $this->m_idProjet; }
	 public function getIdUtilisateur(){return $this->m_idUtilisateur; }


}

?>