<?php

/**
 * @name Base_Commentaire
 * @version 05/03/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Commentaire
{
    // Nom de la table
    const TABLENAME = 'commentaire';
    
    // Nom des champs
    const FIELDNAME_IDCOMMENTAIRE = 'idcommentaire';
    const FIELDNAME_DATE = 'date';
    const FIELDNAME_CONTENU = 'contenu';
    const FIELDNAME_MEMBRE_IDMEMBRE = 'fk_idmembre';
    const FIELDNAME_ARTICLE_IDARTICLE = 'fk_idarticle';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idCommentaire;
    
    /** @var string  */
    protected $_date;
    
    /** @var string  */
    protected $_contenu;
    
    /** @var int id de membre */
    protected $_membre;
    
    /** @var int id de article */
    protected $_article;
    
    /**
     * Construire un(e) commentaire
     * @param $pdo PDO 
     * @param $idCommentaire int 
     * @param $date string 
     * @param $contenu string 
     * @param $membre int Id de membre
     * @param $article int Id de article
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idCommentaire,$date,$contenu,$membre,$article,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idCommentaire = $idCommentaire;
        $this->_date = $date;
        $this->_contenu = $contenu;
        $this->_membre = $membre;
        $this->_article = $article;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idCommentaire] = $this;
        }
    }
    
    /**
     * Créer un(e) commentaire
     * @param $pdo PDO 
     * @param $date string 
     * @param $contenu string 
     * @param $membre Membre 
     * @param $article Article 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire 
     */
    public static function create(PDO $pdo,$date,$contenu,Membre $membre,Article $article,$lazyload=true)
    {
        // Ajouter le/la commentaire dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Commentaire::TABLENAME.' ('.Commentaire::FIELDNAME_DATE.','.Commentaire::FIELDNAME_CONTENU.','.Commentaire::FIELDNAME_MEMBRE_IDMEMBRE.','.Commentaire::FIELDNAME_ARTICLE_IDARTICLE.') VALUES (?,?,?,?)');
        if (!$pdoStatement->execute(array($date,$contenu,$membre->getIdMembre(),$article->getIdArticle()))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) commentaire dans la base de données');
        }
        
        // Construire le/la commentaire
        return new Commentaire($pdo,intval($pdo->lastInsertId()),$date,$contenu,$membre->getIdMembre(),$article->getIdArticle(),$lazyload);
    }
    
    /**
     * Compter les commentaires
     * @param $pdo PDO 
     * @return int Nombre de commentaires
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Commentaire::FIELDNAME_IDCOMMENTAIRE.') FROM '.Commentaire::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des commentaires dans la base de données');
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
        return $pdo->prepare('SELECT DISTINCT '.Commentaire::TABLENAME.'.'.Commentaire::FIELDNAME_IDCOMMENTAIRE.', '.Commentaire::TABLENAME.'.'.Commentaire::FIELDNAME_DATE.', '.Commentaire::TABLENAME.'.'.Commentaire::FIELDNAME_CONTENU.', '.Commentaire::TABLENAME.'.'.Commentaire::FIELDNAME_MEMBRE_IDMEMBRE.', '.Commentaire::TABLENAME.'.'.Commentaire::FIELDNAME_ARTICLE_IDARTICLE.' '.
                             'FROM '.Commentaire::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) commentaire
     * @param $pdo PDO 
     * @param $idCommentaire int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire 
     */
    public static function load(PDO $pdo,$idCommentaire,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idCommentaire])) {
            return self::$_lazyload[$idCommentaire];
        }
        
        // Charger le/la commentaire
        $pdoStatement = self::_select($pdo,Commentaire::FIELDNAME_IDCOMMENTAIRE.' = ?');
        if (!$pdoStatement->execute(array($idCommentaire))) {
            throw new Exception('Erreur lors du chargement d\'un(e) commentaire depuis la base de données');
        }
        
        // Récupérer le/la commentaire depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Commentaire::FIELDNAME_IDCOMMENTAIRE.' = ?');
        if (!$pdoStatement->execute(array($this->_idCommentaire))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) commentaire depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idCommentaire,$date,$contenu,$membre,$article) = $values;
        
        // Sauvegarder les valeurs
        $this->_date = $date;
        $this->_contenu = $contenu;
        $this->_membre = $membre;
        $this->_article = $article;
    }
    
    /**
     * Charger tous/toutes les commentaires
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire[] Tableau de commentaires
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les commentaires
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les commentaires
        $commentaires = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $commentaires;
    }
    
    /**
     * Sélectionner tous/toutes les commentaires
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les commentaires depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la commentaire suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idCommentaire,$date,$contenu,$membre,$article) = $values;
        
        // Construire le/la commentaire
        return $lazyload && isset(self::$_lazyload[intval($idCommentaire)]) ? self::$_lazyload[intval($idCommentaire)] :
               new Commentaire($pdo,intval($idCommentaire),$date,$contenu,$membre,$article,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les commentaires d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire[] Tableau de commentaires
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $commentaires = array();
        while ($commentaire = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $commentaires[] = $commentaire;
        }
        return $commentaires;
    }
    
    /**
     * Test d'égalité
     * @param $commentaire Commentaire 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($commentaire)
    {
        // Test si null
        if ($commentaire == null) { return false; }
        
        // Tester la classe
        if (!($commentaire instanceof Commentaire)) { return false; }
        
        // Tester les ids
        return $this->_idCommentaire == $commentaire->_idCommentaire;
    }
    
    /**
     * Vérifier que le/la commentaire existe en base de données
     * @return bool Le/La commentaire existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Commentaire::FIELDNAME_IDCOMMENTAIRE.') FROM '.Commentaire::TABLENAME.' WHERE '.Commentaire::FIELDNAME_IDCOMMENTAIRE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdCommentaire()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) commentaire existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la commentaire
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer le/la commentaire
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Commentaire::TABLENAME.' WHERE '.Commentaire::FIELDNAME_IDCOMMENTAIRE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdCommentaire()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) commentaire dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idCommentaire])) {
            unset(self::$_lazyload[$this->_idCommentaire]);
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Commentaire::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Commentaire::FIELDNAME_IDCOMMENTAIRE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdCommentaire())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) commentaire dans la base de données');
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
        return $this->_set(array(Commentaire::FIELDNAME_DATE,Commentaire::FIELDNAME_CONTENU,Commentaire::FIELDNAME_MEMBRE_IDMEMBRE,Commentaire::FIELDNAME_ARTICLE_IDARTICLE),array($this->_date,$this->_contenu,$this->_membre,$this->_article));
    }
    
    /**
     * Récupérer le/la idCommentaire
     * @return int 
     */
    public function getIdCommentaire()
    {
        return $this->_idCommentaire;
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
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_DATE),array($date)) : true;
    }
    
    /**
     * Récupérer le/la contenu
     * @return string 
     */
    public function getContenu()
    {
        return $this->_contenu;
    }
    
    /**
     * Définir le/la contenu
     * @param $contenu string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setContenu($contenu,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_contenu = $contenu;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_CONTENU),array($contenu)) : true;
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
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_MEMBRE_IDMEMBRE),array($membre->getIdMembre())) : true;
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
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_MEMBRE_IDMEMBRE),array($idMembre)) : true;
    }
    
    /**
     * Sélectionner les commentaires par membre
     * @param $pdo PDO 
     * @param $membre Membre 
     * @return PDOStatement 
     */
    public static function selectByMembre(PDO $pdo,Membre $membre)
    {
        $pdoStatement = self::_select($pdo,Commentaire::FIELDNAME_MEMBRE_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($membre->getIdMembre()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les commentaires d\'un(e) membre depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupérer le/la article
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article 
     */
    public function getArticle($lazyload=true)
    {
        return Article::load($this->_pdo,$this->_article,$lazyload);
    }
    
    /**
     * Récupérer le/les id(s) du/de la article
     * @return int Id de article
     */
    public function getArticleId()
    {
        return $this->_article;
    }
    
    /**
     * Définir le/la article
     * @param $article Article 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setArticle(Article $article,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_article = $article->getIdArticle();
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_ARTICLE_IDARTICLE),array($article->getIdArticle())) : true;
    }
    
    /**
     * Définir le/la article d'après son/ses id(s)
     * @param $idArticle int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setArticleById($idArticle,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_article = $idArticle;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Commentaire::_set(array(Commentaire::FIELDNAME_ARTICLE_IDARTICLE),array($idArticle)) : true;
    }
    
    /**
     * Sélectionner les commentaires par article
     * @param $pdo PDO 
     * @param $article Article 
     * @return PDOStatement 
     */
    public static function selectByArticle(PDO $pdo,Article $article)
    {
        $pdoStatement = self::_select($pdo,Commentaire::FIELDNAME_ARTICLE_IDARTICLE.' = ?', array(Commentaire::FIELDNAME_DATE.' DESC'));
        if (!$pdoStatement->execute(array($article->getIdArticle()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les commentaires d\'un(e) article depuis la base de données');
        }
        return self::fetchAll($pdo, $pdoStatement);
    }
    
    /**
     * ToString
     * @return string Représentation de commentaire sous la forme d'un string
     */
    public function __toString()
    {
        return '[Commentaire idCommentaire="'.$this->_idCommentaire.'" date="'.$this->_date.'" contenu="'.$this->_contenu.'" membre="'.$this->_membre.'" article="'.$this->_article.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la commentaire
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la commentaire
        $array = array('idcommentaire' => $this->_idCommentaire,'date' => $this->_date,'contenu' => $this->_contenu,'membre' => $this->_membre,'article' => $this->_article);
        
        // Retourner la sérialisation (ou pas) du/de la commentaire
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la commentaire
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Commentaire 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la commentaire
        return $lazyload && isset(self::$_lazyload[$array['idcommentaire']]) ? self::$_lazyload[$array['idcommentaire']] :
               new Commentaire($pdo,$array['idcommentaire'],$array['date'],$array['contenu'],$array['membre'],$array['article'],$lazyload);
    }
    
}

