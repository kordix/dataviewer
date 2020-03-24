<?php
require_once 'db.php';

//REPLACE
@$zamowienia = $_GET['zam'];


$sth = $dbh->prepare("
SELECT d.commande as 'zlecenie',d.chassis as 'pozycja',d.profil,d.descriptio as 'opis',d.dim as 'dlugosc',d.qte as 'ilosc' FROM detlot d WHERE d.commande IN ($zamowienia) ORDER BY 1,2,3
");
$sth->execute();

//@$sth->execute([$_GET['zam']]);


class dummy {

}

$rows = $sth->fetchAll(PDO::FETCH_CLASS, "dummy");

echo json_encode($rows);




 ?>


