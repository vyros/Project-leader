<?php 

include_once("classConnect.php");

 class CORRESPONDRE
{
	private $m_idProjet;
	private $m_idCategorie;
	
	
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
			
            $requete = " SELECT * FROM correspondre " .
                       " WHERE idProjet = " . $p_code . " LIMIT 1;";

            //echo $requete."<br/>";

            // execution et renvoi de la resource
            $resultat = Connexion::executeSql($requete)
                    or die("erreur requete!<br/><br/>(" . $requete . ")");
            $ligne = Connexion::fetchArray($resultat);

            if ($ligne != null)
            {
                $this->m_idProjet = $p_code;
				$this->m_idCategorie = stripslashes($ligne['idCategorie']);
				
            }
    }
	

	public function inserCorres($p_idProjet, $p_idCateg){
	
		$connexion = new Connexion();

		$query="INSERT INTO correspondre (idProjet ,idCategorie) VALUES ('".$p_idProjet."','".$p_idCateg."')";
		mysql_query($query);

	}
// accesseurs
     public function getIdProjet(){return $this->m_idProjet; }
	 public function getIdCategorie(){return $this->m_idCategorie; }


}

?>