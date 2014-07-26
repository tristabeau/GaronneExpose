<?php

/**
 * @name Commentaire
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Commentaire extends Base_Commentaire
{
    
    /**
     * Charger les 4 derniers commentaires
     * @return Commentaires 
     */
    public static function getRecentCommentaires(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Commentaire::FIELDNAME_DATE." <= CURRENT_TIMESTAMP ", array(Commentaire::FIELDNAME_DATE.' DESC'), 4);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers Commentaires depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }    
    
}

