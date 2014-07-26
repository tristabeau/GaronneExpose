<?php

/**
 * @name Membre
 * @version 20/02/2014 (dd/mm/yyyy)
 */
class Membre extends Base_Membre
{
    
        /**
     * Cherche le membre par son login
     * @return Membre 
     */
    public static function selectByPseudo(PDO $pdo, $pseudo)
    {
        $pdoStatement = self::_select($pdo,array(Membre::FIELDNAME_PSEUDO.' = ?'));
        if (!$pdoStatement->execute(array($pseudo))) {
            throw new Exception('Erreur lors du chargement des membres depuis la base de données');
        }
        return self::fetchAll($pdo,$pdoStatement);
    }     
    
        /**
     * Cherche le membre par son mail
     * @return Membre 
     */
    public static function selectByMail(PDO $pdo, $mail)
    {
        $pdoStatement = self::_select($pdo,array(Membre::FIELDNAME_MAIL.' = ?'));
        if (!$pdoStatement->execute(array($mail))) {
            throw new Exception('Erreur lors du chargement des membres depuis la base de données');
        }
        return self::fetchAll($pdo,$pdoStatement);
    } 
        
        /**
     * Cherche les membres du staff
     * @return Membre 
     */
    public static function selectStaff(PDO $pdo)
    {
        $pdoStatement = self::_select($pdo,array(Membre::FIELDNAME_GROUPE_IDGROUPE.' != 1'));
        if (!$pdoStatement->execute()) {
            throw new Exception('Erreur lors du chargement des membres depuis la base de données');
        }
        return self::fetchAll($pdo,$pdoStatement);
    } 
    
}

