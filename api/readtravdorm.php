<?php
require_once 'db.php';

//REPLACE
$zamowienia = $_GET['zam'];

// echo $zamowienia;

$sth = $dbh->prepare("
SELECT  detail.commande as NrZam, detail.numero as pozycja, detail.dormant AS rama, 
detail.systeme as 'system',
travdorm.ouvrant AS 'skrzydlo', 
'travdorm.traverse' AS 'slupekStaly',
travdorm.quinc AS okucie, 
detail.vitrage AS wypelnienieRamy, 
travdorm.vitrage AS wypelnienieSkrzydla, 
'rehdorm.code' AS poszerzenie, 
detail.caisson AS rolety,
'temp' AS ciecia,
'temp' AS szprosy,
'temp' AS nakladkiAlu,
IF(INSTR(travdorm.quinc,'/FIX')>0,0.5,1) AS JednostkiProdukcyjne
,commande.date AS 'data'
FROM commande
join detail ON commande.numero = detail.commande 
JOIN travdorm ON detail.commande = travdorm.commande AND detail.numero = travdorm.chassis
WHERE LENGTH(travdorm.ouvrant)>0 AND detail.commande in ($zamowienia)
ORDER BY 1,2
");
$sth->execute();

$sth->execute([$_GET['zam']]);



//'TEST_1.5S','TEST_1S','TEST_2S','TEST_WIELEPOZYCJ'

//AND (INSTR(d.descriptio,'[SKRZYD') > 0 OR INSTR(d.descriptio,'[RAM') > 0 )
//Z-18-00208

class dummy {

}

$rows = $sth->fetchAll(PDO::FETCH_CLASS, "dummy");

// $results = [];

// $result = $sth->fetchAll(PDO::FETCH_CLASS,"dummy" );
// foreach ($result as $row) {
//     foreach (get_object_vars($row) as $key => $value) {
//     $row->$key = (mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8') 
//             ? $value : iconv('windows-1250', 'utf-8', $value);
//     }
//     $results[] = $row;
// }


// print_r($rows)
echo json_encode($rows);




 ?>


