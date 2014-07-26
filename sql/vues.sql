CREATE TABLE `nb_vues` (
    `ip` VARCHAR(30) NOT NULL,
    `fk_idarticle` INT NOT NULL,
    PRIMARY KEY (`ip`, `fk_idarticle`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;