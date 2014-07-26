<?php

/**
 * @name Base_Article
 * @version 21/03/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Article
{
    // Nom de la table
    const TABLENAME = 'article';
    
    // Nom des champs
    const FIELDNAME_IDARTICLE = 'idarticle';
    const FIELDNAME_TITRE = 'titre';
    const FIELDNAME_DATE = 'date';
    const FIELDNAME_ANNEE = 'annee';
    const FIELDNAME_MOIS = 'mois';
    const FIELDNAME_JOUR = 'jour';
    const FIELDNAME_HEURE = 'heure';
    const FIELDNAME_CONTENU = 'contenu';
    const FIELDNAME_IMAGE = 'image';
    const FIELDNAME_NB_VUES = 'nb_vues';
    const FIELDNAME_VEDETTE = 'vedette';
    const FIELDNAME_PUBLIE = 'publie';
    const FIELDNAME_CORRIGE = 'corrige';
    const FIELDNAME_PERMALIEN = 'permalien';
    const FIELDNAME_RAPPORT = 'rapport';
    const FIELDNAME_CORRECTEUR = 'correcteur';
    const FIELDNAME_MEMBRE_IDMEMBRE = 'fk_idmembre';
    const FIELDNAME_CATEGORIE_IDCATEGORIE = 'fk_idcategorie';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idArticle;
    
    /** @var string  */
    protected $_titre;
    
    /** @var string  */
    protected $_date;
    
    /** @var int  */
    protected $_annee;
    
    /** @var int  */
    protected $_mois;
    
    /** @var int  */
    protected $_jour;
    
    /** @var string  */
    protected $_heure;
    
    /** @var string  */
    protected $_contenu;
    
    /** @var string  */
    protected $_image;
    
    /** @var int  */
    protected $_nb_vues;
    
    /** @var bool  */
    protected $_vedette;
    
    /** @var bool  */
    protected $_publie;
    
    /** @var bool  */
    protected $_corrige;
    
    /** @var string  */
    protected $_permalien;
    
    /** @var string  */
    protected $_rapport;
    
    /** @var string  */
    protected $_correcteur;
    
    /** @var int id de membre */
    protected $_membre;
    
    /** @var int id de categorie */
    protected $_categorie;
    
    /**
     * Construire un(e) article
     * @param $pdo PDO 
     * @param $idArticle int 
     * @param $titre string 
     * @param $date string 
     * @param $annee int 
     * @param $mois int 
     * @param $jour int 
     * @param $heure string 
     * @param $contenu string 
     * @param $image string 
     * @param $nb_vues int 
     * @param $permalien string 
     * @param $rapport string 
     * @param $correcteur string 
     * @param $membre int Id de membre
     * @param $categorie int Id de categorie
     * @param $vedette bool 
     * @param $publie bool 
     * @param $corrige bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idArticle,$titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,$membre,$categorie,$vedette=false,$publie=false,$corrige=false,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idArticle = $idArticle;
        $this->_titre = $titre;
        $this->_date = $date;
        $this->_annee = $annee;
        $this->_mois = $mois;
        $this->_jour = $jour;
        $this->_heure = $heure;
        $this->_contenu = $contenu;
        $this->_image = $image;
        $this->_nb_vues = $nb_vues;
        $this->_permalien = $permalien;
        $this->_rapport = $rapport;
        $this->_correcteur = $correcteur;
        $this->_membre = $membre;
        $this->_categorie = $categorie;
        $this->_vedette = $vedette;
        $this->_publie = $publie;
        $this->_corrige = $corrige;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idArticle] = $this;
        }
    }
    
    /**
     * Créer un(e) article
     * @param $pdo PDO 
     * @param $titre string 
     * @param $date string 
     * @param $annee int 
     * @param $mois int 
     * @param $jour int 
     * @param $heure string 
     * @param $contenu string 
     * @param $image string 
     * @param $nb_vues int 
     * @param $permalien string 
     * @param $rapport string 
     * @param $correcteur string 
     * @param $membre Membre 
     * @param $categorie Categorie 
     * @param $vedette bool 
     * @param $publie bool 
     * @param $corrige bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article 
     */
    public static function create(PDO $pdo,$titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,Membre $membre,Categorie $categorie,$vedette=false,$publie=false,$corrige=false,$lazyload=true)
    {
        // Ajouter le/la article dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Article::TABLENAME.' ('.Article::FIELDNAME_TITRE.','.Article::FIELDNAME_DATE.','.Article::FIELDNAME_ANNEE.','.Article::FIELDNAME_MOIS.','.Article::FIELDNAME_JOUR.','.Article::FIELDNAME_HEURE.','.Article::FIELDNAME_CONTENU.','.Article::FIELDNAME_IMAGE.','.Article::FIELDNAME_NB_VUES.','.Article::FIELDNAME_PERMALIEN.','.Article::FIELDNAME_RAPPORT.','.Article::FIELDNAME_CORRECTEUR.','.Article::FIELDNAME_MEMBRE_IDMEMBRE.','.Article::FIELDNAME_CATEGORIE_IDCATEGORIE.','.Article::FIELDNAME_VEDETTE.','.Article::FIELDNAME_PUBLIE.','.Article::FIELDNAME_CORRIGE.') VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        if (!$pdoStatement->execute(array($titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,$membre->getIdMembre(),$categorie->getIdCategorie(),$vedette,$publie,$corrige))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) article dans la base de données');
        }
        
        // Construire le/la article
        return new Article($pdo,intval($pdo->lastInsertId()),$titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,$membre->getIdMembre(),$categorie->getIdCategorie(),$vedette,$publie,$corrige,$lazyload);
    }
    
    /**
     * Compter les articles
     * @param $pdo PDO 
     * @return int Nombre de articles
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Article::FIELDNAME_IDARTICLE.') FROM '.Article::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des articles dans la base de données');
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
        return $pdo->prepare('SELECT DISTINCT '.Article::TABLENAME.'.'.Article::FIELDNAME_IDARTICLE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_TITRE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_DATE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_ANNEE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_MOIS.', '.Article::TABLENAME.'.'.Article::FIELDNAME_JOUR.', '.Article::TABLENAME.'.'.Article::FIELDNAME_HEURE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_CONTENU.', '.Article::TABLENAME.'.'.Article::FIELDNAME_IMAGE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_NB_VUES.', '.Article::TABLENAME.'.'.Article::FIELDNAME_PERMALIEN.', '.Article::TABLENAME.'.'.Article::FIELDNAME_RAPPORT.', '.Article::TABLENAME.'.'.Article::FIELDNAME_CORRECTEUR.', '.Article::TABLENAME.'.'.Article::FIELDNAME_MEMBRE_IDMEMBRE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_CATEGORIE_IDCATEGORIE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_VEDETTE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_PUBLIE.', '.Article::TABLENAME.'.'.Article::FIELDNAME_CORRIGE.' '.
                             'FROM '.Article::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : ' ORDER BY '.Article::TABLENAME.'.'.Article::FIELDNAME_DATE.' DESC').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) article
     * @param $pdo PDO 
     * @param $idArticle int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article 
     */
    public static function load(PDO $pdo,$idArticle,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idArticle])) {
            return self::$_lazyload[$idArticle];
        }
        
        // Charger le/la article
        $pdoStatement = self::_select($pdo,Article::FIELDNAME_IDARTICLE.' = ?');
        if (!$pdoStatement->execute(array($idArticle))) {
            throw new Exception('Erreur lors du chargement d\'un(e) article depuis la base de données');
        }
        
        // Récupérer le/la article depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Article::FIELDNAME_IDARTICLE.' = ?');
        if (!$pdoStatement->execute(array($this->_idArticle))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) article depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idArticle,$titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,$membre,$categorie,$vedette,$publie,$corrige) = $values;
        
        // Sauvegarder les valeurs
        $this->_titre = $titre;
        $this->_date = $date;
        $this->_annee = $annee;
        $this->_mois = $mois;
        $this->_jour = $jour;
        $this->_heure = $heure;
        $this->_contenu = $contenu;
        $this->_image = $image;
        $this->_nb_vues = $nb_vues;
        $this->_permalien = $permalien;
        $this->_rapport = $rapport;
        $this->_correcteur = $correcteur;
        $this->_membre = $membre;
        $this->_categorie = $categorie;
        $this->_vedette = $vedette;
        $this->_publie = $publie;
        $this->_corrige = $corrige;
    }
    
    /**
     * Charger tous/toutes les articles
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article[] Tableau de articles
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les articles
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les articles
        $articles = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $articles;
    }
    
    /**
     * Sélectionner tous/toutes les articles
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la article suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idArticle,$titre,$date,$annee,$mois,$jour,$heure,$contenu,$image,$nb_vues,$permalien,$rapport,$correcteur,$membre,$categorie,$vedette,$publie,$corrige) = $values;
        
        // Construire le/la article
        return $lazyload && isset(self::$_lazyload[intval($idArticle)]) ? self::$_lazyload[intval($idArticle)] :
               new Article($pdo,intval($idArticle),$titre,$date,intval($annee),intval($mois),intval($jour),$heure,$contenu,$image,intval($nb_vues),$permalien,$rapport,$correcteur,$membre,$categorie,$vedette ? true : false,$publie ? true : false,$corrige ? true : false,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les articles d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article[] Tableau de articles
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $articles = array();
        while ($article = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $articles[] = $article;
        }
        return $articles;
    }
    
    /**
     * Test d'égalité
     * @param $article Article 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($article)
    {
        // Test si null
        if ($article == null) { return false; }
        
        // Tester la classe
        if (!($article instanceof Article)) { return false; }
        
        // Tester les ids
        return $this->_idArticle == $article->_idArticle;
    }
    
    /**
     * Vérifier que le/la article existe en base de données
     * @return bool Le/La article existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Article::FIELDNAME_IDARTICLE.') FROM '.Article::TABLENAME.' WHERE '.Article::FIELDNAME_IDARTICLE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdArticle()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) article existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la article
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer les commentaires associé(e)s
        $select = $this->selectCommentaires();
        while ($commentaire = Commentaire::fetch($this->_pdo,$select)) {
            $commentaire->delete();
        }
        
        // Supprimer le/la article
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Article::TABLENAME.' WHERE '.Article::FIELDNAME_IDARTICLE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdArticle()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) article dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idArticle])) {
            unset(self::$_lazyload[$this->_idArticle]);
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Article::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Article::FIELDNAME_IDARTICLE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdArticle())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) article dans la base de données');
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
        return $this->_set(array(Article::FIELDNAME_TITRE,Article::FIELDNAME_DATE,Article::FIELDNAME_ANNEE,Article::FIELDNAME_MOIS,Article::FIELDNAME_JOUR,Article::FIELDNAME_HEURE,Article::FIELDNAME_CONTENU,Article::FIELDNAME_IMAGE,Article::FIELDNAME_NB_VUES,Article::FIELDNAME_VEDETTE,Article::FIELDNAME_PUBLIE,Article::FIELDNAME_CORRIGE,Article::FIELDNAME_PERMALIEN,Article::FIELDNAME_RAPPORT,Article::FIELDNAME_CORRECTEUR,Article::FIELDNAME_MEMBRE_IDMEMBRE,Article::FIELDNAME_CATEGORIE_IDCATEGORIE),array($this->_titre,$this->_date,$this->_annee,$this->_mois,$this->_jour,$this->_heure,$this->_contenu,$this->_image,$this->_nb_vues,$this->_vedette,$this->_publie,$this->_corrige,$this->_permalien,$this->_rapport,$this->_correcteur,$this->_membre,$this->_categorie));
    }
    
    /**
     * Récupérer le/la idArticle
     * @return int 
     */
    public function getIdArticle()
    {
        return $this->_idArticle;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_TITRE),array($titre)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_DATE),array($date)) : true;
    }
    
    /**
     * Récupérer le/la annee
     * @return int 
     */
    public function getAnnee()
    {
        return $this->_annee;
    }
    
    /**
     * Définir le/la annee
     * @param $annee int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setAnnee($annee,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_annee = $annee;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_ANNEE),array($annee)) : true;
    }
    
    /**
     * Récupérer le/la mois
     * @return int 
     */
    public function getMois()
    {
        return $this->_mois;
    }
    
    /**
     * Définir le/la mois
     * @param $mois int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setMois($mois,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_mois = $mois;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_MOIS),array($mois)) : true;
    }
    
    /**
     * Récupérer le/la jour
     * @return int 
     */
    public function getJour()
    {
        return $this->_jour;
    }
    
    /**
     * Définir le/la jour
     * @param $jour int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setJour($jour,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_jour = $jour;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_JOUR),array($jour)) : true;
    }
    
    /**
     * Récupérer le/la heure
     * @return string 
     */
    public function getHeure()
    {
        return $this->_heure;
    }
    
    /**
     * Définir le/la heure
     * @param $heure string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setHeure($heure,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_heure = $heure;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_HEURE),array($heure)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_CONTENU),array($contenu)) : true;
    }
    
    /**
     * Récupérer le/la image
     * @return string 
     */
    public function getImage()
    {
        return $this->_image;
    }
    
    /**
     * Définir le/la image
     * @param $image string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setImage($image,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_image = $image;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_IMAGE),array($image)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_NB_VUES),array($nb_vues)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_VEDETTE),array($vedette)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_PUBLIE),array($publie)) : true;
    }
    
    /**
     * Récupérer le/la corrige
     * @return bool 
     */
    public function getCorrige()
    {
        return $this->_corrige;
    }
    
    /**
     * Définir le/la corrige
     * @param $corrige bool 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setCorrige($corrige,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_corrige = $corrige;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_CORRIGE),array($corrige)) : true;
    }
    
    /**
     * Récupérer le/la permalien
     * @return string 
     */
    public function getPermalien()
    {
        return $this->_permalien;
    }
    
    /**
     * Définir le/la permalien
     * @param $permalien string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setPermalien($permalien,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_permalien = $permalien;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_PERMALIEN),array($permalien)) : true;
    }
    
    /**
     * Récupérer le/la rapport
     * @return string 
     */
    public function getRapport()
    {
        return $this->_rapport;
    }
    
    /**
     * Définir le/la rapport
     * @param $rapport string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setRapport($rapport,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_rapport = $rapport;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_RAPPORT),array($rapport)) : true;
    }
    
    /**
     * Récupérer le/la correcteur
     * @return string 
     */
    public function getCorrecteur()
    {
        return $this->_correcteur;
    }
    
    /**
     * Définir le/la correcteur
     * @param $correcteur string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setCorrecteur($correcteur,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_correcteur = $correcteur;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Article::_set(array(Article::FIELDNAME_CORRECTEUR),array($correcteur)) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_MEMBRE_IDMEMBRE),array($membre->getIdMembre())) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_MEMBRE_IDMEMBRE),array($idMembre)) : true;
    }
    
    /**
     * Sélectionner les articles par membre
     * @param $pdo PDO 
     * @param $membre Membre 
     * @return PDOStatement 
     */
    public static function selectByMembre(PDO $pdo,Membre $membre)
    {
        $pdoStatement = self::_select($pdo,Article::FIELDNAME_MEMBRE_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($membre->getIdMembre()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) membre depuis la base de données');
        }
        return $pdoStatement;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_CATEGORIE_IDCATEGORIE),array($categorie->getIdCategorie())) : true;
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
        return $execute ? Article::_set(array(Article::FIELDNAME_CATEGORIE_IDCATEGORIE),array($idCategorie)) : true;
    }
    
    /**
     * Sélectionner les articles par categorie
     * @param $pdo PDO 
     * @param $categorie Categorie 
     * @return PDOStatement 
     */
    public static function selectByCategorie(PDO $pdo,Categorie $categorie)
    {
        $pdoStatement = self::_select($pdo,Article::FIELDNAME_CATEGORIE_IDCATEGORIE.' = ?');
        if (!$pdoStatement->execute(array($categorie->getIdCategorie()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Sélectionner les commentaires
     * @return PDOStatement 
     */
    public function selectCommentaires()
    {
        return Commentaire::selectByArticle($this->_pdo,$this);
    }
    
    /**
     * ToString
     * @return string Représentation de article sous la forme d'un string
     */
    public function __toString()
    {
        return '[Article idArticle="'.$this->_idArticle.'" titre="'.$this->_titre.'" date="'.$this->_date.'" annee="'.$this->_annee.'" mois="'.$this->_mois.'" jour="'.$this->_jour.'" heure="'.$this->_heure.'" contenu="'.$this->_contenu.'" image="'.$this->_image.'" nb_vues="'.$this->_nb_vues.'" vedette="'.($this->_vedette?'true':'false').'" publie="'.($this->_publie?'true':'false').'" corrige="'.($this->_corrige?'true':'false').'" permalien="'.$this->_permalien.'" rapport="'.$this->_rapport.'" correcteur="'.$this->_correcteur.'" membre="'.$this->_membre.'" categorie="'.$this->_categorie.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la article
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la article
        $array = array('idarticle' => $this->_idArticle,'titre' => $this->_titre,'date' => $this->_date,'annee' => $this->_annee,'mois' => $this->_mois,'jour' => $this->_jour,'heure' => $this->_heure,'contenu' => $this->_contenu,'image' => $this->_image,'nb_vues' => $this->_nb_vues,'permalien' => $this->_permalien,'rapport' => $this->_rapport,'correcteur' => $this->_correcteur,'membre' => $this->_membre,'categorie' => $this->_categorie,'vedette' => $this->_vedette,'publie' => $this->_publie,'corrige' => $this->_corrige);
        
        // Retourner la sérialisation (ou pas) du/de la article
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la article
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Article 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la article
        return $lazyload && isset(self::$_lazyload[$array['idarticle']]) ? self::$_lazyload[$array['idarticle']] :
               new Article($pdo,$array['idarticle'],$array['titre'],$array['date'],$array['annee'],$array['mois'],$array['jour'],$array['heure'],$array['contenu'],$array['image'],$array['nb_vues'],$array['permalien'],$array['rapport'],$array['correcteur'],$array['membre'],$array['categorie'],$array['vedette'],$array['publie'],$array['corrige'],$lazyload);
    }
    
}

