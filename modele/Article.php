<?php

/**
 * @name Article
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Article extends Base_Article
{
    
    /**
     * Charger les 5 derniers articles
     * @return articles 
     */
    public static function getLastArticles(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ", array(Article::FIELDNAME_DATE.' DESC'), 5);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }   
    
    /**
     * Charger les 10 articles aléatoirement
     * @return articles 
     */
    public static function getRandArticles(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() " , array("Rand()"), 10);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }  
    
    /**
     * Charger les 3 derniers articles en vedette
     * @return articles 
     */
    public static function getLastvedetteArticles(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.Article::FIELDNAME_VEDETTE.' = 1 AND '.Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ", array(Article::FIELDNAME_DATE.' DESC'), 3);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }
    
    /**
     * Charger les 4 derniers articles les plus lus
     * @return articles 
     */
    public static function getPopularArticles(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ", array(Article::FIELDNAME_NB_VUES.' DESC'), 4);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }    
    
    /**
     * Charger les 4 derniers articles
     * @return articles 
     */
    public static function getRecentArticles(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ", array(Article::FIELDNAME_DATE.' DESC'), 4);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }  
    
        /**
     * compter par categorie
     * @return articles 
     */
    public static function countAllCategorie(PDO $pdo, $annee, $mois, $jour)
    {
        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                          Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                          ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                          ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                          ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""));
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }

        return $pdoStatement->rowCount();
    }    
    

    /**
     * Charger par categorie
     * @return articles 
     */
    public static function selectAllCategorie(PDO $pdo, $annee, $mois, $jour, $page, $nb, $total)
    {
        $start = (($page - 1) * $nb) ;
        
        if ($total >= ($start + $nb)) {
            $max = $nb;
        } else {
            $max = $total - $start + 1;
        }

        $pdoStatement = self::_select($pdo, Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                          Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                          ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                          ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                          ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""), 
                                                          array(Article::FIELDNAME_DATE.' DESC'),  
                                                          array($start, $max));
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }

        return self::fetchAll($pdo,$pdoStatement);
    } 
    
    /**
     * Charger par categorie
     * @return articles 
     */
    public static function getByCategorie(PDO $pdo, $categorie, $annee, $mois, $jour, $page, $nb, $total)
    {
        $start = (($page - 1) * $nb) ;
        
        if ($total >= ($start + $nb)) {
            $max = $nb;
        } else {
            $max = $total - $start + 1;
        }
        
        $categories = array();
        $categories[] =  $categorie->getIdCategorie();
        foreach ($categorie->selectFils() as $cat) {
            $categories[] =  $cat->getIdCategorie();
        }

        $pdoStatement = self::_select($pdo,Article::FIELDNAME_CATEGORIE_IDCATEGORIE.' IN ('.implode(",", $categories).') AND '.
                                                        Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                        Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                        ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                        ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                        ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""),
                                                        array(Article::FIELDNAME_DATE.' DESC'),  
                                                        array($start, $max));
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }

        return self::fetchAll($pdo,$pdoStatement);
    } 
    
    /**
     * compter par categorie
     * @return articles 
     */
    public static function countByCategorie(PDO $pdo, $categorie, $annee, $mois, $jour)
    {
        $categories = array();
        $categories[] =  $categorie->getIdCategorie();
        foreach ($categorie->selectFils() as $cat) {
            $categories[] =  $cat->getIdCategorie();
        }

        $pdoStatement = self::_select($pdo,Article::FIELDNAME_CATEGORIE_IDCATEGORIE.' IN ('.implode(",", $categories).') AND '.
                                                        Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                        Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                        ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                        ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                        ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""));
     
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }

        return $pdoStatement->rowCount();
    }    
    
    /**
     * Charger par recherche
     * @return articles 
     */
    public static function getBySearch(PDO $pdo, $search, $annee, $mois, $jour, $page, $nb, $total)
    {
        $start = (($page - 1) * $nb) ;
        
        if ($total >= ($start + $nb)) {
            $max = $nb;
        } else {
            $max = $total - $start + 1;
        }
        
        $mots = explode(" ", $search);
        $res = array();
        
        foreach ($mots as $mot) {
            $pdoStatement = self::_select($pdo,'('.Article::FIELDNAME_CONTENU.' LIKE "%'.$mot.'%" OR '.Article::FIELDNAME_TITRE.' LIKE "%'.$mot.'%" ) AND '.
                                                   Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                   Article::FIELDNAME_DATE.' <= UNIX_TIMESTAMP()'.
                                                   ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                   ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                   ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""), 
                                                   array(Article::FIELDNAME_DATE.' DESC'));
     
            if (!$pdoStatement->execute()) {
                throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
            }

            $res = array_merge($res, self::fetchAll($pdo,$pdoStatement));
        }

        return array_slice($res, $start, $max);
    } 
    
    /**
     * compter par recherche
     * @return articles 
     */
    public static function countSearch(PDO $pdo, $search, $annee, $mois, $jour)
    {
        $count = 0;
        $mots = explode(" ", $search);
        
        foreach ($mots as $mot) {
            $pdoStatement = self::_select($pdo,"(".Article::FIELDNAME_CONTENU.' LIKE "%'.$mot.'%" OR '.Article::FIELDNAME_TITRE.' LIKE "%'.$mot.'%" ) AND '.
                                                   Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                   Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                   ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                   ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                   ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""));
     
            if (!$pdoStatement->execute()) {
                throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
            }

            $count += $pdoStatement->rowCount();
        }

        return $count;
    }    
    
    /**
     * detail article
     * @return articles 
     */
    public static function selectDetail(PDO $pdo, $annee, $mois, $jour, $permalien)
    {
       

        $pdoStatement = self::_select($pdo, Article::FIELDNAME_ANNEE.' = ? AND '.Article::FIELDNAME_MOIS.' = ? AND '.Article::FIELDNAME_JOUR.' = ?  AND '.Article::FIELDNAME_PERMALIEN.' = ? ');
        if (!$pdoStatement->execute(array($annee, $mois, $jour, $permalien))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }
        
    /**
     * nombre de vue par ip de l'article 
     * @return  le nombre de vue par ip de l'article 
     */
    public function nbVues()
    {
       
        $pdoStatement = $this->_pdo->prepare("SELECT ip FROM nb_vues WHERE fk_idarticle = ?");

        if (!$pdoStatement->execute(array($this->_idArticle))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->rowCount();
    }  
        
    /**
     * Charger par categorie
     * @return articles 
     */
    public static function getByAuteur(PDO $pdo, $idMembre, $annee, $mois, $jour, $page, $nb, $total)
    {
        $start = (($page - 1) * $nb) ;      
        
        if ($total >= ($start + $nb)) {
            $max = $nb;
        } else {
            $max = $total - $start + 1;
        }

        if($max < 0){
            return array();
        } else {
            $pdoStatement = self::_select($pdo,Article::FIELDNAME_MEMBRE_IDMEMBRE.' = '.$idMembre.' AND '.
                                                            Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                            Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                            ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                            ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                            ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""),
                                                            array(Article::FIELDNAME_DATE.' DESC'),  
                                                            array($start, $max));
                                                            
            if (!$pdoStatement->execute()) {
                throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
            }
            
            return self::fetchAll($pdo,$pdoStatement);
        }
    } 
    
    /**
     * compter par categorie
     * @return articles 
     */
    public static function countByAuteur(PDO $pdo, $idMembre, $annee, $mois, $jour)
    {
        $pdoStatement = self::_select($pdo,Article::FIELDNAME_MEMBRE_IDMEMBRE.' = '.$idMembre.' AND '.
                                                        Article::FIELDNAME_PUBLIE.' = 1 AND '.
                                                        Article::FIELDNAME_DATE." <= UNIX_TIMESTAMP() ".
                                                        ($annee != "all" ? "AND ".Article::FIELDNAME_ANNEE." = '".$annee."' " : "").
                                                        ($mois != "all" ? "AND ".Article::FIELDNAME_MOIS." = '".$mois."' " : "").
                                                        ($jour != "all" ? "AND ".Article::FIELDNAME_JOUR." = '".$jour."' " : ""));

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
        }

        return $pdoStatement->rowCount();
    }
    
    /**
     * @return les années où il y a eu des articles;
     */
    public static function selectDistinctAnnee(PDO $pdo)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_ANNEE.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_ANNEE.' DESC');
                                                    
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }  
    
    /**
     * @return les mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctMois(PDO $pdo, $annee)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_MOIS.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_ANNEE.' = ?'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_MOIS.' DESC');
                                                    
        if (!$pdoStatement->execute(array($annee))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }  
    
    /**
     * @return les jours d'un mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctJours(PDO $pdo, $annee, $mois)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_JOUR.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_ANNEE.' = ?'.
                                                    ' AND '.Article::FIELDNAME_MOIS.' = ?'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_JOUR.' DESC');
                                                    
        if (!$pdoStatement->execute(array($annee, $mois))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }
    
     /**
     * @return les années où il y a eu des articles;
     */
    public static function selectDistinctAnneeByProfil(PDO $pdo, $idMembre)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_ANNEE.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_MEMBRE_IDMEMBRE.' = '.$idMembre.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_ANNEE.' DESC');
                                                    
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }  
    
    /**
     * @return les mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctMoisByProfil(PDO $pdo, $annee, $idMembre)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_MOIS.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_MEMBRE_IDMEMBRE.' = '.$idMembre.
                                                    ' AND '.Article::FIELDNAME_ANNEE.' = ?'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_MOIS.' DESC');
                                                    
        if (!$pdoStatement->execute(array($annee))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }  
    
    /**
     * @return les jours d'un mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctJoursByProfil(PDO $pdo, $annee, $mois, $idMembre)
    {
       
        $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_JOUR.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE '.Article::FIELDNAME_MEMBRE_IDMEMBRE.' = '.$idMembre.
                                                    ' AND '.Article::FIELDNAME_ANNEE.' = ?'.
                                                    ' AND '.Article::FIELDNAME_MOIS.' = ?'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_JOUR.' DESC');
                                                    
        if (!$pdoStatement->execute(array($annee, $mois))) {
            throw new Exception('Erreur lors du chargement de l article depuis la base de données');
        }
        
        return $pdoStatement->fetchAll();
    }    
    
     /**
     * @return les années où il y a eu des articles;
     */
    public static function selectDistinctAnneeBySearch(PDO $pdo, $search)
    {
        $mots = explode(" ", $search);        
        $res = array();
        
        foreach ($mots as $mot) {
            $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_ANNEE.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE ('.Article::FIELDNAME_CONTENU.' LIKE "%'.$mot.'%" OR '.Article::FIELDNAME_TITRE.' LIKE "%'.$mot.'%" )'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_ANNEE.' DESC');

            if (!$pdoStatement->execute()) {
                throw new Exception('Erreur lors du chargement de tous/toutes les articles d\'un(e) categorie depuis la base de données');
            }

            $res = array_merge($res, $pdoStatement->fetchAll());
        }
        
        return $res;
        
    }  
    
    /**
     * @return les mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctMoisBySearch(PDO $pdo, $annee, $search)
    {
        $mots = explode(" ", $search);        
        $res = array();
        
        foreach ($mots as $mot) {
            $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_MOIS.
                                                    ' FROM '.Article::TABLENAME.
                                                    ' WHERE ('.Article::FIELDNAME_CONTENU.' LIKE "%'.$mot.'%" OR '.Article::FIELDNAME_TITRE.' LIKE "%'.$mot.'%" )'.
                                                    ' AND '.Article::FIELDNAME_ANNEE.' = ?'.
                                                    ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                    ' ORDER BY '.Article::FIELDNAME_MOIS.' DESC');
                                                    
            if (!$pdoStatement->execute(array($annee))) {
                throw new Exception('Erreur lors du chargement de l article depuis la base de données');
            }

            $res = array_merge($res, $pdoStatement->fetchAll());
        }

        return $res;
    }  
    
    /**
     * @return les jours d'un mois d'une année où il y a eu des articles;
     */
    public static function selectDistinctJoursBySearch(PDO $pdo, $annee, $mois, $search)
    {
        $mots = explode(" ", $search);        
        $res = array();
        
        foreach ($mots as $mot) {
            $pdoStatement = $pdo->prepare('SELECT DISTINCT '.Article::FIELDNAME_JOUR.
                                                        ' FROM '.Article::TABLENAME.
                                                        ' WHERE ('.Article::FIELDNAME_CONTENU.' LIKE "%'.$mot.'%" OR '.Article::FIELDNAME_TITRE.' LIKE "%'.$mot.'%" )'.
                                                        ' AND '.Article::FIELDNAME_ANNEE.' = ?'.
                                                        ' AND '.Article::FIELDNAME_MOIS.' = ?'.
                                                        ' AND '.Article::FIELDNAME_PUBLIE.' = 1'.
                                                        ' ORDER BY '.Article::FIELDNAME_JOUR.' DESC');
                                                        
            if (!$pdoStatement->execute(array($annee, $mois))) {
                throw new Exception('Erreur lors du chargement de l article depuis la base de données');
            }

            $res = array_merge($res, $pdoStatement->fetchAll());
        }

        return $res;
    }
    
}

