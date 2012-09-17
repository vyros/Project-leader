<?php

class Document extends Classe {

    private $m_id;
    private $m_libelle;
    private $m_chemin;
    private $m_uti_id;
    private $m_prj_id;

    public function __construct() {
        parent::__construct(func_get_args());
    }

    public function exists($p_id) {

        $requete = " SELECT * FROM document " .
                " WHERE doc_id = " . $p_id . " LIMIT 1;";

        $array = Site::getOneLevelArray(Site::getConnexion()->getFetchArray($requete));
        if ($array != null) {
            $this->m_id = $p_id;
            $this->m_libelle = stripslashes($array[doc_libelle]);
            $this->m_uti_id = stripslashes($array[uti_id]);
            $this->m_prj_id = stripslashes($array[prj_id]);
        } else {
            unset($this);
        }
    }

    /**
     * Obtenir N elements. tous les enregistrements sont retournÃ©s par dÃ©faut.
     * 
     * @param type $p_n Nombre d'enregistrements du tableau Ã  retourner.
     * @return array Retourne un tableau contenant l'id de N premiers enregistrements,
     *  retourne null si aucun.
     */
    public static function addDocument($p_libelle, $p_date, $p_uti_id, $p_prj_id) {


        $dossier = 'uploadDocPjt/';
        $fichier = basename($_FILES['avatar']['name']);
        $taille_maxi = 100000;
        $taille = filesize($_FILES['avatar']['tmp_name']);
        $extensions = array('.doc', '.docx', '.rtf', '.pdf', '.txt');
        $extension = strrchr($_FILES['avatar']['name'], '.');
        //Début des vérifications de sécurité...
        if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
            $erreur = 'Vous devez uploader un fichier de type doc, docx, jpg, rtf, txt ou pdf...';
        }
        if ($taille > $taille_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }
        if (!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
            //On formate le nom du fichier ici...
            $fichier = strtr($fichier, 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã’Ã“Ã”Ã•Ã–Ã™ÃšÃ›ÃœÃ�Ã Ã¡Ã¢Ã£Ã¤Ã¥Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã²Ã³Ã´ÃµÃ¶Ã¹ÃºÃ»Ã¼Ã½Ã¿', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que Ã§a a fonctionnÃ©...
                //echo 'Upload effectuÃ© avec succÃ¨s !';
                $message[succes] = "Upload effectué avec succès !";
            } else { //Sinon (la fonction renvoie FALSE).
                //echo 'Echec de l\'upload !';
                $message[erreur] = "Echec de l'upload !";
            }
        } else {
            //echo $erreur;
            $message[erreur] = $erreur;
        }

        $requete = "INSERT INTO document (doc_id, doc_libelle, doc_date, uti_id, prj_id) " .
                "VALUES ('" . $p_libelle . "','" . $p_date . "','" . $p_uti_id . "','" . $p_prj_id . "')";

        $idProjet = Site::getConnexion()->doSql($requete, "document");
        if ($idProjet) {
            return new Projet($idProjet);
        }
        return null;
    }

    public static function getDoc($p_uti_id, $p_prj_id) {

        $requete = " SELECT * FROM utilisateur, projet, document " .
                " WHERE uti_id = " . $p_uti_id .
                " AND prj_id = " . $p_prj_id . ";";

        return Site::getConnexion()->getFetchArray($requete);
    }

    public function getId() {
        return $this->m_id;
    }

    public function getLibelle() {
        return $this->m_libelle;
    }

    public function getChemin() {
        return $this->m_chemin;
    }

    public function getUtiId() {
        return $this->m_uti_id;
    }

    public function getPrjId() {
        return $this->m_prj_id;
    }

}

?>
