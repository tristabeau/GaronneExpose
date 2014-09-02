<?php

/**
 * @name Base_Membre
 * @version 05/03/2014 (dd/mm/yyyy)
 * @author WebProjectHelper (http://www.elfangels.fr/webprojecthelper/)
 */
abstract class Base_Membre
{
    // Nom de la table
    const TABLENAME = 'membre';
    
    // Nom des champs
    const FIELDNAME_IDMEMBRE = 'idmembre';
    const FIELDNAME_PSEUDO = 'pseudo';
    const FIELDNAME_MDP = 'mdp';
    const FIELDNAME_AGE = 'age';
    const FIELDNAME_DESCR = 'descr';
    const FIELDNAME_FACEBOOK = 'facebook';
    const FIELDNAME_TWITTER = 'twitter';
    const FIELDNAME_GOOGLE = 'google';
    const FIELDNAME_SITE = 'site';
    const FIELDNAME_IMAGE = 'image';
    const FIELDNAME_SALT = 'salt';
    const FIELDNAME_MAIL = 'mail';
    const FIELDNAME_ACTIVE = 'active';
    const FIELDNAME_ACTIVATION = 'activation';
    const FIELDNAME_TITRE = 'titre';
    const FIELDNAME_GROUPE_IDGROUPE = 'fk_idgroupe';
    
    /** @var PDO  */
    protected $_pdo;
    
    /** @var array tableau pour le chargement fainéant */
    protected static $_lazyload;
    
    /** @var int  */
    protected $_idMembre;
    
    /** @var string  */
    protected $_pseudo;
    
    /** @var string  */
    protected $_mdp;
    
    /** @var int  */
    protected $_age;
    
    /** @var string  */
    protected $_descr;
    
    /** @var string  */
    protected $_facebook;
    
    /** @var string  */
    protected $_twitter;
    
    /** @var string  */
    protected $_google;
    
    /** @var string  */
    protected $_site;
    
    /** @var string  */
    protected $_image;
    
    /** @var string  */
    protected $_salt;
    
    /** @var string  */
    protected $_mail;
    
    /** @var bool  */
    protected $_active;
    
    /** @var string  */
    protected $_activation;
    
    /** @var string  */
    protected $_titre;
    
    /** @var int id de groupe */
    protected $_groupe;
    
    /**
     * Construire un(e) membre
     * @param $pdo PDO 
     * @param $idMembre int 
     * @param $pseudo string 
     * @param $mdp string 
     * @param $age int 
     * @param $descr string 
     * @param $facebook string 
     * @param $twitter string 
     * @param $google string 
     * @param $site string 
     * @param $image string 
     * @param $salt string 
     * @param $mail string 
     * @param $activation string 
     * @param $titre string 
     * @param $groupe int Id de groupe
     * @param $active bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     */
    protected function __construct(PDO $pdo,$idMembre,$pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe,$active=false,$lazyload=true)
    {
        // Sauvegarder pdo
        $this->_pdo = $pdo;
        
        // Sauvegarder les attributs
        $this->_idMembre = $idMembre;
        $this->_pseudo = $pseudo;
        $this->_mdp = $mdp;
        $this->_age = $age;
        $this->_descr = $descr;
        $this->_facebook = $facebook;
        $this->_twitter = $twitter;
        $this->_google = $google;
        $this->_site = $site;
        $this->_image = $image;
        $this->_salt = $salt;
        $this->_mail = $mail;
        $this->_activation = $activation;
        $this->_titre = $titre;
        $this->_groupe = $groupe;
        $this->_active = $active;
        
        // Sauvegarder pour le chargement fainéant
        if ($lazyload) {
            self::$_lazyload[$idMembre] = $this;
        }
    }
    
