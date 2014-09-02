<?php

/**
 * @name Base_Groupe
 * @version 05/03/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Groupe
{
    // Nom de la table
    const TABLENAME = 'groupe';
    
    // Nom des champs
    const FIELDNAME_IDGROUPE = 'idgroupe';
    const FIELDNAME_NOM = 'nom';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idGroupe;
    
    /** @var string  */
    protected $_nom;
    
    /**
     * Construire un(e) groupe
     * @param $pdo PDO 
     * @param $idGroupe int 
     * @param $nom string 
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idGroupe,$nom,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idGroupe = $idGroupe;
        $this->_nom = $nom;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idGroupe] = $this;
        }
    }
    
    /**
     * Créer un(e) groupe
     * @param $pdo PDO 
     * @param $nom string 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe 
     */
    public static function create(PDO $pdo,$nom,$lazyload=true)
    {
        // Ajouter le/la groupe dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Groupe::TABLENAME.' ('.Groupe::FIELDNAME_NOM.') VALUES (?)');
        if (!$pdoStatement->execute(array($nom))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) groupe dans la base de données');
        }
        
        // Construire le/la groupe
        return new Groupe($pdo,intval($pdo->lastInsertId()),$nom,$lazyload);
    }
    
    /**
     * Compter les groupes
     * @param $pdo PDO 
     * @return int Nombre de groupes
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Groupe::FIELDNAME_IDGROUPE.') FROM '.Groupe::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des groupes dans la base de données');
        }
        return $pdoStatement->fetchColumn();
    }
    
    /**
     * Requête de sélection
     * @param $pdo PDO 
     * @param $where string|array 
     * @param $orderby string|array 
     * @param $limit string|array 
     * @param $from string|array 
     * @return PDOStatement 
     */
    protected static function _select(PDO $pdo,$where=null,$orderby=null,$limit=null,$from=null)
    {
        return $pdo->prepare('SELECT DISTINCT '.Groupe::TABLENAME.'.'.Groupe::FIELDNAME_IDGROUPE.', '.Groupe::TABLENAME.'.'.Groupe::FIELDNAME_NOM.' '.
                             'FROM '.Groupe::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) groupe
     * @param $pdo PDO 
     * @param $idGroupe int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe 
     */
    public static function load(PDO $pdo,$idGroupe,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idGroupe])) {
            return self::$_lazyload[$idGroupe];
        }
        
        // Charger le/la groupe
        $pdoStatement = self::_select($pdo,Groupe::FIELDNAME_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array($idGroupe))) {
            throw new Exception('Erreur lors du chargement d\'un(e) groupe depuis la base de données');
        }
        
        // Récupérer le/la groupe depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Groupe::FIELDNAME_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array($this->_idGroupe))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) groupe depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idGroupe,$nom) = $values;
        
        // Sauvegarder les valeurs
        $this->_nom = $nom;
    }
    
    /**
     * Charger tous/toutes les groupes
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe[] Tableau de groupes
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les groupes
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les groupes
        $groupes = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $groupes;
    }
    
    /**
     * Sélectionner tous/toutes les groupes
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les groupes depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la groupe suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idGroupe,$nom) = $values;
        
        // Construire le/la groupe
        return $lazyload && isset(self::$_lazyload[intval($idGroupe)]) ? self::$_lazyload[intval($idGroupe)] :
               new Groupe($pdo,intval($idGroupe),$nom,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les groupes d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe[] Tableau de groupes
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $groupes = array();
        while ($groupe = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $groupes[] = $groupe;
        }
        return $groupes;
    }
    
    /**
     * Test d'égalité
     * @param $groupe Groupe 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($groupe)
    {
        // Test si null
        if ($groupe == null) { return false; }
        
        // Tester la classe
        if (!($groupe instanceof Groupe)) { return false; }
        
        // Tester les ids
        return $this->_idGroupe == $groupe->_idGroupe;
    }
    
    /**
     * Vérifier que le/la groupe existe en base de données
     * @return bool Le/La groupe existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Groupe::FIELDNAME_IDGROUPE.') FROM '.Groupe::TABLENAME.' WHERE '.Groupe::FIELDNAME_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdGroupe()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) groupe existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la groupe
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer les membres associé(e)s
        $select = $this->selectMembres();
        if (count($select)) {
            while ($membre = Membre::fetch($this->_pdo,$select)) {
                $membre->delete();
            }
        }

        // Supprimer le/la groupe
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Groupe::TABLENAME.' WHERE '.Groupe::FIELDNAME_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdGroupe()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) groupe dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idGroupe])) {
            unset(self::$_lazyload[$this->_idGroupe]);
        }
        
        // Opération réussie ?
        return $pdoStatement->rowCount() == 1;
    }
    
    /**
     * Mettre à jour un champ dans la base de données
     * @param $fields array 
     * @param $values array 
     * @return bool Opération réussie ?
     */
    protected function _set($fields,$values)
    {
        // Préparer la mise à jour
        $updates = array();
        foreach ($fields as $field) {
            $updates[] = $field.' = ?';
        }
        
        // Mettre à jour le champ
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Groupe::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Groupe::FIELDNAME_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdGroupe())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) groupe dans la base de données');
        }
        
        // Opération réussie ?
        return $pdoStatement->rowCount() == 1;
    }
    
    /**
     * Mettre à jour tous les champs dans la base de données
     * @return bool Opération réussie ?
     */
    public function update()
    {
        return $this->_set(array(Groupe::FIELDNAME_NOM),array($this->_nom));
    }
    
    /**
     * Récupérer le/la idGroupe
     * @return int 
     */
    public function getIdGroupe()
    {
        return $this->_idGroupe;
    }
    
    /**
     * Récupérer le/la nom
     * @return string 
     */
    public function getNom()
    {
        return $this->_nom;
    }
    
    /**
     * Définir le/la nom
     * @param $nom string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setNom($nom,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_nom = $nom;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Groupe::_set(array(Groupe::FIELDNAME_NOM),array($nom)) : true;
    }
    
    /**
     * Sélectionner les membres
     * @return PDOStatement 
     */
    public function selectMembres()
    {
        return Membre::selectByGroupe($this->_pdo,$this);
    }
    
    /**
     * ToString
     * @return string Représentation de groupe sous la forme d'un string
     */
    public function __toString()
    {
        return '[Groupe idGroupe="'.$this->_idGroupe.'" nom="'.$this->_nom.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la groupe
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la groupe
        $array = array('idgroupe' => $this->_idGroupe,'nom' => $this->_nom);
        
        // Retourner la sérialisation (ou pas) du/de la groupe
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la groupe
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la groupe
        return $lazyload && isset(self::$_lazyload[$array['idgroupe']]) ? self::$_lazyload[$array['idgroupe']] :
               new Groupe($pdo,$array['idgroupe'],$array['nom'],$lazyload);
    }
    
}

