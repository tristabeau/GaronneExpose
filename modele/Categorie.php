<?php

/**
 * @name Categorie
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Categorie extends Base_Categorie
{
    
    /**
     * Charger les categorie pere
     * @return Categorie 
     */
    public static function getCategoriePere(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo,array(Categorie::FIELDNAME_PERE_IDCATEGORIE.' = 0'), array(Categorie::FIELDNAME_NOM.' DESC'));
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des pers depuis la base de données');
        }
        return self::fetchAll($pdo,$pdoStatement);
    }   
    
}