    /**
     * Créer un(e) membre
     * @param $pdo PDO 
     * @param $pseudo string 
     * @param $mdp string 
     * @param $age int 
     * @param $descr string 
     * @param $facebook string 
     * @param $twitter string 
     * @param $google string 
     * @param $site string 
     * @param $image string 
     * @param $salt string 
     * @param $mail string 
     * @param $activation string 
     * @param $titre string 
     * @param $groupe Groupe 
     * @param $active bool 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre 
     */
    public static function create(PDO $pdo,$pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,Groupe $groupe,$active=false,$lazyload=true)
    {
        // Ajouter le/la membre dans la base de données
        $pdoStatement = $pdo->prepare('INSERT INTO '.Membre::TABLENAME.' ('.Membre::FIELDNAME_PSEUDO.','.Membre::FIELDNAME_MDP.','.Membre::FIELDNAME_AGE.','.Membre::FIELDNAME_DESCR.','.Membre::FIELDNAME_FACEBOOK.','.Membre::FIELDNAME_TWITTER.','.Membre::FIELDNAME_GOOGLE.','.Membre::FIELDNAME_SITE.','.Membre::FIELDNAME_IMAGE.','.Membre::FIELDNAME_SALT.','.Membre::FIELDNAME_MAIL.','.Membre::FIELDNAME_ACTIVATION.','.Membre::FIELDNAME_TITRE.','.Membre::FIELDNAME_GROUPE_IDGROUPE.','.Membre::FIELDNAME_ACTIVE.') VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        if (!$pdoStatement->execute(array($pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe->getIdGroupe(),$active))) {
            throw new Exception('Erreur durant l\'insertion d\'un(e) membre dans la base de données');
        }
        
        // Construire le/la membre
        return new Membre($pdo,intval($pdo->lastInsertId()),$pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe->getIdGroupe(),$active,$lazyload);
    }
    
    /**
     * Compter les membres
     * @param $pdo PDO 
     * @return int Nombre de membres
     */
    public static function count(PDO $pdo)
    {
        if (!($pdoStatement = $pdo->query('SELECT COUNT('.Membre::FIELDNAME_IDMEMBRE.') FROM '.Membre::TABLENAME))) {
            throw new Exception('Erreur lors du comptage des membres dans la base de données');
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
        return $pdo->prepare('SELECT DISTINCT '.Membre::TABLENAME.'.'.Membre::FIELDNAME_IDMEMBRE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_PSEUDO.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_MDP.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_AGE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_DESCR.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_FACEBOOK.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_TWITTER.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_GOOGLE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_SITE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_IMAGE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_SALT.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_MAIL.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_ACTIVATION.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_TITRE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_GROUPE_IDGROUPE.', '.Membre::TABLENAME.'.'.Membre::FIELDNAME_ACTIVE.' '.
                             'FROM '.Membre::TABLENAME.($from != null ? ', '.(is_array($from) ? implode(', ',$from) : $from) : '').
                             ($where != null ? ' WHERE '.(is_array($where) ? implode(' AND ',$where) : $where) : '').
                             ($orderby != null ? ' ORDER BY '.(is_array($orderby) ? implode(', ',$orderby) : $orderby) : '').
                             ($limit != null ? ' LIMIT '.(is_array($limit) ? implode(', ', $limit) : $limit) : ''));
    }
    
    /**
     * Charger un(e) membre
     * @param $pdo PDO 
     * @param $idMembre int 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre 
     */
    public static function load(PDO $pdo,$idMembre,$lazyload=true)
    {
        // Déjà chargé(e) ?
        if ($lazyload && isset(self::$_lazyload[$idMembre])) {
            return self::$_lazyload[$idMembre];
        }
        
        // Charger le/la membre
        $pdoStatement = self::_select($pdo,Membre::FIELDNAME_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($idMembre))) {
            throw new Exception('Erreur lors du chargement d\'un(e) membre depuis la base de données');
        }
        
        // Récupérer le/la membre depuis le jeu de résultats
        return self::fetch($pdo,$pdoStatement,$lazyload);
    }
    
