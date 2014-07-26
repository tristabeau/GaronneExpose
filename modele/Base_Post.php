<?php

/**
 * @name Base_Post
 * @version 20/02/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Post
{
    // Nom de la table
    const TABLENAME = 'post';
    
    // Nom des champs
    const FIELDNAME_IDPOST = 'idpost';
    const FIELDNAME_TITRE = 'titre';
    const FIELDNAME_DATE = 'date';
    const FIELDNAME_NB_VUES = 'nb_vues';
    const FIELDNAME_VEDETTE = 'vedette';
    const FIELDNAME_PUBLIE = 'publie';
    const FIELDNAME_MEMBRE_IDMEMBRE = 'fk_idmembre';
    const FIELDNAME_CATEGORIE_IDCATEGORIE = 'fk_idcategorie';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var int  */
    protected $_idPost;
    
    /** @var string  */
    protected $_titre;
    
    /** @var string  */
    protected $_date;
    
    /** @var int  */
    protected $_nb_vues;
    
    /** @var bool  */
    protected $_vedette;
    
    /** @var bool  */
    protected $_publie;
    
    /** @var int id de membre */
    protected $_membre;
    
    /** @var int id de categorie */
    protected $_categorie;
    
    /**
     * Construire un(e) post
     * @param $pdo PDO 
     * @param $idPost int 
     * @param $titre string 
     * @param $date string 
     * @param $nb_vues int 
     * @param $membre int Id de membre
     * @param $categorie int Id de categorie
     * @param $vedette bool 
     * @param $publie bool 
     */
    protected function __construct(PDO $pdo,$idPost,$titre,$date,$nb_vues,$membre,$categorie,$vedette=false,$publie=false)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idPost = $idPost;
        $this->_titre = $titre;
        $this->_date = $date;
        $this->_nb_vues = $nb_vues;
        $this->_membre = $membre;
        $this->_categorie = $categorie;
        $this->_vedette = $vedette;
        $this->_publie = $publie;
    }
    
    /**
     * Créer un(e) post
     * @param $pdo PDO 
     * @param $titre string 
     * @param $date string 
     * @param $nb_vues int 
     * @param $membre Membre 
     * @param $categorie Categorie 
     * @param $vedette bool 
     * @param $publie bool 
     * @return Post 
     */
    protected static function _create(PDO $pdo,$titre,$date,$nb_vues,Membre $membre,Categorie $categorie,$vedette=false,$publie=false)
    {
        // Ajouter le/la post dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Post::TABLENAME.' ('.Post::FIELDNAME_TITRE.','.Post::FIELDNAME_DATE.','.Post::FIELDNAME_NB_VUES.','.Post::FIELDNAME_MEMBRE_IDMEMBRE.','.Post::FIELDNAME_CATEGORIE_IDCATEGORIE.','.Post::FIELDNAME_VEDETTE.','.Post::FIELDNAME_PUBLIE.') VALUES (?,?,?,?,?,?,?)');
        if (!$pdoStatement->execute(array($titre,$date,$nb_vues,$membre->getIdMembre(),$categorie->getIdCategorie(),$vedette,$publie))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) post dans la base de données');
        }
        
        // Retourner idPost
        return intval($pdo->lastInsertId());
    }
    
    /**
     * Compter les posts
     * @param $pdo PDO 
     * @return int Nombre de posts
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Post::FIELDNAME_IDPOST.') FROM '.Post::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des posts dans la base de données');
        }
        return $pdoStatement->fetchColumn();
    }
    
    /**
     * Charger un(e) post
     * @param $pdo PDO 
     * @param $idPost int 
     * @return Post 
     */
    public static function load(PDO $pdo,$idPost)
    {
        if ($post = Article::load($pdo,$idPost)) { return $post; }
        if ($post = Video::load($pdo,$idPost)) { return $post; }
        return null;
    }
    
    /**
     * Test d'égalité
     * @param $post Post 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($post)
    {
        // Test si null
        if ($post == null) { return false; }
        
        // Tester la classe
        if (!($post instanceof Post)) { return false; }
        
        // Tester les ids
        return $this->_idPost == $post->_idPost;
    }
    
    /**
     * Supprimer le/la post
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer les commentaires associé(e)s
        $commentaires = $this->selectCommentaires();
        foreach ($commentaires as $commentaire) {
            $commentaire->delete();
        }
        
        // Supprimer le/la post
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Post::TABLENAME.' WHERE '.Post::FIELDNAME_IDPOST.' = ?');
        if (!$pdoStatement->execute(array($this->getIdPost()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) post dans la base de données');
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Post::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Post::FIELDNAME_IDPOST.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdPost())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) post dans la base de données');
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
        return self::_set(array(Post::FIELDNAME_TITRE,Post::FIELDNAME_DATE,Post::FIELDNAME_NB_VUES,Post::FIELDNAME_VEDETTE,Post::FIELDNAME_PUBLIE,Post::FIELDNAME_MEMBRE_IDMEMBRE,Post::FIELDNAME_CATEGORIE_IDCATEGORIE),array($this->_titre,$this->_date,$this->_nb_vues,$this->_vedette,$this->_publie,$this->_membre,$this->_categorie));
    }
    
    /**
     * Récupérer le/la idPost
     * @return int 
     */
    public function getIdPost()
    {
        return $this->_idPost;
    }
    
    /**
     * Récupérer le/la titre
     * @return string 
     */
    public function getTitre()
    {
        return $this->_titre;
    }
    
    /**
     * Définir le/la titre
     * @param $titre string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setTitre($titre,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_titre = $titre;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_TITRE),array($titre)) : true;
    }
    
    /**
     * Récupérer le/la date
     * @return string 
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Définir le/la date
     * @param $date string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setDate($date,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_date = $date;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_DATE),array($date)) : true;
    }
    
    /**
     * Récupérer le/la nb_vues
     * @return int 
     */
    public function getNb_vues()
    {
        return $this->_nb_vues;
    }
    
    /**
     * Définir le/la nb_vues
     * @param $nb_vues int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setNb_vues($nb_vues,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_nb_vues = $nb_vues;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_NB_VUES),array($nb_vues)) : true;
    }
    
    /**
     * Récupérer le/la vedette
     * @return bool 
     */
    public function getVedette()
    {
        return $this->_vedette;
    }
    
    /**
     * Définir le/la vedette
     * @param $vedette bool 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setVedette($vedette,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_vedette = $vedette;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_VEDETTE),array($vedette)) : true;
    }
    
    /**
     * Récupérer le/la publie
     * @return bool 
     */
    public function getPublie()
    {
        return $this->_publie;
    }
    
    /**
     * Définir le/la publie
     * @param $publie bool 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setPublie($publie,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_publie = $publie;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_PUBLIE),array($publie)) : true;
    }
    
    /**
     * Récupérer le/la membre
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre 
     */
    public function getMembre($lazyload=true)
    {
        return Membre::load($this->_pdo,$this->_membre,$lazyload);
    }
    
    /**
     * Récupérer le/les id(s) du/de la membre
     * @return int Id de membre
     */
    public function getMembreId()
    {
        return $this->_membre;
    }
    
    /**
     * Définir le/la membre
     * @param $membre Membre 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setMembre(Membre $membre,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_membre = $membre->getIdMembre();
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_MEMBRE_IDMEMBRE),array($membre->getIdMembre())) : true;
    }
    
    /**
     * Définir le/la membre d'après son/ses id(s)
     * @param $idMembre int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setMembreById($idMembre,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_membre = $idMembre;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_MEMBRE_IDMEMBRE),array($idMembre)) : true;
    }
    
    /**
     * Récupérer le/la categorie
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Categorie 
     */
    public function getCategorie($lazyload=true)
    {
        return Categorie::load($this->_pdo,$this->_categorie,$lazyload);
    }
    
    /**
     * Récupérer le/les id(s) du/de la categorie
     * @return int Id de categorie
     */
    public function getCategorieId()
    {
        return $this->_categorie;
    }
    
    /**
     * Définir le/la categorie
     * @param $categorie Categorie 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setCategorie(Categorie $categorie,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_categorie = $categorie->getIdCategorie();
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_CATEGORIE_IDCATEGORIE),array($categorie->getIdCategorie())) : true;
    }
    
    /**
     * Définir le/la categorie d'après son/ses id(s)
     * @param $idCategorie int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setCategorieById($idCategorie,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_categorie = $idCategorie;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Post::_set(array(Post::FIELDNAME_CATEGORIE_IDCATEGORIE),array($idCategorie)) : true;
    }
    
    /**
     * Sélectionner les commentaires
     * @return PDOStatement 
     */
    public function selectCommentaires()
    {
        return Commentaire::selectByPost($this->_pdo,$this);
    }
    
    /**
     * ToString
     * @return string Représentation de post sous la forme d'un string
     */
    public function __toString()
    {
        return '[Post idPost="'.$this->_idPost.'" titre="'.$this->_titre.'" date="'.$this->_date.'" nb_vues="'.$this->_nb_vues.'" vedette="'.($this->_vedette?'true':'false').'" publie="'.($this->_publie?'true':'false').'" membre="'.$this->_membre.'" categorie="'.$this->_categorie.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la post
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la post
        $array = array('idpost' => $this->_idPost,'titre' => $this->_titre,'date' => $this->_date,'nb_vues' => $this->_nb_vues,'membre' => $this->_membre,'categorie' => $this->_categorie,'vedette' => $this->_vedette,'publie' => $this->_publie);
        
        // Retourner la sérialisation (ou pas) du/de la post
        return $serialize ? serialize($array) : $array;
    }
    
}

