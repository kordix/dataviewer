<?php
require_once 'db.php';

//REPLACE
@$zamowienia = $_GET['zam'];

// echo $zamowienia;

$sth = $dbh->prepare("
SELECT prepalot.commande,prepalot.id,prepalot.index, prepalot.codebarre , detail.dormant,detail.dim1,detail.dim2, detail.caisson AS Rolety,detail.vitrage AS wypełnienieRamy,
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_KONTROLA' LIMIT 1 ) IS NOT NULL,'TAK','')  AS 'KONTROLA',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_OKUWANIE' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'OKUWANIE',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_PILA' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'PILA',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_MONTAZ_SL' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'MontazSlupkow',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_SZKLENIE' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'SZKLENIE',
(SELECT sum(IF(INSTR(travdorm.quinc,'/FIX')>0,0.5,1)) FROM travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND travdorm.ouvrant <> '') AS 'jednostki'
FROM prepalot
join detail on prepalot.commande = detail.commande and prepalot.id = detail.numero and detail.dormanth <> ''
WHERE prepalot.commande IN ($zamowienia) ORDER BY 1,2,3
");
$sth->execute();

@$sth->execute([$_GET['zam']]);



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


