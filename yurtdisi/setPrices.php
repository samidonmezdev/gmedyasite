<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$dbhost = '95.173.187.164';
$dbuser = 'foreks';
$dbpass = '!!Frks321!!';
$dbname = 'foreks';

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$conn->set_charset("utf8");
  
// Check connection
if ($conn->connect_error) {
    echo("Connection failed: " . $conn->connect_error.'<hr><br>');
} 

$exchanges = array(
	'INDUD' => 'DJI',
	'NDX100R' => 'IXIC',
	'SPXR' => 'GSPC',
	'UKXR' => 'FTSE',
	'HSI,HKG' => 'HSI',
	'DAXR' => 'GDAXI'
);

function getLastPrice($symbol)
{
	$APIKey = 'EAWL447L9RA0F05O';
	$url = 'tmp/'.$symbol.'.json';
	$json = json_decode(file_get_contents($url), true);

	return($json['Global Quote']);
}

foreach($exchanges as $exchange => $symbol)
{
	
	$data1 = getLastPrice($symbol);

	if ($data1['05. price']!='' AND $data1['05. price']!=0) {

		$dtmTarih=date('Y-m-d H:i:s');
		$dblSon=number_format((float)$data1['05. price'], 2, '.', ''); 
		$dblKapanis=number_format((float)$data1['08. previous close'], 2, '.', ''); 
		$dblEnDusuk=number_format((float)$data1['04. low'], 2, '.', ''); 
		$dblEnYuksek=number_format((float)$data1['03. high'], 2, '.', ''); 
		$dblSon=number_format((float)$data1['05. price'], 2, '.', '');
		$dblFarkGunluk=number_format((float)$data1['09. change'], 2, '.', ''); 
		$dblYuzdeDegisimGunluk=number_format((float)$data1['10. change percent'], 2, '.', ''); 
		$strSaat=date("His");
		$strKapanisTarihi = date("dmy", strtotime($data1['07. latest trading day']));

		$sql = "SELECT * FROM tblFidesEndeks WHERE strSembol LIKE '".$exchange."' ";
		$result = $conn->query($sql);

		if ($result->num_rows == 0) {
			$sql1 = "INSERT INTO `tblFidesEndeks` (`dtmTarih`, `strSembol`, `dblSon`, `dblKapanis`, `dblEnDusuk`, `dblEnYuksek`, `strKapanisTarihi`, `strSaat`, `dblFarkGunluk`, `dblYuzdeDegisimGunluk`) VALUES ('".$dtmTarih."', '".$exchange."', '".$dblSon."', '".$dblKapanis."', '".$dblEnDusuk."', '".$dblEnYuksek."', '".$strKapanisTarihi."', '".$strSaat."', '".$dblFarkGunluk."', '".$dblYuzdeDegisimGunluk."');";
			echo($sql1.'<br>');
			//echo "<br><br>";
			$conn->query($sql1);
		}
		else
		{
			$sql2 = "UPDATE `tblFidesEndeks` SET dtmTarih='".$dtmTarih."' , dblSon='".$dblSon."' , dblKapanis='".$dblKapanis."' ,  dblEnDusuk='".$dblEnDusuk."'  , dblEnYuksek='".$dblEnYuksek."', strKapanisTarihi='".$strKapanisTarihi."', strSaat='".$strSaat."', dblFarkGunluk='".$dblFarkGunluk."', dblYuzdeDegisimGunluk='".$dblYuzdeDegisimGunluk."'  WHERE strSembol LIKE '".$exchange."';";
	#		echo($sql2.'<hr>');
			//echo "<br><br>";
			$conn->query($sql2);
		}

	}
	
}

$conn->close();
