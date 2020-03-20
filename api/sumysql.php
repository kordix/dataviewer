<?php
require_once 'db.php';

@$zamowienia = $_GET['zam'];

// echo $zamowienia;

$sth = $dbh->prepare("
SELECT detail.commande,detail.numero,detail.qte,
(SELECT SUM(IF(INSTR(quinc,'/FIX')>0,0.5,1) ) FROM travdorm WHERE  travdorm.commande = detail.commande AND travdorm.chassis = detail.numero AND LENGTH(travdorm.ouvrant)>0) AS 'jednosteknasztuke',
(SELECT COUNT(*) FROM atelier WHERE atelier.commande = detail.commande AND atelier.chassis = detail.numero AND atelier.poste = 'P_SZKLENIE') AS 'zrobionesztuki'
FROM detail 
WHERE detail.commande = 'ZAM-20-00004' 

");
$sth->execute();

// $sth->execute([$_GET['zam']]);



class dummy {

}

$rows = $sth->fetchAll(PDO::FETCH_CLASS, "dummy");

echo json_encode($rows);




 ?>


