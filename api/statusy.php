<?php
require_once 'db.php';

//REPLACE
@$zamowienia = $_GET['zam'];


// echo $zamowienia;

//'rehdorm.code' AS poszerzenie, 
//detail.caisson AS rolety,
//travdorm.vitrage AS wypelnienieSkrzydla, 

//travdorm.refcrx as szprosy

//,(SELECT count(*) from detlot where detlot.commande = prepalot.commande and detlot.chassis=prepalot.id and detlot.cintre = 1) as 'Luki'

$sth = $dbh->prepare("
SELECT prepalot.commande,prepalot.id,prepalot.index, prepalot.codebarre ,detail.systeme, systeme.descriptio as 'opisSystemu',detail.dormant,detail.dim1,detail.dim2, detail.caisson AS Rolety,detail.vitrage AS wypełnienieRamy,
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_KONTROLA' LIMIT 1 ) IS NOT NULL,'TAK','')  AS 'KONTROLA',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_OKUWANIE' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'OKUWANIE',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_PILA' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'PILA',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_MONTAZ_SL' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'MontazSlupkow',
IF((SELECT barcode FROM atelier WHERE atelier.commande = prepalot.commande AND atelier.chassis = prepalot.id and poste = 'P_SZKLENIE' LIMIT 1 ) IS NOT NULL,'TAK','') AS 'SZKLENIE',
(SELECT sum(IF(INSTR(travdorm.quinc,'/FIX')>0,0.5,IF(INSTR(travdorm.quinc,'_2S')>0 OR INSTR(travdorm.quinc,'_2P')>0,2,1))) FROM travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND travdorm.ouvrant <> '') AS 'jednostki',
(SELECT count(*) from travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND travdorm.ouvrant <> '' ) as 'iloscskrzydel',
(SELECT SUM(IF(INSTR(travdorm.quinc,'/FIX')>0,0.5, 
IF(INSTR(travdorm.quinc,'_2S')>0 OR instr(travdorm.quinc,'_2P')>0,1.5,
IF( (SELECT count(*) from travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND travdorm.ouvrant <> '' ) > 1 , 0.75 , 1 )
))) FROM travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND travdorm.ouvrant <> '') AS 'jednostki2',
IFNULL((SELECT refcrx from travdorm WHERE travdorm.commande = prepalot.commande AND travdorm.chassis = prepalot.id AND refcrx <> '' LIMIT 1),'') AS 'szprosy',
(SELECT count(*) from rehdorm where rehdorm.commande = prepalot.commande and rehdorm.chassis=prepalot.id) as 'Poszerzenia'
FROM prepalot
join detail on prepalot.commande = detail.commande and prepalot.id = detail.numero and detail.dormanth <> ''
join systeme on systeme.code=detail.systeme
WHERE prepalot.commande IN ($zamowienia) AND prepalot.volet=0 ORDER BY 1,2,3
");
$sth->execute();

// @$sth->execute([$zamowienia]);


class dummy {

}

$rows = $sth->fetchAll(PDO::FETCH_CLASS, "dummy");


echo json_encode($rows);




 ?>


