<?php

/**
 * @name Base_Video
 * @version 20/02/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Video extends Post
{
    // Nom de la table
    const TABLENAME = 'video';
    
    // Nom des champs
    const FIELDNAME_PARENT_IDPOST = 'parent_idpost';
    const FIELDNAME_DESCRIPTION = 'description';
    const FIELDNAME_LIEN = 'lien';
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var string  */
    protected $_description;
    
    /** @var string  */
    protected $_lien;
    
    /**
     * Construire un(e) video
     * @param $pdo PDO 
     * @param $idPost int 
     * @param $titre string 
     * @param $date string 
     * @param $nb_vues int 
     * @param $membre int Id de membre
     * @param $categorie int Id de categorie
     * @param $description string 
     * @param $lien string 
     * @param $vedette bool 
     * @param $publie bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idPost,$titre,$date,$nb_vues,$membre,$categorie,$description,$lien,$vedette=false,$publie=false,$lazyload=true)
    {
        // Appeler le constructeur du parent
        parent::__construct($pdo,$idPost,$titre,$date,$nb_vues,$membre,$categorie,$vedette,$publie);
        
        // Sauvegarder les attributs
        $this->_description = $description;
        $this->_lien = $lien;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idPost] = $this;
        }
    }
    
    /**
     * Créer un(e) video
     * @param $pdo PDO 
     * @param $titre string 
     * @param $date string 
     * @param $nb_vues int 
     * @param $membre Membre 
     * @param $categorie Categorie 
     * @param $description string 
     * @param $lien string 
     * @param $vedette bool 
     * @param $publie bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video 
     */
    public static function create(PDO $pdo,$titre,$date,$nb_vues,Membre $membre,Categorie $categorie,$description,$lien,$vedette=false,$publie=false,$lazyload=true)
    {
        // Construire le parent
        $idPost = parent::_create($pdo,$titre,$date,$nb_vues,$membre,$categorie,$vedette,$publie);
        
        // Ajouter le/la video dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Video::TABLENAME.' ('.Video::FIELDNAME_PARENT_IDPOST.','.Video::FIELDNAME_DESCRIPTION.','.Video::FIELDNAME_LIEN.') VALUES (?,?,?)');
        if (!$pdoStatement->execute(array($idPost,$description,$lien))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) video dans la base de données');
        }
        
        // Construire le/la video
        return new Video($pdo,$idPost,$titre,$date,$nb_vues,$membre->getIdMembre(),$categorie->getIdCategorie(),$description,$lien,$vedette,$publie,$lazyload);
    }
    
    /**
     * Compter les videos
     * @param $pdo PDO 
     * @return int Nombre de videos
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Video::FIELDNAME_PARENT_IDPOST.') FROM '.Video::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des videos dans la base de données');
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
        return $pdo->prepare('SELECT DISTINCT '.Post::TABLENAME.'.'.Post::FIELDNAME_IDPOST.', '.Post::TABLENAME.'.'.Post::FIELDNAME_TITRE.', '.Post::TABLENAME.'.'.Post::FIELDNAME_DATE.', '.Post::TABLENAME.'.'.Post::FIELDNAME_NB_VUES.', '.Post::TABLENAME.'.'.Post::FIELDNAME_MEMBRE_IDMEMBRE.', '.Post::TABLENAME.'.'.Post::FIELDNAME_CATEGORIE_IDCATEGORIE.', '.Video::TABLENAME.'.'.Video::FIELDNAME_DESCRIPTION.', '.Video::TABLENAME.'.'.Video::FIELDNAME_LIEN.', '.Post::TABLENAME.'.'.Post::FIELDNAME_VEDETTE.', '.Post::TABLENAME.'.'.Post::FIELDNAME_PUBLIE.' '.
                             'FROM '.Post::TABLENAME.', '.Video::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ' WHERE '.Post::FIELDNAME_IDPOST.' = '.Video::FIELDNAME_PARENT_IDPOST.''.($where != null ? ' AND ('.$where.')' : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) video
     * @param $pdo PDO 
     * @param $idPost int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video 
     */
    public static function load(PDO $pdo,$idPost,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idPost])) {
            return self::$_lazyload[$idPost];
        }
        
        // Charger le/la video
        $pdoStatement = self::_select($pdo,Video::FIELDNAME_PARENT_IDPOST.' = ?');
        if (!$pdoStatement->execute(array($idPost))) {
            throw new Exception('Erreur lors du chargement d\'un(e) video depuis la base de données');
        }
        
        // Récupérer le/la video depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Video::FIELDNAME_PARENT_IDPOST.' = ?');
        if (!$pdoStatement->execute(array($this->_idPost))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) video depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idPost,$titre,$date,$nb_vues,$membre,$categorie,$description,$lien,$vedette,$publie) = $values;
        
        // Sauvegarder les valeurs
        $this->_titre = $titre;
        $this->_date = $date;
        $this->_nb_vues = $nb_vues;
        $this->_membre = $membre;
        $this->_categorie = $categorie;
        $this->_description = $description;
        $this->_lien = $lien;
        $this->_vedette = $vedette;
        $this->_publie = $publie;
    }
    
    /**
     * Charger tous/toutes les videos
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video[] Tableau de videos
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les videos
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les videos
        $videos = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $videos;
    }
    
    /**
     * Sélectionner tous/toutes les videos
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les videos depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la video suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idPost,$titre,$date,$nb_vues,$membre,$categorie,$description,$lien,$vedette,$publie) = $values;
        
        // Construire le/la video
        return $lazyload && isset(self::$_lazyload[intval($idPost)]) ? self::$_lazyload[intval($idPost)] :
               new Video($pdo,intval($idPost),$titre,$date,intval($nb_vues),$membre,$categorie,$description,$lien,$vedette ? true : false,$publie ? true : false,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les videos d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video[] Tableau de videos
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $videos = array();
        while ($video = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $videos[] = $video;
        }
        return $videos;
    }
    
    /**
     * Test d'égalité
     * @param $video Video 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($video)
    {
        // Test si null
        if ($video == null) { return false; }
        
        // Tester la classe
        if (!($video instanceof Video)) { return false; }
        
        // Test parent
        return parent::equals();
    }
    
    /**
     * Vérifier que le/la video existe en base de données
     * @return bool Le/La video existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Video::FIELDNAME_PARENT_IDPOST.') FROM '.Video::TABLENAME.' WHERE '.Video::FIELDNAME_PARENT_IDPOST.' = ?');
        if (!$pdoStatement->execute(array($this->getIdPost()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) video existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la video
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer le/la video
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Video::TABLENAME.' WHERE '.Video::FIELDNAME_PARENT_IDPOST.' = ?');
        if (!$pdoStatement->execute(array($this->getIdPost()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) video dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idPost])) {
            unset(self::$_lazyload[$this->_idPost]);
        }
        if ($pdoStatement->rowCount() != 1) { return false; }
        
        // Supprimer le/la parent
        return parent::delete();
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Video::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Video::FIELDNAME_PARENT_IDPOST.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdPost())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) video dans la base de données');
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
        // Mettre à jour le parent
        parent::update();
        
        // Mettre à jour tous les champs dans la base de données
        return $this->_set(array(Video::FIELDNAME_DESCRIPTION,Video::FIELDNAME_LIEN),array($this->_description,$this->_lien));
    }
    
    /**
     * Récupérer le/la description
     * @return string 
     */
    public function getDescription()
    {
        return $this->_description;
    }
    
    /**
     * Définir le/la description
     * @param $description string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setDescription($description,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_description = $description;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Video::_set(array(Video::FIELDNAME_DESCRIPTION),array($description)) : true;
    }
    
    /**
     * Récupérer le/la lien
     * @return string 
     */
    public function getLien()
    {
        return $this->_lien;
    }
    
    /**
     * Définir le/la lien
     * @param $lien string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setLien($lien,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_lien = $lien;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Video::_set(array(Video::FIELDNAME_LIEN),array($lien)) : true;
    }
    
    /**
     * Sélectionner les videos par membre
     * @param $pdo PDO 
     * @param $membre Membre 
     * @return PDOStatement 
     */
    public static function selectByMembre(PDO $pdo,Membre $membre)
    {
        $pdoStatement = self::_select($pdo,Post::FIELDNAME_MEMBRE_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($membre->getIdMembre()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les videos d\'un(e) membre depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Sélectionner les videos par categorie
     * @param $pdo PDO 
     * @param $categorie Categorie 
     * @return PDOStatement 
     */
    public static function selectByCategorie(PDO $pdo,Categorie $categorie)
    {
        $pdoStatement = self::_select($pdo,Post::FIELDNAME_CATEGORIE_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($categorie->getIdCategorie()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les videos d\'un(e) categorie depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * ToString
     * @return string Représentation de video sous la forme d'un string
     */
    public function __toString()
    {
        return parent::__toString().'<-'.'[Video description="'.$this->_description.'" lien="'.$this->_lien.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la video
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la video
        $array = array_merge(parent::serialize(false),array('description' => $this->_description,'lien' => $this->_lien));
        
        // Retourner la sérialisation (ou pas) du/de la video
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la video
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Video 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la video
        return $lazyload && isset(self::$_lazyload[$array['idpost']]) ? self::$_lazyload[$array['idpost']] :
               new Video($pdo,$array['idpost'],$array['titre'],$array['date'],$array['nb_vues'],$array['membre'],$array['categorie'],$array['description'],$array['lien'],$array['vedette'],$array['publie'],$lazyload);
    }
    
}

