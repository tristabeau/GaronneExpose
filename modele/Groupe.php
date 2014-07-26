<?php

/**
 * @name Groupe
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Groupe extends Base_Groupe
{
    
    /**
     * Cherche le groupe par son nom
     * @return Membre 
     */
    public static function selectByNom(PDO $pdo, $nom)
    {
        $pdoStatement = self::_select($pdo,array(Groupe::FIELDNAME_NOM.' = ?'));
        if (!$pdoStatement->execute(array($nom))) {
            throw new Exception('Erreur lors du chargement du groupe depuis la base de données');
        }
        return self::fetchAll($pdo,$pdoStatement);
    }     
    
    
}

