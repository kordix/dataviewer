<?php
require_once 'db.php';

//REPLACE
// echo $_GET['zam'];

$sth = $dbh->prepare("SELECT d.commande,d.lot,d.chassis,d.codebarre, d.profil,p.descriptio
FROM  detlot d
JOIN profil p ON p.code = d.profil
WHERE d.commande = ? ");
$sth->execute([$_GET['zam']]);

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


