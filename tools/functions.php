<?php
/***********************************/
/*****   Connection Function  ******/
/***********************************/
function openConnexion()
{
    try {
        return new PDO('mysql:host='.MY_MYSQL_SERVER.';dbname='.MY_MYSQL_DATABASE, MY_MYSQL_LOGIN, MY_MYSQL_PASSWORD);
    } catch( PDOException $Exception ) {
        echo  $Exception->getMessage();
    }

    
}

function random($car) {
    $string = "";
    $chaine = "12345abcdefghijklmnopqrstuvwxyz6789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    srand((double)microtime()*1000000);
    for($i=0; $i<$car; $i++) {
        $string .= $chaine[rand()%strlen($chaine)];
    }
    return $string;
}

function comparer($a, $b) {
  return strcmp($a->getDate(), $b->getDate());
}

function returnFrenchDate($date,$prefix="",$suffix="") {//cette fonction accepte les date au format AAAA-MM-JJ HH:MM
	$tab_month = array(1=>"Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
	$tab_day = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	$tab_date = explode(' ', $date);
	$date_hour = explode(':', $tab_date[1]);
	$tab_dmy = explode('-', $tab_date[0]);
	$jour=($tab_dmy[2])?$prefix." ".$tab_day[date("w", mktime(0, 0, 0, $tab_dmy[1], $tab_dmy[2], $tab_dmy[0]))]." ".$tab_dmy[2]:"";
	$mois=$tab_month[intVal($tab_dmy[1])];
	$annee=$tab_dmy[0];
	$minute=($date_hour[1])?$date_hour[1] : "";
	$heure=($date_hour[0])?$suffix." ".$date_hour[0]."h":"";
	return $jour." ".$mois." ".$annee." ".$heure.$minute;
}

// ---------------------------------------------------
// RÉSUMÉ BRUT d'un texte (HTML ou non) : en fonction du NOMBRE de CARACTERES
function texte_resume_brut($texte, $nbreCar)
{
	$texte = trim(strip_tags($texte));
	if(is_numeric($nbreCar))
	{
		$PointSuspension	= '...';
		$texte			.= ' ';
		$LongueurAvant		= strlen($texte);
		if ($LongueurAvant > $nbreCar) {
			$texte = substr($texte, 0, strpos($texte, ' ', $nbreCar));
			if ($PointSuspension!='') {
				$texte	.= $PointSuspension;
			}
		}
	}
	return $texte;
}

function to_permalink($str)
{
    if ($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') ) {
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    }

    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );

    return $str;

}

function compter_visite($pdo, $article){   
    $query = $pdo->prepare("INSERT INTO nb_vues (ip , fk_idarticle) VALUES (:ip , :idArticle)");    
    $query->execute(array(':ip'   => $_SERVER['REMOTE_ADDR'], ':idArticle' => $article->getIdArticle()));
}

?>