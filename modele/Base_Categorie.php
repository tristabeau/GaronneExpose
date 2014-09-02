<?php

/**
 * @name Base_Categorie
 * @version 05/03/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Categorie
{
    // Nom de la table
    const TABLENAME = 'categorie';
    
    // Nom des champs
    const FIELDNAME_IDCATEGORIE = 'idcategorie';
    const FIELDNAME_NOM = 'nom';
    const FIELDNAME_TAG = 'tag';
    const FIELDNAME_PERE_IDCATEGORIE = 'pere_idcategorie';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idCategorie;
    
    /** @var string  */
    protected $_nom;
    
    /** @var string  */
    protected $_tag;
    
    /** @var int id de pere */
    protected $_pere;
    
    /**
     * Construire un(e) categorie
     * @param $pdo PDO 
     * @param $idCategorie int 
     * @param $nom string 
     * @param $tag string 
     * @param $pere int Id de pere
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idCategorie,$nom,$tag,$pere=null,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idCategorie = $idCategorie;
        $this->_nom = $nom;
        $this->_tag = $tag;
        $this->_pere = $pere;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idCategorie] = $this;
        }
    }
    
    /**
     * Créer un(e) categorie
     * @param $pdo PDO 
     * @param $nom string 
     * @param $tag string 
     * @param $pere Categorie 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public static function create(PDO $pdo,$nom,$tag,$pere=null,$lazyload=true)
    {
        // Ajouter le/la categorie dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Categorie::TABLENAME.' ('.Categorie::FIELDNAME_NOM.','.Categorie::FIELDNAME_TAG.','.Categorie::FIELDNAME_PERE_IDCATEGORIE.') VALUES (?,?,?)');
        if (!$pdoStatement->execute(array($nom,$tag,$pere == null ? null : $pere->getIdCategorie()))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) categorie dans la base de données');
        }
        
        // Construire le/la categorie
        return new Categorie($pdo,intval($pdo->lastInsertId()),$nom,$tag,$pere == null ? null : $pere->getIdCategorie(),$lazyload);
    }
    
    /**
     * Compter les categories
     * @param $pdo PDO 
     * @return int Nombre de categories
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Categorie::FIELDNAME_IDCATEGORIE.') FROM '.Categorie::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des categories dans la base de données');
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
        return $pdo->prepare('SELECT DISTINCT '.Categorie::TABLENAME.'.'.Categorie::FIELDNAME_IDCATEGORIE.', '.Categorie::TABLENAME.'.'.Categorie::FIELDNAME_NOM.', '.Categorie::TABLENAME.'.'.Categorie::FIELDNAME_TAG.', '.Categorie::TABLENAME.'.'.Categorie::FIELDNAME_PERE_IDCATEGORIE.' '.
                             'FROM '.Categorie::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) categorie
     * @param $pdo PDO 
     * @param $idCategorie int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public static function load(PDO $pdo,$idCategorie,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idCategorie])) {
            return self::$_lazyload[$idCategorie];
        }
        
        // Charger le/la categorie
        $pdoStatement = self::_select($pdo,Categorie::FIELDNAME_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($idCategorie))) {
            throw new Exception('Erreur lors du chargement d\'un(e) categorie depuis la base de données');
        }
        
        // Récupérer le/la categorie depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Categorie::FIELDNAME_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($this->_idCategorie))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) categorie depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idCategorie,$nom,$tag,$pere) = $values;
        
        // Sauvegarder les valeurs
        $this->_nom = $nom;
        $this->_tag = $tag;
        $this->_pere = $pere;
    }
    
    /**
     * Charger tous/toutes les categories
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie[] Tableau de categories
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les categories
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les categories
        $categories = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $categories;
    }
    
    /**
     * Sélectionner tous/toutes les categories
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les categories depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la categorie suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idCategorie,$nom,$tag,$pere) = $values;
        
        // Construire le/la categorie
        return $lazyload && isset(self::$_lazyload[intval($idCategorie)]) ? self::$_lazyload[intval($idCategorie)] :
               new Categorie($pdo,intval($idCategorie),$nom,$tag,$pere,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les categories d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie[] Tableau de categories
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $categories = array();
        while ($categorie = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $categories[] = $categorie;
        }
        return $categories;
    }
    
    /**
     * Test d'égalité
     * @param $categorie Categorie 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($categorie)
    {
        // Test si null
        if ($categorie == null) { return false; }
        
        // Tester la classe
        if (!($categorie instanceof Categorie)) { return false; }
        
        // Tester les ids
        return $this->_idCategorie == $categorie->_idCategorie;
    }
    
    /**
     * Vérifier que le/la categorie existe en base de données
     * @return bool Le/La categorie existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Categorie::FIELDNAME_IDCATEGORIE.') FROM '.Categorie::TABLENAME.' WHERE '.Categorie::FIELDNAME_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdCategorie()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) categorie existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la categorie
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer les fils associé(e)s
        $select = $this->selectFils();
        if (count($select)) {
            while ($fils = Categorie::fetch($this->_pdo,$select)) {
                $fils->setPere(null);
            }
        }

        // Supprimer les articles associé(e)s
        $select = $this->selectArticles();
        while ($article = Article::fetch($this->_pdo,$select)) {
            $article->delete();
        }
        
        // Supprimer le/la categorie
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Categorie::TABLENAME.' WHERE '.Categorie::FIELDNAME_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdCategorie()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) categorie dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idCategorie])) {
            unset(self::$_lazyload[$this->_idCategorie]);
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Categorie::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Categorie::FIELDNAME_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdCategorie())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) categorie dans la base de données');
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
        return $this->_set(array(Categorie::FIELDNAME_NOM,Categorie::FIELDNAME_TAG,Categorie::FIELDNAME_PERE_IDCATEGORIE),array($this->_nom,$this->_tag,$this->_pere));
    }
    
    /**
     * Récupérer le/la idCategorie
     * @return int 
     */
    public function getIdCategorie()
    {
        return $this->_idCategorie;
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
        return $execute ? Categorie::_set(array(Categorie::FIELDNAME_NOM),array($nom)) : true;
    }
    
    /**
     * Récupérer le/la tag
     * @return string 
     */
    public function getTag()
    {
        return $this->_tag;
    }
    
    /**
     * Définir le/la tag
     * @param $tag string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setTag($tag,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_tag = $tag;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Categorie::_set(array(Categorie::FIELDNAME_TAG),array($tag)) : true;
    }
    
    /**
     * Récupérer le/la pere
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public function getPere($lazyload=true)
    {
        // Retourner null si nécessaire
        if ($this->_pere === null) { return null; }
        
        // Charger et retourner categorie
        return Categorie::load($this->_pdo,$this->_pere,$lazyload);
    }
    
    /**
     * Récupérer le/les id(s) du/de la pere
     * @return int Id de pere
     */
    public function getPereId()
    {
        return $this->_pere;
    }
    
    /**
     * Définir le/la pere
     * @param $pere Categorie 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setPere($pere=null,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_pere = $pere == null ? null : $pere->getIdCategorie();
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Categorie::_set(array(Categorie::FIELDNAME_PERE_IDCATEGORIE),array($pere == null ? null : $pere->getIdCategorie())) : true;
    }
    
    /**
     * Définir le/la pere d'après son/ses id(s)
     * @param $idCategorie int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setPereById($idCategorie,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_pere = $idCategorie === null ? null : $idCategorie;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Categorie::_set(array(Categorie::FIELDNAME_PERE_IDCATEGORIE),array($idCategorie)) : true;
    }
    
    /**
     * Sélectionner les categories par pere
     * @param $pdo PDO 
     * @param $pere Categorie 
     * @return PDOStatement 
     */
    public static function selectByPere(PDO $pdo,Categorie $pere)
    {
        $pdoStatement = self::_select($pdo,Categorie::FIELDNAME_PERE_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($pere->getIdCategorie()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les categories d\'un(e) pere depuis la base de données');
        }
        return self::fetchAll($pdo, $pdoStatement);
    }
    
    /**
     * Sélectionner les fils
     * @return PDOStatement 
     */
    public function selectFils()
    {
        return Categorie::selectByPere($this->_pdo,$this);
    }
    
    /**
     * Sélectionner les articles
     * @return PDOStatement 
     */
    public function selectArticles()
    {
        return Article::selectByCategorie($this->_pdo,$this);
    }
    
    /**
     * ToString
     * @return string Représentation de categorie sous la forme d'un string
     */
    public function __toString()
    {
        return '[Categorie idCategorie="'.$this->_idCategorie.'" nom="'.$this->_nom.'" tag="'.$this->_tag.'" pere="'.$this->_pere.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la categorie
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la categorie
        $array = array('idcategorie' => $this->_idCategorie,'nom' => $this->_nom,'tag' => $this->_tag,'pere' => $this->_pere);
        
        // Retourner la sérialisation (ou pas) du/de la categorie
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la categorie
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la categorie
        return $lazyload && isset(self::$_lazyload[$array['idcategorie']]) ? self::$_lazyload[$array['idcategorie']] :
               new Categorie($pdo,$array['idcategorie'],$array['nom'],$array['tag'],$array['pere'],$lazyload);
    }
    
}

