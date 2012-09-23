<?php
/**
 * Description of Etat
 *
 * @author nicolas.gard
 */
class Etat extends Classe {
    
//    const PREFIX = 'eta';
//    const TABLE = 'etat';
    
    public function __construct($p_id) {
        
        $this->prefix = 'eta';
        $this->table = 'etat';
        
        parent::__construct($p_id);
    }

    public function __toString() {
        return $this->getLibelle();
    }

    public function getId() {
        return $this->getSafePrivate('id');
    }

    public function getLibelle() {
        return $this->getPrivate('libelle');
    }

    /**
     *
     * @return String 
     */
    public function getDate() {
        return Site::dateMysql2Picker($this->getPrivate("date"));
    }
}
?>