    /**
     * Recharger les données depuis la base de données
     */
    public function reload()
    {
        // Recharger les données
        $pdoStatement = self::_select($this->_pdo,Membre::FIELDNAME_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($this->_idMembre))) {
            throw new Exception('Erreur durant le rechargement des données d\'un(e) membre depuis la base de données');
        }
        
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idMembre,$pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe,$active) = $values;
        
        // Sauvegarder les valeurs
        $this->_pseudo = $pseudo;
        $this->_mdp = $mdp;
        $this->_age = $age;
        $this->_descr = $descr;
        $this->_facebook = $facebook;
        $this->_twitter = $twitter;
        $this->_google = $google;
        $this->_site = $site;
        $this->_image = $image;
        $this->_salt = $salt;
        $this->_mail = $mail;
        $this->_activation = $activation;
        $this->_titre = $titre;
        $this->_groupe = $groupe;
        $this->_active = $active;
    }
    
    /**
     * Charger tous/toutes les membres
     * @param $pdo PDO 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre[] Tableau de membres
     */
    public static function loadAll(PDO $pdo,$lazyload=true)
    {
        // Sélectionner tous/toutes les membres
        $pdoStatement = self::selectAll($pdo);
        
        // Récupèrer tous/toutes les membres
        $membres = self::fetchAll($pdo,$pdoStatement,$lazyload);
        
        // Retourner le tableau
        return $membres;
    }
    
    /**
     * Sélectionner tous/toutes les membres
     * @param $pdo PDO 
     * @return PDOStatement 
     */
    public static function selectAll(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo);
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les membres depuis la base de données');
        }
        return $pdoStatement;
    }
    
    /**
     * Récupèrer le/la membre suivant(e) d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre 
     */
    public static function fetch(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        // Extraire les valeurs
        $values = $pdoStatement->fetch(PDO::FETCH_NUM);
        if (!$values) { return null; }
        list($idMembre,$pseudo,$mdp,$age,$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe,$active) = $values;
        
        // Construire le/la membre
        return $lazyload && isset(self::$_lazyload[intval($idMembre)]) ? self::$_lazyload[intval($idMembre)] :
               new Membre($pdo,intval($idMembre),$pseudo,$mdp,intval($age),$descr,$facebook,$twitter,$google,$site,$image,$salt,$mail,$activation,$titre,$groupe,$active ? true : false,$lazyload);
    }
    
    /**
     * Récupèrer tous/toutes les membres d'un jeu de résultats
     * @param $pdo PDO 
     * @param $pdoStatement PDOStatement 
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre[] Tableau de membres
     */
    public static function fetchAll(PDO $pdo,PDOStatement $pdoStatement,$lazyload=true)
    {
        $membres = array();
        while ($membre = self::fetch($pdo,$pdoStatement,$lazyload)) {
            $membres[] = $membre;
        }
        return $membres;
    }
    
    /**
     * Test d'égalité
     * @param $membre Membre 
     * @return bool Les objets sont-ils égaux ?
     */
    public function equals($membre)
    {
        // Test si null
        if ($membre == null) { return false; }
        
        // Tester la classe
        if (!($membre instanceof Membre)) { return false; }
        
        // Tester les ids
        return $this->_idMembre == $membre->_idMembre;
    }
    
    /**
     * Vérifier que le/la membre existe en base de données
     * @return bool Le/La membre existe en base de données ?
     */
    public function exists()
    {
        $pdoStatement = $this->_pdo->prepare('SELECT COUNT('.Membre::FIELDNAME_IDMEMBRE.') FROM '.Membre::TABLENAME.' WHERE '.Membre::FIELDNAME_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdMembre()))) {
            throw new Exception('Erreur lors de la vérification qu\'un(e) membre existe dans la base de données');
        }
        return $pdoStatement->fetchColumn() == 1;
    }
    
    /**
     * Supprimer le/la membre
     * @return bool Opération réussie ?
     */
    public function delete()
    {
        // Supprimer les articles associé(e)s
        $select = $this->selectArticles();
        if (count($select)) {
            while ($article = Article::fetch($this->_pdo,$select)) {
                $article->delete();
            }
        }

        // Supprimer le/la membre
        $pdoStatement = $this->_pdo->prepare('DELETE FROM '.Membre::TABLENAME.' WHERE '.Membre::FIELDNAME_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array($this->getIdMembre()))) {
            throw new Exception('Erreur lors de la suppression d\'un(e) membre dans la base de données');
        }
        
        // Supprimer du tableau pour le chargement fainéant
        if (isset(self::$_lazyload[$this->_idMembre])) {
            unset(self::$_lazyload[$this->_idMembre]);
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
        $pdoStatement = $this->_pdo->prepare('UPDATE '.Membre::TABLENAME.' SET '.implode(', ', $updates).' WHERE '.Membre::FIELDNAME_IDMEMBRE.' = ?');
        if (!$pdoStatement->execute(array_merge($values,array($this->getIdMembre())))) {
            throw new Exception('Erreur lors de la mise à jour d\'un champ d\'un(e) membre dans la base de données');
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
        return $this->_set(array(Membre::FIELDNAME_PSEUDO,Membre::FIELDNAME_MDP,Membre::FIELDNAME_AGE,Membre::FIELDNAME_DESCR,Membre::FIELDNAME_FACEBOOK,Membre::FIELDNAME_TWITTER,Membre::FIELDNAME_GOOGLE,Membre::FIELDNAME_SITE,Membre::FIELDNAME_IMAGE,Membre::FIELDNAME_SALT,Membre::FIELDNAME_MAIL,Membre::FIELDNAME_ACTIVE,Membre::FIELDNAME_ACTIVATION,Membre::FIELDNAME_TITRE,Membre::FIELDNAME_GROUPE_IDGROUPE),array($this->_pseudo,$this->_mdp,$this->_age,$this->_descr,$this->_facebook,$this->_twitter,$this->_google,$this->_site,$this->_image,$this->_salt,$this->_mail,$this->_active,$this->_activation,$this->_titre,$this->_groupe));
    }
    
    /**
     * Récupérer le/la idMembre
     * @return int 
     */
    public function getIdMembre()
    {
        return $this->_idMembre;
    }
    
    /**
     * Récupérer le/la pseudo
     * @return string 
     */
    public function getPseudo()
    {
        return $this->_pseudo;
    }
    
    /**
     * Définir le/la pseudo
     * @param $pseudo string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setPseudo($pseudo,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_pseudo = $pseudo;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_PSEUDO),array($pseudo)) : true;
    }
    
    /**
     * Récupérer le/la mdp
     * @return string 
     */
    public function getMdp()
    {
        return $this->_mdp;
    }
    
    /**
     * Définir le/la mdp
     * @param $mdp string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setMdp($mdp,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_mdp = $mdp;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_MDP),array($mdp)) : true;
    }
    
    /**
     * Récupérer le/la age
     * @return int 
     */
    public function getAge()
    {
        return $this->_age;
    }
    
    /**
     * Définir le/la age
     * @param $age int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setAge($age,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_age = $age;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_AGE),array($age)) : true;
    }
    
    /**
     * Récupérer le/la descr
     * @return string 
     */
    public function getDescr()
    {
        return $this->_descr;
    }
    
    /**
     * Définir le/la descr
     * @param $descr string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setDescr($descr,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_descr = $descr;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_DESCR),array($descr)) : true;
    }
    
    /**
     * Récupérer le/la facebook
     * @return string 
     */
    public function getFacebook()
    {
        return $this->_facebook;
    }
    
    /**
     * Définir le/la facebook
     * @param $facebook string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setFacebook($facebook,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_facebook = $facebook;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_FACEBOOK),array($facebook)) : true;
    }
    
    /**
     * Récupérer le/la twitter
     * @return string 
     */
    public function getTwitter()
    {
        return $this->_twitter;
    }
    
    /**
     * Définir le/la twitter
     * @param $twitter string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setTwitter($twitter,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_twitter = $twitter;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_TWITTER),array($twitter)) : true;
    }
    
    /**
     * Récupérer le/la google
     * @return string 
     */
    public function getGoogle()
    {
        return $this->_google;
    }
    
    /**
     * Définir le/la google
     * @param $google string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setGoogle($google,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_google = $google;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_GOOGLE),array($google)) : true;
    }
    
    /**
     * Récupérer le/la site
     * @return string 
     */
    public function getSite()
    {
        return $this->_site;
    }
    
    /**
     * Définir le/la site
     * @param $site string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setSite($site,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_site = $site;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_SITE),array($site)) : true;
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
        return $execute ? Membre::_set(array(Membre::FIELDNAME_IMAGE),array($image)) : true;
    }
    
    /**
     * Récupérer le/la salt
     * @return string 
     */
    public function getSalt()
    {
        return $this->_salt;
    }
    
    /**
     * Définir le/la salt
     * @param $salt string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setSalt($salt,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_salt = $salt;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_SALT),array($salt)) : true;
    }
    
    /**
     * Récupérer le/la mail
     * @return string 
     */
    public function getMail()
    {
        return $this->_mail;
    }
    
    /**
     * Définir le/la mail
     * @param $mail string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setMail($mail,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_mail = $mail;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_MAIL),array($mail)) : true;
    }
    
    /**
     * Récupérer le/la active
     * @return bool 
     */
    public function getActive()
    {
        return $this->_active;
    }
    
    /**
     * Définir le/la active
     * @param $active bool 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setActive($active,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_active = $active;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_ACTIVE),array($active)) : true;
    }
    
    /**
     * Récupérer le/la activation
     * @return string 
     */
    public function getActivation()
    {
        return $this->_activation;
    }
    
    /**
     * Définir le/la activation
     * @param $activation string 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setActivation($activation,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_activation = $activation;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_ACTIVATION),array($activation)) : true;
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
        return $execute ? Membre::_set(array(Membre::FIELDNAME_TITRE),array($titre)) : true;
    }
    
    /**
     * Récupérer le/la groupe
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Groupe 
     */
    public function getGroupe($lazyload=true)
    {
        return Groupe::load($this->_pdo,$this->_groupe,$lazyload);
    }
    
    /**
     * Récupérer le/les id(s) du/de la groupe
     * @return int Id de groupe
     */
    public function getGroupeId()
    {
        return $this->_groupe;
    }
    
    /**
     * Définir le/la groupe
     * @param $groupe Groupe 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setGroupe(Groupe $groupe,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_groupe = $groupe->getIdGroupe();
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_GROUPE_IDGROUPE),array($groupe->getIdGroupe())) : true;
    }
    
    /**
     * Définir le/la groupe d'après son/ses id(s)
     * @param $idGroupe int 
     * @param $execute bool Exécuter la requête update ?
     * @return bool Opération réussie ?
     */
    public function setGroupeById($idGroupe,$execute=true)
    {
        // Sauvegarder dans l'objet
        $this->_groupe = $idGroupe;
        
        // Sauvegarder dans la base de données (ou pas)
        return $execute ? Membre::_set(array(Membre::FIELDNAME_GROUPE_IDGROUPE),array($idGroupe)) : true;
    }
    
    /**
     * Sélectionner les membres par groupe
     * @param $pdo PDO 
     * @param $groupe Groupe 
     * @return PDOStatement 
     */
    public static function selectByGroupe(PDO $pdo,Groupe $groupe)
    {
        $pdoStatement = self::_select($pdo,Membre::FIELDNAME_GROUPE_IDGROUPE.' = ?');
        if (!$pdoStatement->execute(array($groupe->getIdGroupe()))) {
            throw new Exception('Erreur lors du chargement de tous/toutes les membres d\'un(e) groupe depuis la base de données');
        }
        return self::fetchAll($pdo, $pdoStatement);
    }
    
    /**
     * Sélectionner les articles
     * @return PDOStatement 
     */
    public function selectArticles()
    {
        return Article::selectByMembre($this->_pdo,$this);
    }
    
    /**
     * Sélectionner les commentaires
     * @return PDOStatement 
     */
    public function selectCommentaires()
    {
        return Commentaire::selectByMembre($this->_pdo,$this);
    }
    
    /**
     * ToString
     * @return string Représentation de membre sous la forme d'un string
     */
    public function __toString()
    {
        return '[Membre idMembre="'.$this->_idMembre.'" pseudo="'.$this->_pseudo.'" mdp="'.$this->_mdp.'" age="'.$this->_age.'" descr="'.$this->_descr.'" facebook="'.$this->_facebook.'" twitter="'.$this->_twitter.'" google="'.$this->_google.'" site="'.$this->_site.'" image="'.$this->_image.'" salt="'.$this->_salt.'" mail="'.$this->_mail.'" active="'.($this->_active?'true':'false').'" activation="'.$this->_activation.'" titre="'.$this->_titre.'" groupe="'.$this->_groupe.'"]';
    }
    /**
     * Sérialiser
     * @param $serialize bool Activer la sérialisation ?
     * @return string Sérialisation du/de la membre
     */
    public function serialize($serialize=true)
    {
        // Sérialiser le/la membre
        $array = array('idmembre' => $this->_idMembre,'pseudo' => $this->_pseudo,'mdp' => $this->_mdp,'age' => $this->_age,'descr' => $this->_descr,'facebook' => $this->_facebook,'twitter' => $this->_twitter,'google' => $this->_google,'site' => $this->_site,'image' => $this->_image,'salt' => $this->_salt,'mail' => $this->_mail,'activation' => $this->_activation,'titre' => $this->_titre,'groupe' => $this->_groupe,'active' => $this->_active);
        
        // Retourner la sérialisation (ou pas) du/de la membre
        return $serialize ? serialize($array) : $array;
    }
    
    /**
     * Désérialiser
     * @param $pdo PDO 
     * @param $string string Sérialisation du/de la membre
     * @param $lazyload bool Activer le chargement fainéant ?
     * @return Membre 
     */
    public static function unserialize(PDO $pdo,$string,$lazyload=true)
    {
        // Désérialiser la chaine de caractères
        $array = unserialize($string);
        
        // Construire le/la membre
        return $lazyload && isset(self::$_lazyload[$array['idmembre']]) ? self::$_lazyload[$array['idmembre']] :
               new Membre($pdo,$array['idmembre'],$array['pseudo'],$array['mdp'],$array['age'],$array['descr'],$array['facebook'],$array['twitter'],$array['google'],$array['site'],$array['image'],$array['salt'],$array['mail'],$array['activation'],$array['titre'],$array['groupe'],$array['active'],$lazyload);
    }
    
}

