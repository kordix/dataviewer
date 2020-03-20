<?php
require_once 'db.php';

//REPLACE
$sth = $dbh->prepare("SELECT COUNT(detail.numero) as 'ile',c.date as 'date'
FROM 
commande c
join detail  ON detail.commande = c.numero
WHERE LEFT (c.numero,1)='Z' AND YEAR(c.DATE)=2020 GROUP BY c.date
");
$sth->execute();

class dummy {

}

$rows = $sth->fetchAll(PDO::FETCH_CLASS, "dummy");


// print_r($rows)
echo json_encode($rows);






 ?>


