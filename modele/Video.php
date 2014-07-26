<?php

/**
 * @name Video
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Video extends Base_Video
{
    
    /**
     * Charger les 10 dernieres vidéos qui ne sont pas vedettes
     * @return articles 
     */
    public static function getLastVideo(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo, Video::FIELDNAME_PUBLIE.' = 1 AND '.Video::FIELDNAME_VEDETTE.' = 0 AND '.Video::FIELDNAME_DATE." <= CURRENT_TIMESTAMP ", array(Article::FIELDNAME_DATE.' DESC'), 10);

        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des derniers articles depuis la base de données');
        }
        
        return self::fetchAll($pdo,$pdoStatement);
    }
    
}

