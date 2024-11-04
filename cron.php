<?php

$dbhost = '95.173.187.164';
$dbuser = 'foreks';
$dbpass = '!!Frks321!!';
$dbname = 'foreks';

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$conn-set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql3 = "SELECT * FROM tblFidesEndeks WHERE strSembol LIKE 'COMPXR' ";
$result = $conn->query($sql3);

if ($result->num_rows == 0) {
    $sql4 = "INSERT INTO `tblFidesEndeks` (`dtmTarih`, `strSembol`, `dblSon`, `dblKapanis`, `dblEnDusuk`, `dblEnYuksek`, `strKapanisTarihi`, `strSaat`, `dblFarkGunluk`, `dblYuzdeDegisimGunluk`) VALUES ('2018-09-01 04:35:00', 'COMPXR', 0.00, 0.00, 0.00, 0.00, '060215', '215959', 0.00, 0.00)";
    $conn->query($sql4);
}

$sql5 = "SELECT * FROM tblFidesEndeks WHERE strSembol LIKE 'NIKR' ";
$result = $conn->query($sql5);

if ($result->num_rows == 0) {
    $sql6 = "INSERT INTO `tblFidesEndeks` (`dtmTarih`, `strSembol`, `dblSon`, `dblKapanis`, `dblEnDusuk`, `dblEnYuksek`, `strKapanisTarihi`, `strSaat`, `dblFarkGunluk`, `dblYuzdeDegisimGunluk`) VALUES ('2018-09-01 04:35:00', 'NIKR', 0.00, 0.00, 0.00, 0.00, '060215', '215959', 0.00, 0.00)";
    $conn->query($sql6);
}

?>