<?php

/**
 * Description of Document
 *
 * @author nicolas.gard
 */
class Document extends Classe {

//    const PREFIX = 'doc';
//    const TABLE = 'document';

    public function __construct($p_id) {

        $this->prefix = 'doc';
        $this->table = 'document';

        parent::__construct($p_id);
    }

    /**
     * Ajoute un document.
     * 
     * @return Document Retourne le nouvel objet en cas de succès, sinon retourne null.
     *  Permet instanceof Object.
     */
    public static function add($p_nature, $p_libelle, $p_uti_id, $p_prj_id) {

        $nature = Connexion::getSafeString($p_nature);
        $libelle = Connexion::getSafeString($p_libelle);

        if (is_null($idUtilisateur = Site::isValidId($p_uti_id)))
            $erreur = 'Utilisateur incorrect !';

        // $idProjet null n'est pas une erreur cf BDD
        $idProjet = Site::isValidId($p_prj_id);

        // Vérifications liées au document
        $dossier = 'upload/';
        $document = basename($_FILES['document']['name']);
        $taille_maxi = 100000;
        $taille = filesize($_FILES['document']['tmp_name']);
        $extensions = array('.doc', '.docx', '.rtf', '.pdf', '.txt');
        $extension = strrchr($_FILES['document']['name'], '.');

        if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
            $erreur = 'Vous devez charger un document de type doc, docx, jpg, rtf, txt ou pdf.';
        }

        if ($taille > $taille_maxi) {
            $erreur = 'Le document est trop gros...';
        }

        if (!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
            //On formate le nom du document ici...
            $document = strtr($document, 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã’Ã“Ã”Ã•Ã–Ã™ÃšÃ›ÃœÃ�Ã Ã¡Ã¢Ã£Ã¤Ã¥Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã²Ã³Ã´ÃµÃ¶Ã¹ÃºÃ»Ã¼Ã½Ã¿', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $document = preg_replace('/([^.a-z0-9]+)/i', '-', $document);
            $lien = $dossier . $document;

            if (move_uploaded_file($_FILES['document']['tmp_name'], $lien)) {
                
                $requete = "INSERT INTO document (doc_nature, doc_libelle, doc_lien, doc_date, utilisateur_id, projet_id) " .
                        "VALUES ('" . $nature . "', '" . $libelle . "','" . $lien . "','" . date('c') . "'," . $idUtilisateur . "," . $idProjet . ")";

                if ($idDocument = Site::getConnexion()->doSql($requete, "document")) {

                    $message[succes] = "Enregistrement effectué avec succès !";
                    return new Document($idDocument);
                } else {
                    $message[erreur] = "Echec de l'enregistrement en base, document supprimé !";
                    exec('rm -f '.$lien);
                }
                
            } else {
                $message[erreur] = "Echec du chargement !";
            }
        } else {
            $message[erreur] = $erreur;
        }

        return null;
    }

    public static function getDocumentIds($p_uti_id, $p_prj_id) {

        if (is_null($idUtilisateur = Site::isValidId($p_uti_id)))
            return null;

        if (is_null($idProjet = Site::isValidId($p_prj_id)))
            return null;

        $requete = " SELECT doc_id FROM document " .
                " WHERE utilisateur_id = '" . $idUtilisateur . "' " .
                " AND projet_id = " . $idProjet . ";";

        return Site::getConnexion()->getFetchIntArray($requete);
    }

    public function getId() {
        return $this->getPrivate('id');
    }

    public function getLibelle() {
        return $this->getPrivate('libelle');
    }

    public function getLien() {
        return $this->getPrivate('lien');
    }

    /**
     *
     * @return String 
     */
    public function getDate() {
        return Site::dateMysql2Picker($this->getPrivate("date"));
    }

    public function getUtilisateurId() {
        return $this->getPrivate('utilisateur');
    }

    public function getProjetId() {
        return $this->getPrivate('projet');
    }

}

?>
